<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\DB;

class PostController extends HelperController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the search term from the request
        $search = request()->query('search');

        // Query posts, eager load 'category', and apply global search if search is provided
        $postsQuery = Post::with('category')->orderBy('created_at', 'desc');

        if ($search) {
            // Apply global search across multiple fields
            $postsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results
        $posts = $postsQuery->paginate(10);

        // Return the posts with a success message
        return $this->sendResponse($posts, 'Posts fetched successfully.', 201);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // Validate and retrieve the validated data
        $validated = $request->validated();

        try {
            // Add the current authenticated user's ID to the validated data
            $validated["added_by"] = auth()->id();

            // Create the post using the validated data
            $posts = Post::create($validated);

            // Respond with a structured success message
            return $this->sendResponse($posts, 'Post created successfully.', 201);
        } catch (\Exception $e) {
            // If any error occurs, respond with an error message
            return $this->sendError('Post creation failed.', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Eager load the category, user, and comments relationships
        $postWithRelations = $post->load(['category', 'user', 'comments.user']); // Load comments with their associated user

        // Respond with the post data, including comments
        return $this->sendResponse($postWithRelations, 'Single Post fetched successfully.', 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post = Post::find($post->id);
        $result = $post->delete();
        return $this->sendResponse($result, 'Post delete successfully.', 201);
    }
}
