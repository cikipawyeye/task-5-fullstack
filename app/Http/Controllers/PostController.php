<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Article::paginate());
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
        $data = $request->validate([
            'title' => 'required',
            'content' => ['required'],
            'category_id' => ['required', 'numeric'],
            'image' => ['nullable', 'image']
        ]);

        $path = null;
        if (isset($data['image'])) {
            $path = $request->file('image')->store('image', 'public');
        }

        try {
            Category::findOrFail($data['category_id']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Invalid category id!'
            ], 422);
        }

        $article = Article::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => $path,
            'category_id' => $data['category_id'],
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'status' => 'ok',
            'article' => $article
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        if ($article->id) {
            return response()->json($article);
        }

        return response()->json('Article not found!', 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        if (!$article->id) {
            return response()->json('Article not found!', 404);
        }

        $data = $request->validate([
            'title' => 'required',
            'content' => ['required'],
            'category_id' => ['required', 'numeric'],
            'image' => ['nullable', 'image'],
        ]);

        $path = $article->image;
        if (isset($data['image'])) {
            Storage::disk('public')->delete($path);
            $path = $request->file('image')->store('image', 'public');
        }

        $article->image = $path;
        $article->title = $data['title'];
        $article->content = $data['content'];
        $article->category_id = $data['category_id'];

        $article->save();

        return response()->json([
            "message" => "ok",
            "data" => $article
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $imagePath = $article->image;
        
        if ($article->delete()) {
            if ($imagePath != null && $imagePath != '') {
                Storage::disk('public')->delete($imagePath);
            }
            return response("ok");
        }

        return response("error deleting article", 500);
    }
}
