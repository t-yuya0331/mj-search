@extends('layouts.app')

@section('title', 'Admin:Add_Category')

@section('content')

    <form action="{{ route('admin.store') }}" method="post">
        @csrf
        <div class="mb-3 w-50 mx-auto">
            <p><i class="fa-solid fa-circle-plus text-dark ">Add Category</i></p>
            <label for="name" class="form-label"></label>
            <input type="text" name="name" id="name" class="form-control">
            <button type="submit" class="btn btn-primary w-100 mt-3">Add</button>
        </div>
    </form>
@endsection
