@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-5 d-inline">update status</h5>
                    <form method="POST" action="{{ route('update.order', $editOrder->id) }}">
                        <!-- Email input -->
                        @csrf
                        <div class="form-group">
                            <p>Current status : <b>{{ $editOrder->status }}</b></p>
                            <select name="status" class="form-control" id="exampleFormControlSelect1">
                                <option>--select status--</option>
                                {{-- <option value="pending">pending</option> --}}
                                <option value="processing">processing</option>
                                <option value="completed">completed</option>
                            </select>
                        </div>
                        <!-- Submit button -->
                        <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">update</button>


                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
