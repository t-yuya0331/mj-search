<?php

namespace App\Http\Controllers;

use App\Models\Nice;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    private $nice;
    private $post;

    public function __construct (Nice $nice, Post $post ){
        $this->nice = $nice;
        $this->post = $post;
    }



    public function store( Request $request)
    {

        $this->nice->user_id = Auth::user()->id;
        $this->nice->post_id = $request->post_id;
        $this->nice->save();
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nice  $nice
     * @return \Illuminate\Http\Response
     */
    public function show(Nice $nice)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nice  $nice
     * @return \Illuminate\Http\Response
     */
    public function destroy($post_id)
    {
        $nice = Nice::where('post_id', $post_id)->where('user_id', Auth::user()->id)->delete();
        return redirect()->back();
    }

}
