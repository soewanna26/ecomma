@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <div class="row profile-body">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
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
                            <h4 class="card-title text-uppercase">Order Create</h4>

                            <form action="{{ route('store.order') }}" method="POST" class="forms-sample"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for=""> Category Name </label>
                                            <select class="form-select bg-dark text-white" name="category_id"
                                                id="category_id" aria-label="Default select example" required>
                                                <option disabled selected> Select Category </option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"> {{ $category->name }} </option>
                                                @endforeach
                                            </select>
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('product_id') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for=""> Product Name </label>
                                            <select class="form-select bg-dark text-white" name="product_id" id="product"
                                                aria-label="Default select example" required>
                                                <option disabled selected> Select Product </option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"> {{ $product->product_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('product_id') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for=""> Original Price </label>
                                            <input type="text" class="form-control" name="original_price" id="price"
                                                placeholder="Original Price" required>
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('original_price') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for=""> Discount %</label>
                                            <input type="text" class="form-control" name="on_discount" id="discount"
                                                placeholder="Discount" value="0">
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('on_discount') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for=""> Discount Price </label>
                                            <input type="number" min="0" class="form-control" name="discount_price"
                                                value="0" id="discount_price" placeholder="Discount Price">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for=""> Quantity </label>
                                            <input type="number" min="0" class="form-control" name="quantity"
                                                id="quantity" placeholder="Quantity" required>
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('quantity') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for=""> Total Price </label>
                                            <input type="number" min="0" class="form-control" name="total_price"
                                                id="total_price" placeholder="Total Price" required>
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('total_price') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for=""> Status </label>
                                            <select class="form-select bg-dark text-white" name="status"
                                                aria-label="Default select example" required>
                                                <option disabled selected> Select Status </option>
                                                <option value="pending">Pending</option>
                                                <option value="delivered">Delivered</option>
                                            </select>
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('status') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-2">
                                    <h6>DELIVERY INFO</h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for=""> Customer Name </label>

                                            <select class="form-select bg-dark text-white customer_select"
                                                name="customer_id" id="customer_id" aria-label="Default select example">
                                                <option disabled selected> Select Customer Name </option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"> {{ $customer->customer_name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('customer_id') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group customer_name">
                                            <label for="">New Customer Name </label>
                                            <input type="text" class="form-control" name="customer_name"
                                                id="" placeholder="New Customer Name">
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group phone_primary">
                                            <label for="">Primary Phone </label>
                                            <input type="text" class="form-control" name="phone_primary"
                                                id="phone_primary" placeholder="Example: 09123456789">
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group phone_primary">
                                            <label for="">Secondary Phone </label>
                                            <input type="text" class="form-control" name="phone_secondary"
                                                id="phone_secondary" placeholder="">
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group division">
                                            <label for="">State/Division</label>
                                            <select class="form-select bg-dark text-white" name="division_id"
                                                id="division_id" aria-label="Default select example">
                                                <option disabled selected> Select Division </option>
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        {{ old('division_id') == $division->division_name ? 'selected' : '' }}>
                                                        {{ $division->division_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('division_id') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group district">
                                            <label for="">District</label>
                                            <select class="form-select bg-dark text-light" name="district_id"
                                                id="district_id" aria-label="Default select example">
                                                <option disabled selected> Select District </option>
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}">
                                                        {{ $district->district_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('district_id') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group township">
                                            <label for="">Township</label>
                                            <select class="form-select bg-dark text-light" name="township_id"
                                                id="township_id" aria-label="Default select example">
                                                <option disabled selected> Select Township </option>
                                                @foreach ($townships as $township)
                                                    <option value="{{ $township->id }}">
                                                        {{ $township->township_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('township_id') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group home_no">
                                            <label for="">Home No: </label>
                                            <input type="text" class="form-control" name="home_no" id="home_no"
                                                placeholder="No(1) " value="{{ old('home_no') }}">
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('home_no') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group street">
                                            <label for="">Street Name </label>
                                            <input type="text" class="form-control" name="street_name"
                                                id="street_name" placeholder="Mayangone Street "
                                                value="{{ old('street_name') }}">
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('street_name') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group payment">
                                            <label for="">Payment</label>
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
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group address">
                                            <label for="">Delivery Address </label>
                                            <textarea name="address" id="address" readonly class="form-control bg-dark">{{ old('address') }}</textarea>
                                            <div class="text-danger form-control-feedback">
                                                {{ $errors->first('address') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a href="{{ route('all.order') }}" class="btn btn-light">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $("#division_id").change(function() {
            var division_id = $(this).val();
            if (division_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('getDistrict') }}?division_id=" + division_id,
                    success: function(res) {
                        if (res) {
                            $("#district_id").empty();
                            $("#district_id").append('<option value="">Select District</option>');
                            $.each(res, function(key, value) {
                                $("#district_id").append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        } else {
                            $("#district_id").empty();
                        }
                    },
                });
            } else {
                $("#district_id").empty();
                $("#township_id").empty(); // Reset township dropdown
            }
        });

        $("#district_id").change(function() {
            var district_id = $(this).val();
            if (district_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('getTownship') }}?district_id=" + district_id,
                    success: function(res) {
                        if (res) {
                            $("#township_id").empty();
                            $("#township_id").append('<option value="">Select Township</option>');
                            $.each(res, function(key, value) {
                                $("#township_id").append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        } else {
                            $("#township_id").empty();
                        }
                    },
                });
            } else {
                $("#township_id").empty();
            }
        });

        $('#product').change(function() {
            var product_id = $(this).val();

            $.ajax({
                url: "{{ url('getProductInfo') }}?product_id=" + product_id,
                method: "GET",
                success: function(data) {
                    console.log(data);

                    $('#price').val(data.price);
                    $('#discount').val(data.item_discount);
                }
            });
        });

        //get customer info
        $('#customer_id, #home_no, #street_name').on('input', function() {
            updateAddress();
        });

        function updateAddress() {
            var customer_id = $('#customer_id').val();
            var home_no = $('#home_no').val();
            var street_name = $('#street_name').val();

            if (customer_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('getCustomerInfo') }}?customer_id=" + customer_id,
                    success: function(res) {
                        // console.log("hello", res);

                        // Set values for the selects based on received data
                        $('#phone_primary').val(res.phone_primary);
                        $('#phone_secondary').val(res.phone_secondary);
                        $('#division_id').val(res.division_id);

                        // Set the selected option for district_id based on its value
                        $('#district_id').val(res.district_id);

                        // Set the selected option for township_id based on its value
                        $('#township_id').val(res.township_id);

                        // Set the values for the dynamic fields
                        $('#home_no').val(home_no);
                        $('#street_name').val(street_name);

                        // Set the address field by concatenating all relevant values
                        $('#address').val(home_no + ', ' + street_name + ', ' + res
                            .township_name + ', ' + res.division_name);
                    }
                });
            }
        }
        $('#category_id').change(function() {
            var category_id = $(this).val();
            console.log(category_id);
            if (category_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('getProduct') }}?category_id=" + category_id,
                    success: function(res) {
                        console.log(res);
                        if (res && res.length > 0) {
                            $("#product").empty();
                            $("#product").append('<option disabled selected>Select Product</option>');
                            $("#price").val(''); // Clear the price field

                            $.each(res, function(index, product) {
                                $('#product').append('<option value="' + product.id + '">' +
                                    product.product_name + '</option>');
                            });

                            // Auto-select the first product and update the price
                            $("#product").val(res[0].id);
                            $("#price").val(res[0].price);
                        } else {
                            $("#product").empty();
                            $("#price").val('');
                        }
                    },
                });
            }
        });
        $(document).on("change keyup blur", "#discount", function() {
            var original_price = $('#price').val();
            var discount = $('#discount').val();
            // var quantity = $('#quantity').val();
            var decimal = (discount / 100).toFixed(2);
            // console.log(discount);
            var multiply = original_price * decimal;
            var discount_price = original_price - multiply;
            // console.log(discount_price);
            $('#discount_price').val(discount_price);
        });

        $(document).on("change keyup blur", "#quantity, #discount_price, #price", function() {
            var quantity = parseFloat($('#quantity').val()) || 0;
            var discount_price = parseFloat($('#discount_price').val()) || 0;
            var original_price = parseFloat($('#price').val()) || 0;

            var total_price;

            if (discount_price === 0) {
                total_price = original_price * quantity;
            } else {
                total_price = discount_price * quantity;
            }

            $('#total_price').val(total_price.toFixed(0)); // Optionally, round to 2 decimal places
        });
    </script>
@endsection
