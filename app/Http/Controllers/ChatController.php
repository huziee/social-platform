<?php 
// app/Http/Controllers/ChatController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat($id = null)
    {
        $authId = auth()->id();
        
        // Fetch all users except the logged-in user (The Sidebar)
        $users = User::where('id', '!=', $authId)
    ->withCount(['messagesSent as unread_count' => function ($q) use ($authId) {
        $q->where('receiver_id', $authId)
          ->where('is_read', 0);
    }])
    ->get();

        $messages = [];
        $selectedUser = null;

        if ($id) {
            $selectedUser = User::findOrFail($id);
            // Fetch conversation between Auth user and Selected user
            $messages = Message::where(function($q) use ($authId, $id) {
                $q->where('sender_id', $authId)->where('receiver_id', $id);
            })->orWhere(function($q) use ($authId, $id) {
                $q->where('sender_id', $id)->where('receiver_id', $authId);
            })->orderBy('created_at', 'asc')->get();
            
            // Mark messages as read
            Message::where('sender_id', $id)->where('receiver_id', $authId)->update(['is_read' => true]);
        }

        return view('main.content.messages.index', compact('users', 'messages', 'selectedUser'));
    }

    public function sendMessage(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'body' => 'required|string|max:2000'
    ]);

    $message = Message::create([
        'sender_id' => auth()->id(),
        'receiver_id' => $request->receiver_id,
        'body' => $request->body,
        'is_read' => false
    ]);

    return response()->json($message);
}
}