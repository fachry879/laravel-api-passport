<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    //tampil semua data

    public function index()
    {
        //get data from table posts
        $posts = Post::get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data'    => $posts
        ], 200);

    }

     //tampil detail data

    public function show($id)
    {
        //find post by ID
        $post = Post::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $post
        ], 200);

    }

    // input data

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $post = Post::create([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        //success save to database
        if($post) {

            return response()->json([
                'success' => true,
                'message' => 'Post Created',
                'data'    => $post
            ], 201);

        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Post Failed to Save',
        ], 409);

    }

    // update data

    public function update(Request $request, Post $post)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $post = Post::findOrFail($post->id);

        if($post) {

            //update post
            $post->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $post
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);

    }

    // delete data
    public function destroy($id)
    {
        //find post by ID
        $post = Post::findOrfail($id);

        if($post) {

            //delete post
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post Deleted',
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }

}
