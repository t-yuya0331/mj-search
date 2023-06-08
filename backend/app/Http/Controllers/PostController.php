<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Nice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }

    public function create()
    {
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories',$all_categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description'   => 'max:500',
            'number'        => 'required|min:1|max:3',
            'category'      => 'required',
            'date'          => 'required',
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

    public function edit($id)
    {
        $post = $this->post->findOrFail($id);

        if(Auth::user()->id !== $post->user->id):
            return redirect()->route('index');
        endif;

        $all_categories = $this->category->all();
        foreach($post->categoryPost as $category_post):
            $selected_categories[] = $category_post->category_id;
        endforeach;

        return view('users.posts.edit')
                ->with('post', $post )
                ->with('all_categories', $all_categories)
                ->with('selected_categories');
    }

    public function update(Request $request,$id)
    {
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

    public function destroy($id)
    {
        $post = $this->post->findOrFail($id);
        $this->deleteImage($post->image);
        $this->post->destroy($id);

        return redirect()->route('index');
    }

    public function createPost(){
        return view('users.posts.user_post');
    }

    public function changePostStatus($id){
        $post = $this->post->findOrFail($id);
        $post->update([
            'role_id' => 2
        ]);
        return redirect()->back();
    }

}

