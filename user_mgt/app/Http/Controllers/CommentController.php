<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comment::latest()->get();
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
            'comment' => 'required'
        ]);
        
        $cmt = new Comment();
        $cmt->user_id = $request->user_id;
        $cmt->post_id = $request->post_id;
        $cmt->comment = $request->comment;

        $cmt->save();
        return response()->json(['Message' => 'Comment Created', 'Comment' => $cmt], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Comment::findOrFail($id);
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
            'comment' => 'required'
        ]);
        
        $cmt = Comment::findOrFail($id);
        $cmt->user_id = $request->user_id;
        $cmt->post_id = $request->post_id;
        $cmt->comment = $request->comment;

        $cmt->save();
        return response()->json(['Message' => 'Comment Updated', 'Updated Comment' => $cmt], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = Comment::destroy($id);
        if($isDeleted) {
            return response()->json(['Message' => 'Comment is deleted'], 200);
        } else {
            return response()->json(['Message' => 'COMMENT ID NOT FOUND'], 404);
        }
    }
}