<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    //relation for sent request
    public function sent_requests(){
        return $this->hasMany('App\Models\UserRequest', 'sender_id', 'id');
    }

    //relation for received request
    public function received_requests(){
        return $this->hasMany('App\Models\UserRequest', 'receiver_id', 'id');

    }
    //get common connection count 
    public function commonCount($userId){
    $connectedUserIds = UserRequest::select('receiver_id','sender_id')->where(function($u) use ($userId){
        $u->where('sender_id',$userId)->orWhere('receiver_id',$userId);
    })->where('status',1)->get();
    $connectedUserIds = collect($connectedUserIds->toArray())->flatten()->all();
    $connectedUserIds1 = UserRequest::select('receiver_id','sender_id')->where(function($u) use ($userId){
        $u->where('sender_id',auth()->user()->id)->orWhere('receiver_id',auth()->user()->id);
    })->where('status',1)->get();
    $connectedUserIds1 = collect($connectedUserIds1->toArray())->flatten()->all();
    $commonIds = array_intersect($connectedUserIds,$connectedUserIds1);
    $commonUsers = User::whereIn('id',$commonIds)->whereNotIn('id',[auth()->user()->id,$userId])->count();
        return $commonUsers;
    }

}
