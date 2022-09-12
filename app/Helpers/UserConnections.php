<?php
namespace App\Helpers;

use Throwable;
use App\Models\User;
use App\Models\UserRequest;
use Illuminate\Support\Facades\DB;

class UserConnections{

   public static function show($type){

    //show suggestions/
    if($type == 'suggestion'){

        $sentRequest = UserRequest::where('sender_id',auth()->user()->id)->pluck('receiver_id')->toArray();
        $receiveRequest = UserRequest::where('receiver_id',auth()->user()->id)->whereIn('status',[0,1])->pluck('sender_id')->toArray();
        $sentOrReceiveRequest = array_merge($sentRequest,$receiveRequest);
        $suggestions = User::whereNotIn('id',$sentOrReceiveRequest)->whereNot('id',auth()->user()->id)->get();
        $suggestionsHtml = '';
        foreach($suggestions as $sug){
            $suggestionsHtml .= view('components.suggestion', compact('sug'))->render();
        }
        return response()->json(['users' => $suggestionsHtml,'count' => $suggestions->count(),'suggestions_tab' => true,'btn_name' => 'get_suggestions_btn', 'text' => 'Suggestions','type' => $type]);

    //show sent requests
    }else if($type == 'sent'){

        $receivedRequestIds = UserRequest::where('status',0)->where('sender_id',auth()->user()->id)->whereNot('receiver_id',auth()->user()->id)->pluck('receiver_id')->toArray();
        $sentRequest = User::whereNot('id',auth()->user()->id)->whereIn('id',$receivedRequestIds)->get();
        $sentRequestHtml = '';
        $mode = $type;
        foreach($sentRequest as $user){
            $sentRequestHtml .= view('components.request', compact('user','mode'))->render();
        }
        return response()->json(['users' => $sentRequestHtml,'count' => $sentRequest->count(),'sent_tab' => true, 'btn_name' => 'get_sent_requests_btn', 'text' => 'Sent Requests','type' => $type]);

    //show receive requests
    }else if($type == 'receive'){

        $sentRequestIds = UserRequest::where('status',0)->where('receiver_id',auth()->user()->id)->whereNot('sender_id',auth()->user()->id)->pluck('sender_id')->toArray();
        $receiveRequest = User::whereNot('id',auth()->user()->id)->whereIn('id',$sentRequestIds)->get();
        $receiveRequestHtml = '';
        $mode = $type;
        foreach($receiveRequest as $user){
            $receiveRequestHtml .= view('components.request', compact('user','mode'))->render();
        }
        return response()->json(['users' => $receiveRequestHtml,'count' => $receiveRequest->count(),'sent_tab' => true, 'btn_name' => 'get_received_requests_btn', 'text' => 'Received Requests','type' => $type]);

    // show connections
    }else if($type == 'connection'){

        $connectedUserIds = UserRequest::select('receiver_id','sender_id')->where(function($u){
            $u->where('sender_id',auth()->user()->id)->orWhere('receiver_id',auth()->user()->id);
        })->where('status',1)->get();
        $connectedUserIds = collect($connectedUserIds->toArray())->flatten()->all();
        $connectios = User::whereNot('id',auth()->user()->id)->whereIn('id',$connectedUserIds)->get();
        $connectionsHtml = '';
        $mode = $type;
        foreach($connectios as $connection){
            $connectionsHtml .= view('components.connection', compact('connection','mode'))->render();
        }
        return response()->json(['users' => $connectionsHtml,'count' => $connectios->count(),'sent_tab' => true, 'btn_name' => 'get_connections_btn', 'text' => 'Connections','type' => $type]);

    }


   }

   //get common connection data
   public static function commonConnection($userId){

    $user = User::find($userId);
    $connectedUserIds = UserRequest::select('receiver_id','sender_id')->where(function($u) use ($userId){
        $u->where('sender_id',$userId)->orWhere('receiver_id',$userId);
    })->where('status',1)->get();
    $connectedUserIds = collect($connectedUserIds->toArray())->flatten()->all();
    $connectedUserIds1 = UserRequest::select('receiver_id','sender_id')->where(function($u) use ($userId){
        $u->where('sender_id',auth()->user()->id)->orWhere('receiver_id',auth()->user()->id);
    })->where('status',1)->get();
    $connectedUserIds1 = collect($connectedUserIds1->toArray())->flatten()->all();
    $commonIds = array_intersect($connectedUserIds,$connectedUserIds1);
    $commonUsers = User::whereIn('id',$commonIds)->whereNotIn('id',[auth()->user()->id,$userId])->get();
    $commonConnectionHtml = '';
    foreach($commonUsers as $commonUser){
        $commonConnectionHtml .= view('components.connection_in_common', compact('commonUser'))->render();
    }
    return response()->json(['success' => true,'users' => $commonConnectionHtml, 'count' => $commonUsers->count(),'sent_tab' => true, 'btn_name' => 'get_connections_in_common', 'text' => 'Connections in common','row_id' => $userId]);
   }

   //function for sent request
   public static function sentRequest($userId){
    $user = User::find($userId);
    $userRequest = new UserRequest();
    $userRequest->sender_id = auth()->user()->id;
    $userRequest->receiver_id = $user->id;
    $userRequest->status = 0;
    $userRequest->save();
    return response()->json(['success' => true, 'msg' => 'Request withdraw successfully!!','row_id' => $userId]);
   }

   //function for cancel request
   public static function cancelRequest($userId){
    $user = User::find($userId);
    $userRequest = UserRequest::where('receiver_id',$user->id)->where('sender_id',auth()->user()->id)->where('status',0)->first();
    $userRequest->delete();
    return response()->json(['success' => true, 'msg' => 'Request withdraw successfully!!','row_id' => $userId]);
   }

   //function for accept request
   public static function acceptRequest($userId){
    $user = User::find($userId);
    $userRequest = UserRequest::where('receiver_id',auth()->user()->id)->where('sender_id',$user->id)->where('status',0)->first();
    $userRequest->sender_id = auth()->user()->id;
    $userRequest->receiver_id = $user->id;
    $userRequest->status = 1;
    $userRequest->save();
    return response()->json(['success' => true, 'msg' => 'Request withdraw successfully!!','row_id' => $userId]);
   }

   //function for remove connections
   public static function removeConnection($userId){
    $user = User::find($userId);
    $userRequest = UserRequest::where('receiver_id',$user->id)->where('sender_id',auth()->user()->id)->where('status',1)->first();
    $userRequest->delete();
    return response()->json(['success' => true, 'msg' => 'Request withdraw successfully!!','row_id' => $userId]);
   }


}
