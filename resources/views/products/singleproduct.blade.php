@extends('layouts.app')

@section('content')
    <div id="page-content" class="page-content" style="margin-top: -25px;">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0"
                style="background-image: url(' {{ asset('assets/img/bg-header.jpg') }}');">
                <div class="container">
                    <h1 class="pt-5">
                        {{ $product->name }}
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <div class="container text-center">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>

        <div class="product-detail">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="slider-zoom">
                            <a href="{{ asset('assets/img/' . $product->image . '') }}" class="cloud-zoom"
                                rel="transparentImage: 'data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==', useWrapper: false, showTitle: false, zoomWidth:'500', zoomHeight:'500', adjustY:0, adjustX:10"
                                id="cloudZoom">
                                <img alt="Detail Zoom thumbs image" src="{{ asset('assets/img/' . $product->image . '') }}"
                                    style="width: 100%;">
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong>Overview</strong><br>
                            {{ $product->description }}
                        </p>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>
                                    <strong>Price</strong> (/Pack)<br>
                                    <span class="price">USD {{ $product->price }}</span>
                                    {{-- <span class="old-price">USD. 150.000</span> --}}
                                </p>
                            </div>

                        </div>
                        <p class="mb-1">
                            <strong>Quantity</strong>
                        </p>
                        <form action="{{ route('products.add.cart') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-5">
                                    <input name="qty" class="form-control" type="number" min="1"
                                        data-bts-button-down-class="btn btn-primary"
                                        data-bts-button-up-class="btn btn-primary" value="1" name="vertical-spin">
                                    <input type="hidden" name="name" value="{{ $product->name }}">
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                    <input type="hidden" name="pro_id" value="{{ $product->id }}">
                                    <input type="hidden" name="image" value="{{ $product->image }}">
                                </div>
                                <div class="col-sm-6"><span class="pt-1 d-inline-block">Pack (1000 gram)</span></div>
                            </div>
                            @if (isset(Auth::user()->id))
                                @if ($CheckInCart > 0)
                                    <button disabled class="mt-3 btn btn-primary btn-lg">
                                        <i class="fa fa-shopping-basket"></i> Added to Cart
                                    </button>
                                @else
                                    <button type="submit" name="submit" class="mt-3 btn btn-primary btn-lg">
                                        <i class="fa fa-shopping-basket"></i> Add to Cart
                                    </button>
                                @endif
                            @else
                                <p class="mt-3">
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                        <i class="fa fa-shopping-basket"></i> Add to Cart
                                    </a>
                                </p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <section id="related-product">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Related Products</h2>
                        @if ($relatedProducts->count() > 0)
                            <div class="product-carousel owl-carousel">
                                @foreach ($relatedProducts as $relatedproduct)
                                    <div class="item">
                                        <div class="card card-product">
                                            <div class="card-ribbon">
                                                <div class="card-ribbon-container right">
                                                    <span class="ribbon ribbon-primary">SPECIAL</span>
                                                </div>
                                            </div>
                                            <div class="card-badge">
                                                <div class="card-badge-container left">
                                                    <span class="badge badge-primary">
                                                        Until {{ $relatedproduct->exp_date }}
                                                    </span>
                                                    <span class="badge badge-primary">
                                                        20% OFF
                                                    </span>
                                                </div>
                                                <img src="{{ asset('assets/img/' . $relatedproduct->image . '') }}"
                                                    alt="Card image 2" class="card-img-top">
                                            </div>
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    <a href="detail-product.html">{{ $relatedproduct->name }}</a>
                                                </h4>
                                                <div class="card-price">
                                                    {{-- <span class="discount">Rp. 300.000</span> --}}
                                                    <span class="reguler">USD. {{ $relatedproduct->price }}</span>
                                                </div>
                                                <a href="{{ route('single.product', $relatedproduct->id) }}"
                                                    class="btn btn-block btn-primary">
                                                    product details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="alert alert-success text-center">No related products found in this category just yet.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
