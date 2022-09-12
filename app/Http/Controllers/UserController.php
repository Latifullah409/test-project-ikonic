<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($type){

        if($type == 'suggestion'){

            $sentRequest = UserRequest::where('sender_id',auth()->user()->id)->pluck('receiver_id')->toArray();
            $receiveRequest = UserRequest::where('receiver_id',auth()->user()->id)->whereIn('status',[0,1])->pluck('sender_id')->toArray();
            $sentOrReceiveRequest = array_merge($sentRequest,$receiveRequest);
            //show all suggestions users
            $suggestions = User::whereNotIn('id',$sentOrReceiveRequest)->whereNot('id',auth()->user()->id)->get();
            $suggestionsHtml = '';
            foreach($suggestions as $sug){
                $suggestionsHtml .= view('components.suggestion', compact('sug'))->render();
            }
            return response()->json(['users' => $suggestionsHtml,'count' => $suggestions->count(),'suggestions_tab' => true,'btn_name' => 'get_suggestions_btn', 'text' => 'Suggestions']);

        }else if($type == 'sent'){

            $receivedRequestIds = UserRequest::where('status',0)->where('sender_id',auth()->user()->id)->whereNot('receiver_id',auth()->user()->id)->pluck('receiver_id')->toArray();
            $sentRequest = User::whereNot('id',auth()->user()->id)->whereIn('id',$receivedRequestIds)->get();
            $sentRequestHtml = '';
            $mode = $type;
            foreach($sentRequest as $user){
                $sentRequestHtml .= view('components.request', compact('user','mode'))->render();
            }
            return response()->json(['users' => $sentRequestHtml,'count' => $sentRequest->count(),'sent_tab' => true, 'btn_name' => 'get_sent_requests_btn', 'text' => 'Sent Requests']);

        }else if($type == 'receive'){

            $sentRequestIds = UserRequest::where('status',0)->where('receiver_id',auth()->user()->id)->whereNot('sender_id',auth()->user()->id)->pluck('sender_id')->toArray();
            $receiveRequest = User::whereNot('id',auth()->user()->id)->whereIn('id',$sentRequestIds)->get();
            $receiveRequestHtml = '';
            $mode = $type;
            foreach($receiveRequest as $user){
                $receiveRequestHtml .= view('components.request', compact('user','mode'))->render();
            }
            return response()->json(['users' => $receiveRequestHtml,'count' => $receiveRequest->count(),'sent_tab' => true, 'btn_name' => 'get_received_requests_btn', 'text' => 'Received Requests']);

        }else if($type == 'connection'){

            $connectedUserIds = UserRequest::where('sender_id',auth()->user()->id)->where('status',1)->pluck('receiver_id')->toArray();
            $connectios = User::whereNot('id',auth()->user()->id)->whereIn('id',$connectedUserIds)->get();
            $connectionsHtml = '';
            $mode = $type;
            foreach($connectios as $connection){
                $connectionsHtml .= view('components.connection', compact('connection','mode'))->render();
            }
            return response()->json(['users' => $connectionsHtml,'count' => $connectios->count(),'sent_tab' => true, 'btn_name' => 'get_connections_btn', 'text' => 'Connections']);

        }
    }

    //get common connection data
    public function commonConnection($userId){
        $user = User::find($userId);
        $friendsIds = userRequest::where('sender_id',$user->id)->where('status',1)->pluck('receiver_id')->toArray();
        $myIds = userRequest::where('sender_id',auth()->user()->id)->where('status',1)->pluck('receiver_id')->toArray();
        $commonIds = array_intersect($friendsIds,$myIds);
        $commonUsers = User::where('id',$commonIds)->get();
        $commonConnectionHtml = '';
        foreach($commonUsers as $commonUser){
            $commonConnectionHtml .= view('components.connection_in_common', compact('commonUser'))->render();
        }
        return response()->json(['users' => $commonConnectionHtml, 'count' => $commonUsers->count(),'sent_tab' => true, 'btn_name' => 'get_connections_in_common', 'text' => 'Connections in common']);
    }

    //function for sent request
    public function sentRequest($userId){
        $user = User::find($userId);
        $userRequest = new userRequest();
        $userRequest->sender_id = auth()->user()->id;
        $userRequest->receiver_id = $user->id;
        $userRequest->status = 0;
        $userRequest->save();
        return response()->json(['success' => true]);

    }

    //function for cancel request
    public function cancelRequest($userId){
        $user = User::find($userId);
        $userRequest = userRequest::where('receiver_id',$user->id)->where('sender_id',auth()->user()->id)->where('status',0)->first();
        $userRequest->delete();
    }

    //function for accept request
    public function acceptRequest($userId){
        $user = User::find($userId);
        $userRequest = userRequest::where('receiver_id',auth()->user()->id)->where('sender_id',$user->id)->where('status',0)->first();
        $userRequest->sender_id = auth()->user()->id;
        $userRequest->receiver_id = $user->id;
        $userRequest->status = 1;
        $userRequest->save();
    }

    //function for accept request
    public function removeConnection($userId){
        $user = User::find($userId);
        $userRequest = userRequest::where('receiver_id',$user->id)->where('sender_id',auth()->user()->id)->where('status',1)->first();
        $userRequest->delete();
    }

}
