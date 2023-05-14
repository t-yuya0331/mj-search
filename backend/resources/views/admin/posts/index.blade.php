@extends('layouts.app')

@section('title', 'Admin:Posts')

@section('content')
    <table class="table table-hover align-middle border text-secondary">
        <thead class="small table-success">
            <tr>
                <th>IMAGE</th>
                <th>DESCRIPTION</th>
                <th>UPDATED AT</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($all_posts as $post)
                <tr>
                    <td>
                        <img src="{{ asset('/storage/images/'.$post->image) }}" alt="{{ $post->image }}" class="img-fluid " style="width:40%; height:40%;">
                    </td>
                    <td>{{ $post->description }}</td>
                    <td>{{ $post->updated_at }}</td>
                    <td>
                        @if ($post->trashed())
                            <i class="fa-solid fa-circle text-danger">
                                &nbsp; Deactive
                            </i>
                        @else
                            <i class="fa-solid fa-circle text-success">
                                &nbsp; Active
                            </i>
                        @endif
                    </td>
                    <td>
                        @if (Auth::user()->id != $post->user->id)
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                @if ($post->trashed())
                                    <div class="dropdown-menu">
                                        <form action="{{ route('admin.posts.activate', $post->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm">
                                                <i class="fa-solid fa-user text-success"></i>
                                                    &nbsp; Activate{{ $post->user->name }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="dropdown-menu">
                                        <form action="{{ route('admin.posts.deactivate', $post->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm ">
                                                <i class="fa-solid fa-user-slash        text-danger"></i>Deactivate{{ $post->user->name }}
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>
    {!! $all_posts->links() !!}
@endsection
