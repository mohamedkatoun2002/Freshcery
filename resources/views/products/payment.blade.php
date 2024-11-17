@extends('layouts.app')

@section('content')
    <div id="page-content" class="page-content" style="margin-top: -25px;">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0"
                style="background-image: url(' {{ asset('assets/img/bg-header.jpg') }}');">
                <div class="container">
                    <h1 class="pt-5">
                        payment
                    </h1>
                    <p class="lead">
                        pay for your order
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 50px ; margin-bottom: 50px">
        <div class="row justify-content-center ">
            <!-- Replace "test" with your own sandbox Business account app client ID -->
            <script
                src="https://www.paypal.com/sdk/js?client-id=AV72s3xGr0v4RjZwEj-jJZc-jNMhrdABj2VGJ8HtriTB6FhPlai54O8EXKAj6uaEnUWbZ_FSgSeDxcZB&currency=USD">
            </script>
            <!-- Set up a container element for the button -->
            <div id="paypal-button-container"></div>
            <script>
                paypal.Buttons({
                    // Sets up the transaction when a payment button is clicked
                    createOrder: (data, actions) => {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: '{{ Session::get('value') }}' // Can also reference a variable or function
                                }
                            }]
                        });
                    },
                    // Finalize the transaction after payer approval
                    onApprove: (data, actions) => {
                        return actions.order.capture().then(function(orderData) {

                            window.location.href = 'http://127.0.0.1:8000/products/success';
                        });
                    }
                }).render('#paypal-button-container');
            </script>
        </div>
    </div>
@endsection
