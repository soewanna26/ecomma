@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <div class="row profile-body">

            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <h6 class="card-title">Invoice Form</h6>

                                <form class="forms-sample" method="POST" action={{ route('store.invoice') }}
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for=""> Customer </label>
                                        <select class="form-select bg-dark text-light" name="customer_id"
                                            aria-label="Default select example" required>
                                            <option disabled selected> Choose Customers </option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"> {{ $customer->customer_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('customer_id') }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Payment</label>
                                        <select class="form-select bg-dark text-white" name="payment_method"
                                            aria-label="Default select example" required>
                                            <option disabled selected> Select Payment</option>
                                            <option value="cash">Cash</option>
                                            <option value="kpay">Kpay</option>
                                            <option value="banking">Banking</option>
                                        </select>
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('payment_method') }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="total_price" class="form-label">Total price</label>
                                        <input type="text" class="form-control" id="total_price" name="total_price"
                                            autocomplete="off">
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('total_price') }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for=""> Status </label>
                                        <select class="form-select bg-dark text-white" name="status"
                                            aria-label="Default select example" required>
                                            <option disabled selected> Select Status </option>
                                            <option value="active">Active</option>
                                            <option value="unactive">Unactive</option>
                                        </select>
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('status') }}
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2">Save Change</button>
                                    <a href="{{ route('all.invoice') }}" class="btn btn-danger">Cancel</a>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- middle wrapper end -->
            <!-- right wrapper start -->
            <!-- right wrapper end -->
        </div>

    </div>
@endsection
