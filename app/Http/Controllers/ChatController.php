<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Message;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $message = new Message;
        $message->sender = $request->sender;
        $message->recipient = $request->recipient;
        $message->message = $request->message;
        $message->save();

        event(new MessageSent($message));

        return response()->json(['status' => 'Message sent!']);
    }
}
