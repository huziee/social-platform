<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $userBlogs = Blog::with('user')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $allBlogs = Blog::with('user')->latest()->take(5)->get();

        return view('main.content.blogs.index', compact('userBlogs', 'allBlogs'));
    }

    public function create()
    {
        return view('main.content.blogs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('assets/images/blogs');
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            $image->move($destination, $filename);
            $data['image'] = $filename;
        }

        $blog = Blog::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'blog' => [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'category' => $blog->category,
                    'start_date' => $blog->start_date,
                    'location' => $blog->location,
                    'image' => $blog->image ? asset('assets/images/blogs/' . $blog->image) : asset('assets/images/post/16by9/big/03.jpg'),
                    'url' => route('blogs.show', $blog),
                    'author' => auth()->user()->username,
                ],
                'toast' => [
                    'type' => 'success',
                    'title' => 'Blog Created',
                    'message' => 'Created by @' . auth()->user()->username . '.',
                ],
            ]);
        }

        return redirect()->route('blogs.show', $blog)->with('toast', [
            'type' => 'success',
            'title' => 'Blog Created',
            'message' => 'Your blog was created successfully.'
        ]);
    }

    public function show(Blog $blog)
    {
        $blog->load('user');
        return view('main.content.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        if ($blog->user_id !== auth()->id()) {
            abort(403);
        }
        if (request()->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'blog' => [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'category' => $blog->category,
                    'description' => $blog->description,
                    'location' => $blog->location,
                    'start_date' => $blog->start_date,
                    'end_date' => $blog->end_date,
                    'image' => $blog->image ? asset('assets/images/blogs/' . $blog->image) : null,
                ],
            ]);
        }

        return redirect()->route('blogs.index');
    }

    public function update(Request $request, Blog $blog)
    {
        if ($blog->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('assets/images/blogs');
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            if ($blog->image && file_exists($destination . '/' . $blog->image)) {
                unlink($destination . '/' . $blog->image);
            }
            $image->move($destination, $filename);
            $data['image'] = $filename;
        }

        $blog->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'blog' => [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'category' => $blog->category,
                    'description' => $blog->description,
                    'location' => $blog->location,
                    'start_date' => $blog->start_date,
                    'end_date' => $blog->end_date,
                    'image' => $blog->image ? asset('assets/images/blogs/' . $blog->image) : asset('assets/images/post/16by9/big/03.jpg'),
                    'url' => route('blogs.show', $blog),
                    'author' => auth()->user()->username,
                ],
                'toast' => [
                    'type' => 'success',
                    'title' => 'Blog Updated',
                    'message' => 'Updated by @' . auth()->user()->username . '.',
                ],
            ]);
        }

        return redirect()->route('blogs.show', $blog)->with('toast', [
            'type' => 'success',
            'title' => 'Blog Updated',
            'message' => 'Your changes were saved.'
        ]);
    }

    public function destroy(Blog $blog)
    {
        if ($blog->user_id !== auth()->id()) {
            abort(403);
        }

        if ($blog->image) {
            $path = public_path('assets/images/blogs/' . $blog->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $blog->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'id' => $blog->id,
                'author' => auth()->user()->username,
                'toast' => [
                    'type' => 'warning',
                    'title' => 'Blog Deleted',
                    'message' => 'Deleted by @' . auth()->user()->username . '.',
                ],
            ]);
        }

        return redirect()->route('blogs.index')->with('toast', [
            'type' => 'warning',
            'title' => 'Blog Deleted',
            'message' => 'Your blog was deleted.'
        ]);
    }
}
