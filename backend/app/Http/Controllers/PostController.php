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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $post;
    private $category;

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories',$all_categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description'   => 'max:200',
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


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

    public function show($post_id){
        $post = $this->post->findOrFail($post_id);

        return view('users.posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
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

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'image'         => 'required|mimes:jpg, jpeg, png, gif|max:1048',
            'description'   => 'required|min:1|max:1000',
            'category'      => 'required|array|between:1,3'
        ]);

        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        if($request->image):
            $this->deleteImage($post->image);
            $post->image = $this->saveImage($request);
        endif;

        $post->save();

        $post->categoryPost()->delete();

        foreach($request->category as $category_id):
            $category_post[] = ['category_id' => $category_id];
        endforeach;

        $post->categoryPost()->createMany($category_post);

            return redirect()->route('post.show',$id);
    }


    /**
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
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

