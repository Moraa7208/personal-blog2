<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category')->paginate(20);
        return view('admin.post.index', compact('posts'));
    }
    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $categories = Category::all();
        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tags = explode(',', $request->tags);

        if ($request->has('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads', $filename, 'public');
        }
        
        $post= auth()->user()->posts()->create([
            'title' => $request->title,
            'image' => $validated['image_path'] ?? null,
            'post' => $request->post,
            'category_id' => $request->category
        ]);

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
            $post->tags()->attach($tag);
        }

        return redirect()->route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = $post->tags->implode('name', ', ');
        return view('admin.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $tags = explode(',', $request->tags);

        if ($request->has('image')) {
            Storage::delete('public/uploads/' . $post->image);
            
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads', $filename, 'public');
        }

        $post->update([
            'title' => $request->title,
            'image' => $filename ?? $post->image,
            'post' => $request->post,
            'category_id' => $request->category
        ]);

        $newTags = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
            array_push($newTags, $tag->id);
        }
        $post->tags()->sync($newTags);

        return redirect()->route('admin.posts.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete('public/uploads/' . $post->image);
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index');

    }
}
