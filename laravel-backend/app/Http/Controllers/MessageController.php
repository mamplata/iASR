<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all messages from the database
        $messages = Message::all();

        // Return the messages as a JSON response
        return response()->json($messages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Create a new message
        $message = Message::create($validated);

        // Return the created message as a JSON response
        return response()->json($message, 201);  // HTTP 201 Created
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        // Delete the message
        $message->delete();

        // Return a success response
        return response()->json(null, 204);  // HTTP 204 No Content (successful deletion)
    }
}
