<?php

namespace App\Http\Controllers;

use App\Events\MessageReceived;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Chat;
use App\Models\Category;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $post;
    private $user;

    public function __construct(Post $post, User $user,Category $category)
    {

        $this->post = $post;
        $this->user = $user;
        $this->category = $category;
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
        $all_categories = $this->category->all();

        return view('users.home')
                ->with('all_posts', $all_posts)
                ->with('users', $users)
                ->with('all_categories', $all_categories);
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
