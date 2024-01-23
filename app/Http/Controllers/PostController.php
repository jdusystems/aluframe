<?php

namespace App\Http\Controllers;


use App\Http\Resources\ShowPostResource;
use App\Http\Resources\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return new PostCollection($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;

        if($post->save()){
            return new ShowPostResource($post);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new ShowPostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post->title = $request->title;
        $post->description = $request->description;
        if($post->save()){
            return new ShowPostResource($post);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
         if($post->delete){
             return response()->json(null, 204);
         }else{
             return response()->json(null, 204);
         }
    }
}
