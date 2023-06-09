<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }

    public function create(){
        $all_categories = $this->category->all();
        $today = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i');

        return view('users.posts.create')
                ->with('all_categories',$all_categories)
                ->with('today', $today)
                ->with('time', $time);
    }

    public function store(Request $request){
        $request->validate([
            'description'   => 'max:500',
            'number'        => 'required|min:1|max:3',
            'category'      => 'required',
            'date'          => 'required',
            'time'          => 'required',
        ]);

        $this->post->user_id = Auth::user()->id;
        $this->post->target = $request->target;
        $this->post->date = $request->date;
        $this->post->time = $request->time;
        $this->post->number = $request->number;
        $this->post->location = $request->location;
        if($request->description):
            $this->post->description = $request->description;
        endif;
        $this->post->save();

        // category
        foreach($request->category as $category_id):
            $category_post[] = ['category_id' => $category_id];
        endforeach;

        $this->post->categoryPost()->createMany($category_post);

        return redirect()->route('index');
    }

    public function show($post_id){
        $post = $this->post->findOrFail($post_id);

        return view('users.posts.show')->with('post', $post);
    }

    public function update(Request $request,$id){
        $request->validate([
            'description'   => 'max:500',
            'number'        => 'required|min:1|max:3',
            'date'          => 'required',
        ]);

        $post = $this->post->findOrFail($id);

        $post->target = $request->target;
        $post->date = $request->date;
        $post->time = $request->time;
        $post->number = $request->number;
        $post->location = $request->location;
        if($request->description):
            $post->description = $request->description;
        endif;

        $post->save();

        $post->categoryPost()->delete();
        $category_post = [];
        foreach($request->category as $category_id):
            $category_post[] = ['category_id' => $category_id];
        endforeach;

        $post->categoryPost()->createMany($category_post);

            return redirect()->back();
    }

    public function createPost(){
        return view('users.posts.user_post');
    }

    public function changePostStatus($id){
        $post = $this->post->findOrFail($id);
        $post->update([
            'status' => 2
        ]);
        return redirect()->back();
    }

}

