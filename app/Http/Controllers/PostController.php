<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\LikePoint;
use App\Image;
use App\Video;
use App\User;
use App\Upvote;
use App\Downvote;
use Illuminate\Support\Facades\Auth;
use JD\Cloudder\Facades\Cloudder;
use App\Comment;
use DB;
class PostController extends Controller
{
    //
    

   public function index(){
        $userid = 2;
    $field = DB::table('qa_posts')
        ->select(
            'qa_posts.postid','qa_posts.content',
            'qa_posts.image','qa_posts.video',
            'qa_posts.upvote_amount','qa_posts.downvote_amount',
            'qa_posts.comment_amount','comments.comment_content'
            )->leftJoin('comments','comments.post_id','=','qa_posts.postid')
        ->where(['qa_posts.userid'=>$userid])
        ->orderBy('qa_posts.postid','asc')->get();
       
        $data = ['status'=>"success", 'data'=>$field];
        // $data = ['status' => "success", 'data' => $field,
        // 'vote_up_amount'=>$upvotecount,
        // 'vote_down_amount'=>$downvotecount];
        return response()->json($data);
    }


    public function show($postid){

        $post = Post::find($postid);
        $data = ['status' => "success", 'data' => $post];
        return response()->json($data);
    }

    public function store(Request $request){
        $contenttype = $request->input('content_type');
        $userid = $request->input('user_id');
        $post = new Post();
         if ($contenttype == 'image'){
            Cloudder::upload($request->file('image'), null);
            $post->image = Cloudder::getResult()['url'];
        
         }
         if ($contenttype == 'video'){
            Cloudder::uploadVideo($request->file('video'), null);
            $post->video = Cloudder::getResult()['url'];
        }
        $post->userid = $request->get('userid');
        $post->content = $request->get('content'); 
        $post->content_type = $contenttype; 
        $post->save();


        $data = ['status' => "success", 'data' => $post];

         return response()->json($data, 201);
    }

    public function update(Request $request, $postid){
        
        $post =Post::find($postid);
        $post->userid = $request->get('userid'); 
        $post->content = $request->get('content'); 
        $post->Upvotes = $request->get('Upvotes');
        $post->downvotes = $request->get('downvotes'); 
        $post->update();

        $data = ['status' => "success", 'data' => $post];
        return response()->json($data);
    }

    public function delete($postid){
        $post = Post::find($postid);
        $post->delete();

        return response()->json($post, 204);
    }

    public function upvote($postid,$userid){
        $loggedin = $userid;
        $userupvote = Upvote::where(['user_id'=>$loggedin, 'post_id'=>$postid])->first();
        $userdownvote = Downvote::where(['user_id'=>$loggedin, 'post_id'=>$postid])->first();
        if (empty($userupvote->user_id) && empty($userdownvote->user_id)) {
                $user_id = $userid;
                $post_id = $postid;
                $upvote = new Upvote;
                $upvote->user_id = $user_id;
                $upvote->post_id = $post_id;
                $upvote->save();

                // countupvote
                $post = Post::where(['postid'=>$postid])->first();
                $post->increment('upvote_amount');
                $post->save();

                $point = new User;
                $post = Post::where(['postid'=>$postid])->first();
                $point->incrementpoint($post->userid);

            $data = ['status' => "success", 'data' => $upvote];
            return response()->json($data);   
        }else{
                return response()->json(['status'=>'failed'], 400);
        }
    }
    public function downvote($postid,$userid){
        
        $loggedin = $userid;
        $userupvote = Upvote::where(['user_id'=>$loggedin, 'post_id'=>$postid])->first();
        $userdownvote = Downvote::where(['user_id'=>$loggedin, 'post_id'=>$postid])->first();
        if (empty($userupvote->user_id) && empty($userdownvote->user_id)) {
                $user_id = $userid;
                $post_id = $postid;
                $dislike = new Downvote;
                $dislike->user_id = $user_id;
                $dislike->post_id = $post_id;
                $dislike->save();

                // count downvote
                $post = Post::where(['postid'=>$postid])->first();
                $post->increment('downvote_amount');
                $post->update();
                  

                // increase user points
                $point = new User;
                $post = Post::where(['postid'=>$postid])->first();
                $point->decrementpoint($post->userid);

                
            $data = ['status' => "success", 'data' => $dislike];
            return response()->json($data);
        }else{
                return response()->json(['status'=>'failed'], 400);
        }

    }

    // 

    public function userpoint(){
        $userpoint = DB::table('userpoints')->select('userpoints.user_id','userpoints.points','users.id')
        ->join('users','users.id','=','userpoints.user_id')->get();
        $data = ['status' => "success", 'data' => $userpoint];
        return response()->json($data);


        
    }
    
    public function addcomment(Request $request,$postid){
        // $userid = 2;

        $comment = new Comment;
        $comment->user_id = $request->get('userid');
        $comment->post_id = $postid;
        $comment->comment_content = $request->get('comment_content');
        $comment->save();

        // $post = Post::where(['postid'=>$postid])->first();
        // $post->userid = $request->input('userid');
        // $post->parentid = $postid;
        // $post->content = $request->input('content');
        // $post->increment('comment_amount');
        // $post->save();

        $post = Post::where(['postid'=>$postid])->first();
        $post->increment('comment_amount');
        $post->update();

        // count downvote
        // $post = Post::where(['postid'=>$postid])->first();
        // $post->increment('downvote_amount');
        // $post->update();
        // give a point
        $point = new User;
        $post = Post::where(['postid'=>$postid])->first();
        $point->incrementpoint($post->userid);

        $data = ['status'=>'success', 'data'=>$comment];

        return response()->json($data);
    }
    public function getcomment($postid){
        $comment = Comment::where(['post_id'=>$postid])->get();
        $data = ['status'=>'success', 'data'=>$comment];

        return response()->json($data);
    }

    // public function countupvote($postid){
    //     $countupvote = Upvote::where('post_id',$postid)->count();
                
    //     $data = ['status' => "success", 'data' => $countupvote];
    //             return response()->json($data);
    // }

    //  public function countdownvote($postid){
    //     $countdownvote = Downvote::where('post_id',$postid)->count();
                
    //     $data = ['status' => "success", 'data' => $countdownvote];
    //             return response()->json($data);
    // }
    
}
