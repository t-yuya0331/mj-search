<?php

namespace App\Http\Controllers;

use App\Events\MessageReceived;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Chat;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {

        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = $this->user->all();

        $all_posts = $this->post->latest()->get();

        return view('users.home')
                ->with('all_posts', $all_posts)
                ->with('users', $users);
    }


    public function search(Request $request){
        $keyword = $request->input('search');
        $search_users = User::search($keyword)->get();
        $search_posts = Post::search($keyword)->get();


        return view('search.index')->with('search_users', $search_users)
                                    ->with('search_posts', $search_posts)
                                    ->with('keyword', $keyword);
    }
}
