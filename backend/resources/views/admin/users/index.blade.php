@extends('layouts.app')

@section('title', 'Admin:Users')

@section('content')
    <table class="table table-hover align-middle border text-secondary">
        <thead class="small table-success">
            <tr>
                <th></th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($all_users as $user)
                <tr>
                    <td>
                        @if($user->avatar)
                            <img src="{{ asset('/storage/avatars/'. $user->avatar) }}" alt="{{ $user->avatar }}" class="rounded-circle d-block" style="height:2.5rem; width:2.5rem;">
                        @else
                            <i class="fa-solid fa-user-circle d-block text-center"></i>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        @if ($user->trashed())
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
                        @if (Auth::user()->id != $user->id)
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                    @if($user->trashed() )
                                        <div class="dropdown-menu">
                                            <form action="{{ route('admin.users.activate' ,$user->id) }}" method="post"   class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm ">
                                                    <i class="fa-solid  fa-user text-success"></i>&nbsp;Active{{ $user->name }}
                                                </button>
                                            </form>

                                            {{-- <a href="{{ route('admin.users.activate' ,$user->id) }}" class="btn btn-sm ">
                                                <i class="fa-solid fa-user text-success"><span class="text-dark fs-6">&nbsp; Activate{{ $user->name }}</span></i>
                                            </a> --}}
                                        </div>
                                    @else
                                        <div class="dropdown-menu">
                                            <form action="{{ route('admin.users.deactivate', $user->id) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm ">
                                                    <i class="fa-solid fa-user-slash        text-danger"></i>Deactivate{{ $user->name }}
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
    {!! $all_users->links() !!}
@endsection
