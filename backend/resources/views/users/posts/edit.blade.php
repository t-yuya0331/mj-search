@extends('layouts.app')

@section('title','Edit Post')

@section('content')
{{ $post->id }}
    <form action="{{ route('post.update',$post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        {{-- <div class="mb-3">
            @foreach($all_categories as $category)
            <div class="form-check form-check-inline">
                @if(in_array($category->id, $selected_categories))
                    <input type="checkbox" name="category[]" value="{{ $category->id }}" id="{{ $category->id }} " checked class="form-check-input">
                @else
                <input type="checkbox" name="category[]" value="{{ $category->id }}" id="{{ $category->id }}" class="form-check-input">
                @endif
                <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
            </div>
                @endforeach
        </div> --}}

        <div class="mb-3">
            <label for="description" class="form-label fw-bold" ></label>
            <textarea name="description" id="description"  rows="3" class="form-control" placeholder="Whats on your mind?">{{ $post->description }}</textarea>
            @error('description')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <img src="{{ asset('/storage/images/'.$post->image) }}" alt="{{ $post->image }}" class="img-thumbnail" style="height:250px; width:250px;">
            <input type="file" name="image" id="" class="form-control">
            @error('image')
            <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary px-5">Save</button>


    </form>

@endsection
