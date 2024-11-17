@extends('layouts.app')

@section('content')
    <div id="page-content" class="page-content" style="margin-top: -25px;">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0"
                style="background-image: url(' {{ asset('assets/img/bg-header.jpg') }}');">
                <div class="container">
                    <h1 class="pt-5">
                        You paid for the product successfully
                    </h1>
                    <p class="btn btn-primary" href="{{ route('home') }}">Go Home</p>
                </div>
            </div>
        </div>
    </div>
@endsection
