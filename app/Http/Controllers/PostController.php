<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\LikePoint;
use App\Image;
use App\Video;
use App\Upvote;
use App\Downvote;
use Auth;
use JD\Cloudder\Facades\Cloudder;
use Socialite;
class PostController extends Controller
{
    //

    public function index(){

    	$posts =Post::all();
    	$data = ['status' => "success", 'data' => $posts];
    	return response()->json($data);
    }

    public function show($postid){

    	$post = Post::find($postid);
    	$data = ['status' => "success", 'data' => $post];
    	return response()->json($data);
    }

    public function store(Request $request){
    	$post = new Post();

    // 	if ("it is image"){
	  	// $image = new Image();
    //     Cloudder::upload($request->file('image'), null);
    //     $image->image = Cloudder::getResult()['url'];
    //     $image->post_id = $postid;
    //     }

    //     if ("it is video"){
	  	// $video = new Video();
    //     Cloudder::upload($request->file('video'), null);
    //     $video->video = Cloudder::getResult()['url'];
    //     $video->post_id = $postid;
    //     }

    	$post->userid = $request->get('userid'); 
    	$post->content = $request->get('content'); 
    	
    	$post->parentid = $request->get('postid'); 
    	
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

    	return response()->json($post.'deleted', 204);
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

    			$selectpoint = LikePoint::where(['post_id'=>$post_id])->first();
    			
    			if (empty($selectpoint->post_id)) {
    				$point = new LikePoint;
    				$point->post_id = $post_id;
    				$point->points += 1;
    				$point->save();
    			}else{
    				$selectpost = LikePoint::find($postid);
    				$selectpost->points +=1;
    				$selectpost->save();
    			}
    		 

    			
    			$data = ['status' => "success", 'data' => $upvote];
    			return response()->json($data);

    			
    	}else{
    		// $data = ['status' => "success", 'data' => $upvote];
    			return response()->json(null, 400);
    	}
    }
    public function downvote($postid){
    	
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
    			$data = ['status' => "success", 'data' => $dislike];
    			return response()->json($data);
    	}else{
    		// $data = ['status' => "success", 'data' => $upvote];
    			return response()->json(null,400);
    	}

    }

    public function countupvote($postid){
    	$countupvote = Upvote::where('post_id',$postid)->count();
    			
    	$data = ['status' => "success", 'data' => $countupvote];
    			return response()->json($data);
    }

     public function countdownvote($postid){
    	$countdownvote = Downvote::where('post_id',$postid)->count();
    			
    	$data = ['status' => "success", 'data' => $countdownvote];
    			return response()->json($data);
    }

    // social login

    

    
}
