<div class="card-header p-0 ms-2 mt-2" id="post_header">
    <div class="row w-100">
        <div class="col-auto pe-0">
            @if($post->user->avatar)
                <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none  text-white">
                    <img src="data:image/png;base64,{{ $post->user->avatar }}" alt="{{  $post->user->avatar }}" class="rounded-circle nav-avatar" id="user_img">
                </a>
            @else
                <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none  text-white">
                    <i class="fas fa-user-circle user-icon" id="user_icon"></i>
                </a>
            @endif
        </div>
        <div class="col-auto text-start ps-2" id="post_detail">
            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-white">
                {{ $post->user->name }}
            </a>
        </div>
        <div class="col" id="post_detail">
            <p class="text-info mt-1 ps-3">{{ $post->created_at->diffForHumans() }}</p>
        </div>
        @if(Auth::user()->id == $post->user->id && $post->role_id !== 2)
            <div class="col p-0">
                <div class="float-end text-center">
                    <div class="dropdown">
                        <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown" id="pen">
                            <i class="fa-solid fa-thin fa-pencil" id="pen-icon"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal{{ $post->id }}">編集する</button>
                            <form action="{{ route('post.changeStatus', $post->id) }}"      method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="dropdown-item">募集を終了する</button>
                            </form>
                        </div>
                    </div>
                    <div class="modal fade text-dark" id="editModal{{ $post->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" id="modal">
                                <div class="modal-header p-0">
                                    <h5 class="modal-title" id="editModalLabel">投稿を編集する</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('post.update', $post->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="category" class="form-label d-block fw-bold">
                                                <span class="text-muted fw-normal">ルールの詳細を選んでください</span>
                                            </label>
                                            <!-- display all categories -->
                                            @foreach ($all_categories as $category)
                                                <div class="form-check form-check-inline mb-2">
                                                    <input type="checkbox" name="category[]" class="form-check-input" id="{{ $category->name }}" value="{{ $category->id }}"
                                                        @if ($post->categoryPost->contains('category_id', $category->id)) checked @endif
                                                    >
                                                    <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
                                                </div>
                                            @endforeach
                                            @error('category')
                                                <p class="text-danger small">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-6" >
                                                    <label for="date" class="form-label d-block fw-bold">
                                                        <span class="text-muted fw-normal">日付</span>
                                                    </label>
                                                    <input type="date" name="date" value="{{ $post->date }}" min="{{ $today }}">
                                                </div>
                                                <div class="col-6">
                                                    <label for="time" class="form-label d-block fw-bold">
                                                        <span class="text-muted fw-normal">時間</span>
                                                    </label>
                                                    <input type="time" name="time" value="{{ $post->time }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-auto pe-0">
                                                    <label for="location" class="form-label d-block fw-bold">
                                                        <span class="text-muted fw-normal">場所:</span>
                                                    </label>
                                                </div>
                                                <div class="col ps-3 text-start">
                                                    <input type="text" name="location" placeholder="お店の住所等" value="{{ $post->location }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-auto pe-0">
                                                    <label for="number" class="form-label d-block fw-bold">
                                                        <span class="text-muted fw-normal">募集人数:</span>
                                                    </label>
                                                </div>
                                                <div class="col ps-3 text-start">
                                                    <input type="number" name="number" max="3" min="1" value="{{ $post->number }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="form-group">
                                                <label for="number" class="form-label d-block fw-bold">
                                                    <span class="text-muted fw-normal">募集対象</span>
                                                </label>
                                                <div class="form-check-inline">
                                                    <input type="radio" name="target" id="begginer" value="1" {{ $post->target == 1 ? 'checked' : '' }}>
                                                    <label for="begginer">初級</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input type="radio" name="target" id="intermediate" value="2" {{ $post->target == 2 ? 'checked' : '' }}>
                                                    <label for="intermediate">中級</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input type="radio" name="target" id="advanced" value="3" {{ $post->target == 3 ? 'checked' : '' }}>
                                                    <label for="advanced">上級</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input type="radio" name="target" id="anyone" value="4" {{ $post->target == 4 ? 'checked' : '' }}>
                                                    <label for="anyone">誰でも歓迎</label>
                                                </div>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <label for="description" class="form-label fw-bold" ></label>
                                            <textarea name="description" id="description"  rows="3" class="form-control" rows="3">{{ $post->description }}</textarea>
                                            @error('description')
                                                <p class="text-danger small">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer p-0">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                        <button type="submit" class="btn btn-primary">保存する</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
