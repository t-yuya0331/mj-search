@extends('layouts.app')

@section('title', 'Admin:Categories')

@section('content')
    <a href="{{ route('admin.create_category') }}" class="btn btn-primary mb-3"><i class="fa-solid fa-circle-plus text-dark ">Add Category</i></a>

    <table class="table table-hover align-middle border text-secondary">
        <thead class="small table-success">
            <tr>
                <th>Name</th>
                <th></th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($all_categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td></td>
                    <td>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group " role="group">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning me-2">Edit</a>

                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger d-inline">Delete</button>
                                </form>

                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </div>
@endsection
