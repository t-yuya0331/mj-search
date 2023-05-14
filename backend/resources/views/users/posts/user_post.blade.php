@extends('layouts.app')

@section('title','Create Post')

@section('content')
<div class="create_container">
    <div class="create_post w-50 mx-auto ">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="#practice-content" class="nav-link active" id="practice" role="tab" data-bs-toggle="tab" aria-selected="true">練習</a>
            </li>
            <li class="nav-item">
                <a href="#record-content" class="nav-link" role="tab" id="record" data-bs-toggle="tab" aria-selected="false">記録</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active mt-3" id="practice-content" aria-labelledby="practice">
                @if(!Auth::user()->checkUserHasOwnPost())
                    <h5 class="text-center">ここでは何を切るか迷った時の手牌を保存して後で見返せるようにしましょう!</h5>
                @endif
                <form action="{{ route('user_post.store') }}" method="post"  enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-auto">
                                <label for="image" class="form-label">手牌の画像</label>
                                <input type="file" name="image" id="image"      class="form-control">
                                @error('image')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <textarea name="description" id="description" cols="30"     rows="10"   class="form-control" placeholder="その時の状況などメモしておきたいことを記載してください"></textarea>
                    </div>

                    <div class="">
                        <input type="number" name="role_id" hidden value="1">
                    </div>
                    <div class="button text-center">
                        <button type="submit" class="btn btn-primary w-50">記録</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane mt-3" id="record-content" aria-labelledby="record">
                @if(!Auth::user()->checkUserHasOwnPost())
                    <h5 class="text-center">ここでは和了できて嬉しかった手牌や珍しい手牌を保存して後で見返せるようにしましょう!</h5>
                @endif
                <form action="{{ route('user_post.store') }}" method="post"  enctype="multipart/form-data">
                    @csrf
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-auto">
                                    <label for="image" class="form-label">手牌の画像</label>
                                    <input type="file" name="image" id="image"      class="form-control">
                                    @error('image')
                                        <p class="text-danger small">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <textarea name="description" id="description" cols="30"     rows="10"   class="form-control" placeholder="その時の状況などメモしておきたいことを記載してください"></textarea>
                        </div>

                        <div class="">
                            <input type="number" name="role_id" hidden value="2">
                        </div>
                        <div class="button text-center">
                            <button type="submit" class="btn btn-primary w-50">記録</button>
                        </div>
                    </form>
            </div>
        </div>

    </div>
</div>

@endsection
