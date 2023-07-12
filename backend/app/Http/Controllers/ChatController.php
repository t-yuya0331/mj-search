<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageReceived;

class ChatController extends Controller
{
    private $chat;
    private $user;

    public function __construct(Chat $chat, User $user)
    {
        $this->chat = $chat;
        $this->user = $user;
    }

    public function showChat($id){
        $chat_user = $this->user->findOrFail($id);

        $messages = Chat::where('sender', $chat_user->id)
                        ->where('receiver', Auth::user()->id)
                        ->orWhere('receiver', $chat_user->id)
                        ->where('sender', Auth::user()->id)
                        ->orderBy('created_at', 'asc')
                        ->get();

        return view('chats.show')
                ->with('chat_user' ,$chat_user)
                ->with('messages', $messages);
}


    public function store(Request $request){
        $this->chat->sender = $request->sender;
        $this->chat->receiver = $request->receiver;
        $this->chat->message = $request->message;
        $this->chat->save();

        event(new MessageReceived($request->all()));

        return response()->json(['success' => true]);
}

    public function getChattedUser(){
        $user = Auth::user();
        $chattedUserIds = Chat::whereIn('sender', [$user->id])
            ->orWhereIn('receiver', [$user->id])
            ->pluck('sender')
            ->merge(Chat::whereIn('receiver', [$user->id])
                ->orWhereIn('sender', [$user->id])
                ->pluck('receiver'))
            ->unique();

        $chattedUsers = User::whereIn('id', $chattedUserIds)->get();

        return view('chats.chat_list')->with('chattedUsers', $chattedUsers);
}

}
