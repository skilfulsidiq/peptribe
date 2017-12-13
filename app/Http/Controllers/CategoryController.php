<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    //

    public function index(){

    	$categories = Category::all();
    	$data = ['status' => "success", 'data' => $categories];
    	return response()->json($data);
    }

    public function show($id){

    	$category =  Category::find($id);
    	$data = ['status' => "success", 'data' => $category];
    	return response()->json($date);
    }


    public function store(Request $request){
    	$category =  Category::create($request->all());

    	  return response()->json($category, 201);
    }

    public function update(Request $request, $id){
    	$category = Category::find($id);
    	$category->update($request->all());

    	return response()->json($category, 200);
    }

    public function delete($id){
    	$category = Category::find($id);
    	$category->delete();

    	return response()->json(null, 204);
    }
}
