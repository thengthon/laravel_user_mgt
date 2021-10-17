<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::with(['comment'])->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:200',
            'body' => 'required|min:3|max:20000'
        ]);
        
        $post = new Post();
        $post->user_id = $request->user_id;
        $post->title = $request->title;
        $post->body = $request->body;

        $post->save();
        return response()->json(['Message' => 'Post Created', 'Post' => $post], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::with(['comment'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3|max:200',
            'body' => 'required|min:3|max:20000'
        ]);
        
        $post = Post::findOrFail($id);
        $post->user_id = $request->user_id;
        $post->title = $request->title;
        $post->body = $request->body;

        $post->save();
        return response()->json(['Message' => 'Post Updated', 'Updated Post' => $post], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = Post::destroy($id);
        if($isDeleted) {
            return response()->json(['Message' => 'Post is deleted'], 200);
        } else {
            return response()->json(['Message' => 'POST ID NOT FOUND'], 404);
        }
    }
}