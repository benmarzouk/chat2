<?php

namespace App\Http\Controllers;

use App\Events\Chat;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

public function  chat(){
    return view ('chat');
}


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat');
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    //public function sendMessage(Request $request,$message)
    //{
        //$user=User::find(Auth::id());
        // event (new Chat($request->message,$user)
    //);
    public function sendMessage()
    {
        $user=User::find(Auth::id());
        event (new Chat($message,$user)
        );
        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
