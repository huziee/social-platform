<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\PostMedia;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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

            'videos' => 'nullable|array',
            'videos.*' => 'mimes:mp4,mov,avi,webm|max:20480', // 20MB
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'caption' => $request->caption,
        ]);

        // 2. Combine files from both inputs or a single "media" array
    // If you use the ordered JavaScript approach from the previous step:
    if ($request->hasFile('media')) {
        $manager = new ImageManager(new Driver());

        foreach ($request->file('media') as $file) {
            $mime = $file->getMimeType();
            
            if (str_contains($mime, 'image')) {
                // IMAGE PROCESSING
                $filename = time() . '_' . Str::random(10) . '.jpg';
                $path = public_path('assets/images/posts/' . $filename);
                $img = $manager->read($file);
                $img->cover(1080, 1080); 
                $img->save($path, 85);

                PostMedia::create([
                    'post_id' => $post->id,
                    'type'    => 'image',
                    'file_path' => 'assets/images/posts/' . $filename
                ]);
            } elseif (str_contains($mime, 'video')) {
                // VIDEO PROCESSING
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/videos/posts'), $filename);

                PostMedia::create([
                    'post_id' => $post->id,
                    'type'    => 'video',
                    'file_path' => 'assets/videos/posts/' . $filename
                ]);
            }
        }
    }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {

                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // $image->move(public_path('assets/images/posts'), $filename);

                $manager = new ImageManager(new Driver());

                $filename = time() . '_' . Str::random(10) . '.jpg';

                $path = public_path('assets/images/posts/' . $filename);

                $img = $manager->read($image);

                /* 🔥 CREATE SQUARE IMAGE */
                $img->cover(1080, 1080);   // Instagram style

                $img->save($path, 85);

                PostMedia::create([
                    'post_id' => $post->id,
                    'type' => 'image',
                    'file_path' => 'assets/images/posts/' . $filename
                ]);
            }
        }

        // SAVE VIDEOS
        if ($request->hasFile('videos')) {

            foreach ($request->file('videos') as $video) {

                $filename = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();

                $video->move(public_path('assets/videos/posts'), $filename);

                PostMedia::create([
                    'post_id' => $post->id,
                    'type' => 'video',
                    'file_path' => 'assets/videos/posts/' . $filename
                ]);
            }
        }

        // 3. Load media sorted by ID (which matches the upload order)
    $post->load(['media' => function($q) {
        $q->orderBy('id', 'asc');
    }, 'user']);

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
                $img = PostMedia::where('type', 'image')->find($imgId);
                if ($img && file_exists(public_path($img->file_path)))
                    unlink(public_path($img->file_path));
                $img?->delete();
            }
        }

        // Handle replaced images
        if ($request->replaced_images) {
            foreach ($request->replaced_images as $imgId => $file) {
                $img = PostMedia::where('type', 'image')->find($imgId);
                if ($img) {
                    // Delete old image
                    if ($img->file_path && file_exists(public_path($img->file_path)))
                        unlink(public_path($img->file_path));

                    // Save new image
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('assets/images/posts'), $filename);
                    $img->update(['file_path' => 'assets/images/posts/' . $filename]);
                }
            }
        }
        // Replace videos
        if ($request->replaced_videos) {

            foreach ($request->replaced_videos as $videoId => $file) {

                $video = PostMedia::where('type', 'video')->find($videoId);

                if ($video) {

                    // Delete old file
                    if ($video->file_path && file_exists(public_path($video->file_path))) {
                        unlink(public_path($video->file_path));
                    }

                    // Save new video
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    $file->move(public_path('assets/videos/posts'), $filename);

                    $video->update([
                        'file_path' => 'assets/videos/posts/' . $filename
                    ]);
                }
            }
        }

        // IMPORTANT: Refresh the relationship to exclude deleted images 
        // and include updated file paths.
        $post->refresh();

        $images = $post->media->where('type', 'image')->map(function ($img) {
            return [
                'id' => $img->id,
                'url' => asset($img->file_path)
            ];
        })->values(); // Use values() to reset keys for JSON array

        $videos = $post->media->where('type', 'video')->map(function ($vid) {
            return [
                'id' => $vid->id,
                'url' => asset($vid->file_path)
            ];
        })->values();

        return response()->json([
            'success' => true,
            'images' => $images,
            'videos' => $videos, // Send videos back!
            'caption' => $post->caption
        ]);
    }




    public function edit($postId)
    {
        $post = Post::with(['images', 'videos'])->findOrFail($postId); // ✅ include videos

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
            if ($img->file_path && file_exists(public_path($img->file_path))) {
                unlink(public_path($img->file_path));
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

    public function preview($id)
    {
        $post = Post::with(['media', 'user', 'likes', 'comments.user'])->findOrFail($id);

        return response()->json([
            'html' => view('main.post_card.index', ['post' => $post])->render(),
        ]);
    }

    public function deleteImage($id)
    {
        $image = PostMedia::where('type', 'image')->findOrFail($id);

        if ($image->file_path && file_exists(public_path($image->file_path))) {
            unlink(public_path($image->file_path));
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

        $image = PostMedia::where('type', 'image')->findOrFail($id);


        /* DELETE OLD IMAGE */
        if ($image->file_path && file_exists(public_path($image->file_path))) {
            unlink(public_path($image->file_path));
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
            'file_path' => 'assets/images/posts/' . $filename
        ]);

        return response()->json([
            'url' => asset('assets/images/posts/' . $filename)
        ]);
    }





}
