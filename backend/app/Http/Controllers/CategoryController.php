<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    public function createCategory(Request $request){
        $this->category->name = $request->name;

        $this->category->save();
        return redirect()->back();
    }

    public function create(){
        return view('admin.categories.add_category');
    }
}
