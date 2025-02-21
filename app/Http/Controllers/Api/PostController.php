<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Laravel Todo API Documentation",
 *     description="Dokumentasi API untuk manajemen posting to-do list",
 *     @OA\Contact(
 *         email="haikalridha07@gmail.com"
 *     )
 * )
 */

class PostController extends Controller
{
    
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     operationId="getPostsList",
     *     tags={"Posts"},
     *     summary="Get list of posts",
     *     description="Returns list of posts",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")
     *         ),
     *     ),
     * )
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     operationId="storePost",
     *     tags={"Posts"},
     *     summary="Create new post",
     *     description="Creates a new post",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'brand' => 'required|string',
            'platform' => 'required|string',
            'due_date' => 'required|date',
            'payment' => 'required|numeric',
            'status' => 'required|in:pending,completed',
        ]);

        $post = Post::create($validatedData);
        return response()->json($post, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     operationId="getPostById",
     *     tags={"Posts"},
     *     summary="Get single post",
     *     description="Returns a single post by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of post to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(response=404, description="Post not found")
     * )
     */
    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        return response()->json($post);
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     operationId="updatePost",
     *     tags={"Posts"},
     *     summary="Update an existing post",
     *     description="Updates a post by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of post to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(response=404, description="Post not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string',
            'brand' => 'sometimes|required|string',
            'platform' => 'sometimes|required|string',
            'due_date' => 'sometimes|required|date',
            'payment' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|in:pending,completed',
        ]);

        $post->update($validatedData);
        return response()->json($post);
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     operationId="deletePost",
     *     tags={"Posts"},
     *     summary="Delete a post",
     *     description="Deletes a post by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of post to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post deleted successfully"
     *     ),
     *     @OA\Response(response=404, description="Post not found")
     * )
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->delete();
        return response()->json(null, 204);
    }
}
