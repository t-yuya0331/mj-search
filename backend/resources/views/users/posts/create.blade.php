@extends('layouts.app')

@section('title','Create Post')

@section('content')
<div class="create_container">
    <div class="create_post w-50 mx-auto " >
        @if(!Auth::user()->checkUserHasPost())
            <h3 class="text-center">初めての投稿をしよう！</h3>
        @endif
        <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="category" class="form-label d-block fw-bold">
                    <span class="text-muted fw-normal">ルールの詳細を選んでください</span>
                </label>
                <!-- display all categories -->
                @foreach ($all_categories as $category)
                    <div class="form-check form-check-inline mb-2 ">
                        <input type="checkbox" name="category[]" class="form-check-input" id="{{ $category->name }}" value="{{ $category->id }}">
                        <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
                    </div>
                @endforeach

                @error('category')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
                <p class="mb-0">
                    <a data-bs-toggle="collapse" href="#collapseRule" aria-expanded="false" aria-controls="collapseExample">
                        用語の説明はこちら
                    </a>
                </p>
                <div class="collapse" id="collapseRule">
                    <div class="rule">
                        <p class="rule mb-0">※赤ありは赤ドラありのルール</p>
                        <p class="rule mb-0">※チップは主に一発・裏ドラ・赤ドラ・役満に付随するボーナス点としてチップを使用するルール</p>
                        <p class="rule mb-0">※ありありは鳴いて断么和了があり、後付け和了がありのルール</p>
                        <p class="rule mb-0">※ありなしは鳴いて断么和了があり、後付け和了がなしのルール</p>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-auto">
                        <label for="date" class="form-label d-block fw-bold">
                            <span class="text-muted fw-normal">日付を選択してください</span>
                        </label>
                        <input type="date" name="date">
                    </div>
                    <div class="col-auto">
                        <label for="time" class="form-label d-block fw-bold">
                            <span class="text-muted fw-normal">時間を選択してください</span>
                        </label>
                        <input type="time" name="time">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label d-block fw-bold">
                    <span class="text-muted fw-normal">場所</span>
                </label>
                <input type="text" name="location" placeholder="お店の住所等">
            </div>
            <div class="mb-3">
                <label for="number" class="form-label d-block fw-bold">
                    <span class="text-muted fw-normal">募集人数</span>
                </label>
                <input type="number" name="number" max="3" min="1">
            </div>

            <div class="row mb-3">
                <div class="form-group">
                    <p class="control-label">募集対象</p>
                    <div class="form-check-inline">
                        <input type="radio" name="target" id="begginer" value="1">
                        <label for="begginer">初級</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="radio" name="target" id="intermediate" value="2">
                        <label for="intermediate">中級</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="radio" name="target" id="advanced" value="3">
                        <label for="advanced">上級</label>
                    </div>
                    <div class="form-check-inline">
                        <input type="radio" name="target" id="anyone" value="4">
                        <label for="advanced">誰でも歓迎</label>
                    </div>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <p class="mb-0">
                    <a data-bs-toggle="collapse" href="#collapseTarget" aria-expanded="false" aria-controls="collapseTarget">
                        対象の目安はこちら
                    </a>
                </p>
                <div class="collapse" id="collapseTarget">
                    <div class="target">
                        <p class="rule mb-0">※初級:麻雀の基本ルールを覚えている方</p>
                        <p class="rule mb-0">※中級:基本ルールと点数計算を覚えている方</p>
                        <p class="rule mb-0">※上級:捨て牌、安全牌等を読み攻め時と引き時を実行に移せる方</p>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label fw-bold" ></label>
                <textarea name="description" id="description"  rows="3" class="form-control" placeholder="上記以外のルールの詳細や募集する方へのメッセージがあれば記載してください"></textarea>
                @error('description')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>

            <div class="button text-center">
                <button type="submit" class="btn btn-primary w-50">Post</button>
            </div>
        </form>
    </div>
</div>

@endsection
