@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col">
            <div class="container">
                @if (Session::has('success'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}"> {{ Session::get('success') }}</p>
                @endif
            </div>
            <div class="container">
                @if (Session::has('update'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}"> {{ Session::get('update') }}</p>
                @endif
            </div>
            <div class="container">
                @if (Session::has('delete'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}"> {{ Session::get('delete') }}</p>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 d-inline">Categories</h5>
                    <a href="{{ route('create.categories') }}" class="btn btn-primary mb-4 text-center float-right">Create
                        Categories</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">name</th>
                                <th scope="col">image</th>
                                <th scope="col">description</th>
                                <th scope="col">icon</th>
                                <th scope="col">update</th>
                                <th scope="col">delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <th scope="row">{{ $category->id }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td><img src="{{ asset('assets/img/' . $category->image . '') }}" width="70"
                                            height="70"></td>
                                    <td>{{ $category->description }}</td>
                                    <td>{{ $category->icon }}</td>
                                    <td><a href="{{ route('edit.categories', $category->id) }}"
                                            class="btn btn-warning text-white text-center ">Update </a></td>
                                    <td><a href="{{ route('delete.categories', $category->id) }}"
                                            class="btn btn-danger  text-center ">Delete </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
