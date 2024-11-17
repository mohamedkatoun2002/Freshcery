@extends('layouts.app')

@section('content')
    <div id="page-content" class="page-content" style="margin-top: -25px;">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0"
                style="background-image: url(' {{ asset('assets/img/bg-header.jpg') }}');">
                <div class="container">
                    <h1 class="pt-5">
                        Your Cart
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <div class="container text-center">
            @if (session()->has('delete'))
                <div class="alert alert-success">
                    {{ session()->get('delete') }}
                </div>
            @endif
        </div>

        <section id="cart">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="10%"></th>
                                        <th>Products</th>
                                        <th>Price</th>
                                        <th width="15%">Quantity</th>
                                        <th>Subtotal</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartProducts as $cart)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('assets/img/' . $cart->image . '') }}" width="60">
                                            </td>
                                            <td>
                                                {{ $cart->name }}<br>
                                                <small>1000g</small>
                                            </td>
                                            <td>
                                                USD {{ $cart->price }}
                                            </td>
                                            <td>
                                                {{ $cart->qty }}
                                            </td>
                                            <td>
                                                USD {{ $cart->subtotal }}
                                            </td>
                                            <td>
                                                <a href="{{ route('products.delete.cart', $cart->id) }}"
                                                    class="text-danger"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <a href="{{ route('products.shop') }}" class="btn btn-default">Continue Shopping</a>
                    </div>
                    <div class="col text-right">

                        <div class="clearfix"></div>
                        <h6 class="mt-3">Total: USD {{ $subtotal }}</h6>
                        @if ($subtotal > 0)
                            <form action="{{ route('products.checkout.prepare') }}" method="POST">
                                @csrf
                                <input type="hidden" name="price" value="{{ $subtotal }}">
                                <button type="submit" name="submit" class="btn btn-lg btn-primary">Checkout <i
                                        class="fa fa-long-arrow-right"></i></button>
                            </form>
                        @else
                            <p class="alert alert-success text-center">Your cart is empty.</p>
                            {{-- <button type="button" class="btn btn-lg btn-primary" disabled>Checkout <i
                                    class="fa fa-long-arrow-right"></i></button> --}}
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
