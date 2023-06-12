<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetChatRequest $request) : JsonResponse
    {
        $data = $request->validate();
        $dataLogin = Auth::user();

        $isPirvate = 1;
        if($request->has('is_private')) {
            $isPirvate = (int)$data['is_private'];
        }

        $chats = Chat::where('is_private', $isPirvate)->hasParticipant($dataLogin0>id)->whereHas('messages')->with('lastMessage.user','participants.user')->latest('updated_at')->get();

        return $this->success($chats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat) : JsonResponse
    {
        $chat->load('lastMessage.user','participants.user');
        return $this->success($chat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
