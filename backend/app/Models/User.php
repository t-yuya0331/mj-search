<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory,Searchable, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
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

    // Algoria setting
    public function toSearchableArray()
    {
        $array = $this->toArray();
        unset($array['avatar']);
        return $array;
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function checkUserHasPost(){
        return $this->hasMany(Post::class)->exists();
    }
    public function userPosts(){
        return $this->hasMany(UserPost::class);
    }
    public function checkUserHasOwnPost(){
        return $this->hasMany(UserPost::class)->exists();
    }
    public function checkUserHasChat(){
        return Chat::where('sender', Auth::user()->id)->where('receiver', Auth::user()->id)->exists();
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'sender', 'id')
            ->orWhere(function ($query) {
                $query->where('receiver', $this->id);
            });
    }

    public function nices(){
        return $this->hasMany(Nice::class);
    }

    public function countPosts($id){
        return $this->posts()->where('user_id', $id);
    }

    public function searchUsers($id){
        return User::where('id', $id)->get();
    }

}
