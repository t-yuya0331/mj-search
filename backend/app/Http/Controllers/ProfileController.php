<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($id){
        $user = $this->user->findOrFail($id);
        $posts = Post::where('user_id', $id)
                    ->Where(function ($query) {
                        $query->where('role_id', 2)
                        ->orWhere('status', 2);
                })
                ->orderBy('date')
                ->get();

        return view('users.profile.show')
                ->with('user', $user)
                ->with('posts', $posts);
    }

    public function edit($id){
        $user = $this->user->findOrFail($id);

        return view('users.profile.edit')->with('user', $user);
    }

    public function update(Request $request, $id){
        $request->validate([
            'image' => 'mimes:jpg,jpeg,png,gif|max:1048',
            'name' => 'required',
            'email' => 'required',
        ]);

        $user = $this->user->findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        if($request->avatar):
            $user->avatar =  base64_encode(file_get_contents($request->avatar));
        endif;

        $user->save();
        return redirect()->route('profile.show', $id);
    }
}
