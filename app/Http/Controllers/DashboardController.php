<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home', [
            'articles' => Article::latest()->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.create', [
            "categories" => Category::all()
        ]);
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

        Article::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => $path,
            'category_id' => $data['category_id'],
            'user_id' => Auth::user()->id
        ]);

        return redirect('home')->with('status', "Insert data success!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        // dd($article);
        return view('show', ['article' => $article]);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('dashboard/edit', [
            'article' => $article,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
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

            $article->title = $data['title'];
            $article->content = $data['content'];
            $article->image = $path;
            $article->category_id = $data['category_id'];
            $article->user_id = Auth::user()->id;

            $article->save();

        return redirect('home')->with('status', "Update data success!");
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
            return redirect('home')->with('status', "Delete data success!");
        }

        return redirect('home')->with('status', "Delete data failed!");
    }
}
