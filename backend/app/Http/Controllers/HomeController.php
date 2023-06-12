<?php

namespace App\Http\Controllers;

use App\Events\MessageReceived;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Category;


class HomeController extends Controller
{
    private $post;
    private $user;

    public function __construct(Post $post, User $user,Category $category){

        $this->post = $post;
        $this->user = $user;
        $this->category = $category;
    }

    public function index(){
        // check the date and time are past or not
        $currentDateTime = Carbon::now('Asia/Tokyo');
        Post::where('date', '<', $currentDateTime->format('Y-m-d'))
            ->orWhere(function ($query) use ($currentDateTime) {
                $query->where('date', '=', $currentDateTime->format('Y-m-d'))
                    ->where('time', '<', $currentDateTime->format('H:i:s'));
            })
            ->update(['role_id' => 2]);

         //retrieve posts , users and categories data
        $users = $this->user->all();
        $all_posts = Post::where('role_id', 1)
                    ->where('status', 1)
                    ->latest()->get();
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
