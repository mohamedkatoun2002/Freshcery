@extends('layouts.app')

@section('content')
    <div id="page-content" class="page-content" style="margin-top: -25px;">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0"
                style="background-image: url(' {{ asset('assets/img/bg-header.jpg') }}');">
                <div class="container">
                    <h1 class="pt-5">
                        Your Transactions
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <section id="cart">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%"></th>
                                        <th>Name</th>
                                        <th>Last Name</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>town</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($orders->count() > 0)
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>
                                                    {{ $order->name }}
                                                </td>
                                                <td>
                                                    {{ $order->last_name }}
                                                </td>
                                                <td>
                                                    {{ $order->address }}
                                                </td>
                                                <td>
                                                    {{ $order->phone }}
                                                </td>
                                                <td>
                                                    {{ $order->email }}
                                                </td>
                                                <td>
                                                    {{ $order->town }}
                                                </td>
                                                <td>
                                                    {{ $order->status }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No orders yet</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection
