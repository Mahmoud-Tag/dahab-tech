<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ContactController extends Controller
{
    public function index()
    {
        return Message::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        Message::create($request->all());

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return response()->noContent();
    }
}
