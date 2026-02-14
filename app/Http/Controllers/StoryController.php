<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StoryController extends Controller
{
    public function index() {

        # get the stories of users which are not expire till now

        $stories = Story::with('user')
        ->active()
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('user_id');

        return response()->json($stories);

    }

    public function store(Request $request) {

        # store all the stories which are being uploaded (vedios and images both handles here)

        $request->validate([
            'media.*' => 'required|file|mimes:jpg,jpeg,png,mp4,mov|max:50000',
        ]);

        $uploadedStories = [];

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $extension = $file->getClientOriginalExtension();
                $type = in_array($extension, ['mp4', 'mov']) ? 'video' : 'image';
                
                $path = $file->store('stories', 'public');

                $story = Story::create([
                    'user_id' => auth()->id(),
                    'media_path' => Storage::url($path),
                    'type' => $type,
                    'expires_at' => Carbon::now()->addHours(24),
                ]);
                $uploadedStories[] = $story;
            }
        }

        return response()->json(['success' => true, 'data' => $uploadedStories]);
    }
}
