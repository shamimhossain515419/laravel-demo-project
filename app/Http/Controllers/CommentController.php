<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends HelperController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return $this->sendResponse($comments, 'Comment  fetched successfully.', 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create([
            'body' => $request->body,
            'added_by' => $request->user()->id,
            'post_id' => $request->post_id,
        ]);

        return $this->sendResponse($comment, 'Comment created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        // Eager load the associated post and user for the given comment
        $commentWithRelations = $comment->load(['post', 'user']); // Assuming the relationships in the Comment model are named 'post' and 'user'

        // Return the comment with the associated post and user
        return $this->sendResponse($commentWithRelations, 'Single Comment fetched successfully.', 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
