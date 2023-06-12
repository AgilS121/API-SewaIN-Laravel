<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Resources\ConversationResorce;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $dataLogin = Auth::User();
        // dd($dataLogin);
        $conversations = Conversation::where('id_user',Auth::user()->id_users)->orWhere('encode_id_user',Auth::user()->id_users)->orderBy('updated_at', 'desc')->get();

        $count = count($conversations);

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                if ($conversation[$i]->messages->last()->id < $conversation[$j]->messages->last()->id);
                $temp = $conversation[$i];
                $conversation[$i] = $conversation[$j];
                $conversation[$j] = $temp;
            }
        }

        return ConversationResorce::collection($conversations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    function makConversationAsRead(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required'
        ]);

        $conversation = Conversation::findOrFail($request['conversation_id']);

        foreach ($conversation->messages as $message)
        {
            $message->update(['read' => true]);
        }

        return response()->json('success', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'message' => 'required'
        ]);

        $conversation = Conversation::create([
            'id_user' => Auth::user()->id_users,
            // dd($request['id_user']),
            'encode_id_user' => $request['id_user']
        ]);

        Message::create([
            'body' => $request['message'],
            'id_users' => Auth::user()->id_users,
            'conversation_id' => $conversation->id,
            'read' => false,
        ]);

        return new ConversationResorce($conversation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
