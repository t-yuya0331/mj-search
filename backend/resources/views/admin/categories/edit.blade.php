@extends('layouts.app')

@section('title', 'Admin:Category_Edit')

@section('content')

    <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="mb-3 w-50 mx-auto">
            <p><i class="fa-solid fa-circle-plus text-dark ">Edit Category</i></p>
            <label for="name" class="form-label"></label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}">
            <button type="submit" class="btn btn-primary w-100 mt-3">Add</button>
        </div>
    </form>
@endsection
