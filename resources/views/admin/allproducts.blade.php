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
                @if (Session::has('delete'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}"> {{ Session::get('delete') }}</p>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 d-inline">Products</h5>
                    <a href="{{ route('create.products') }}" class="btn btn-primary mb-4 text-center float-right">Create
                        Products</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">product</th>
                                <th scope="col">price in $$</th>
                                <th scope="col">expiration date</th>
                                {{-- <th scope="col">status</th> --}}
                                <th scope="col">delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->exp_date }}</td>
                                    {{-- <td><a href="#" class="btn btn-success  text-center ">verfied</a></td> --}}
                                    <td><a href="{{ route('delete.products', $product->id) }}"
                                            class="btn btn-danger  text-center ">delete</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
