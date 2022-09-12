<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use App\Helpers\UserConnections;

class UserController extends Controller
{
    //(suggestions, sent request, reveive request, connections) show here
    public function show($type){
        return UserConnections::show($type);
    }

    //get common connection data
    public function commonConnection($userId){
        return UserConnections::commonConnection($userId);
    }

    //function for sent request
    public function sentRequest($userId){
        return UserConnections::sentRequest($userId);
    }

    //function for cancel request
    public function cancelRequest($userId){
        return UserConnections::cancelRequest($userId);
    }

    //function for accept request
    public function acceptRequest($userId){
        return UserConnections::acceptRequest($userId);
    }

    //function for remove connections
    public function removeConnection($userId){
        return UserConnections::removeConnection($userId);
    }

}
