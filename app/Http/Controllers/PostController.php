<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\PostImage;
use function Pest\Laravel\json;
use function Pest\Laravel\post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('images', 'user')->latest()->get();
        $user = User::latest()->get();
        return view('main.content.home.index', compact('posts', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'caption' => $request->caption,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {

                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('assets/images/posts'), $filename);

                $post->images()->create([
                    'image' => 'assets/images/posts/' . $filename
                ]);
            }
        }

        $post->load('images', 'user');

        return response()->json([
            'success' => true,
            'html' => view('main.post_card.index', ['post' => $post])->render()
        ]);
    }

    public function updateModal(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (auth()->id() !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->update(['caption' => $request->caption]);

        // Handle deleted images
        if ($request->deleted_images) {
            foreach ($request->deleted_images as $imgId) {
                $img = PostImage::find($imgId);
                if ($img && file_exists(public_path($img->image)))
                    unlink(public_path($img->image));
                $img?->delete();
            }
        }

        // Handle replaced images
        if ($request->replaced_images) {
            foreach ($request->replaced_images as $imgId => $file) {
                $img = PostImage::find($imgId);
                if ($img) {
                    // Delete old image
                    if ($img->image && file_exists(public_path($img->image)))
                        unlink(public_path($img->image));

                    // Save new image
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/images/posts'), $filename);
                    $img->update(['image' => 'assets/images/posts/' . $filename]);
                }
            }
        }

        // IMPORTANT: Refresh the relationship to exclude deleted images 
        // and include updated file paths.
        $post->refresh();

        $images = $post->images->map(function ($img) {
            return [
                'id' => $img->id,
                'url' => asset($img->image)
            ];
        });

        return response()->json([
            'success' => true,
            'images' => $images,
            'caption' => $post->caption // Also return caption just in case
        ]);
    }




    public function edit($postId)
    {
        $post = Post::with('images')->findOrFail($postId);
        if (auth()->id() !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'post' => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string'
        ]);

        $post = Post::findOrFail($id);

        if (auth()->id() !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->update([
            'caption' => $request->caption
        ]);

        return response()->json([
            'success' => true,
            'caption' => $post->caption
        ]);
    }

    public function destroy($postId)
    {
        $post = Post::with('images')->findOrFail($postId);

        // Security Check
        if (auth()->id() !== $post->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // 1. Delete physical image files from the server
        foreach ($post->images as $img) {
            if ($img->image && file_exists(public_path($img->image))) {
                unlink(public_path($img->image));
            }
        }

        // 2. Delete database records (Post and related PostImages)
        // If you have 'onDelete(cascade)' in your migration, $post->delete() is enough.
        // Otherwise, delete images explicitly first.
        $post->images()->delete();
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    }

    public function deleteImage($id)
    {
        $image = PostImage::findOrFail($id);

        if ($image->image && file_exists(public_path($image->image))) {
            unlink(public_path($image->image));
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'image_id' => $id
        ]);
    }
    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $image = PostImage::findOrFail($id);

        /* DELETE OLD IMAGE */
        if ($image->image && file_exists(public_path($image->image))) {
            unlink(public_path($image->image));
        }

        /* SAVE NEW IMAGE */
        $file = $request->file('image');

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $file->move(
            public_path('assets/images/posts'),
            $filename
        );

        /* UPDATE DB PATH */
        $image->update([
            'image' => 'assets/images/posts/' . $filename
        ]);

        return response()->json([
            'url' => asset('assets/images/posts/' . $filename)
        ]);
    }





}
