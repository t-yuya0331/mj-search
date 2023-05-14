<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageReceived;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $chat;
    private $user;

    public function __construct(Chat $chat, User $user)
    {
        $this->chat = $chat;
        $this->user = $user;
    }

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showChat($id){
        $chat_user = $this->user->findOrFail($id);

        $messages = Chat::where('sender', $chat_user->id)->where('receiver', Auth::user()->id)->orWhere('receiver', $chat_user->id)->where('sender', Auth::user()->id)->get();

        return view('chats.show')
                ->with('chat_user' ,$chat_user)
                ->with('messages', $messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getMessage($id){
        $receiver = $this->user->findOrFail($id);
        $messages = Message::where(function($query) use ($id){
            $query->where('sender', Auth::user()->id)->where('receiver', $id);
        })->orWhere(function($query) use ($id) {
            $query->where('sender', $id)->where('receiver', Auth::user()->id);
        })->get();

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function send(Request $request)
    {
        $this->chat->sender = $request->sender;
        $this->chat->receiver = $request->receiver;
        $this->chat->message = $request->message;

        $this->chat->save();
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $this->chat->sender = $request->sender;
        $this->chat->receiver = $request->receiver;
        $this->chat->message = $request->message;
        $this->chat->save();

        event(new MessageReceived($request->all()));

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
