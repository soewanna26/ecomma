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
                                <h6 class="card-title">Customer Update Form</h6>

                                <form action="{{ route('update.customer', $customer->id) }}" method="POST"
                                    class="forms-sample" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Customer Name</label>
                                                <input type="text" class="form-control" name="customer_name"
                                                    id="" placeholder="Customer Name" required
                                                    value="{{ $customer->customer_name }}">
                                                <div class="text-danger form-control-feedback">
                                                    {{ $errors->first('customer_name') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Primary Phone</label>
                                                <input type="text" class="form-control" name="phone_primary"
                                                    id="" value="{{ $customer->phone_primary }}" required>
                                                <div class="text-danger form-control-feedback">
                                                    {{ $errors->first('phone_primary') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Country Name</label>
                                                <select class="form-select bg-dark text-light" name="country_id"
                                                    aria-label="Default select example" required>
                                                    <option disabled selected> Choose Country </option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}"
                                                            @if ($customer->country_id == $country->id) selected= "selected" @endif>
                                                            {{ $country->name }} </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger form-control-feedback">
                                                    {{ $errors->first('country_id') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">State/Division</label>
                                                <select class="form-select bg-dark text-light" name="division_id"
                                                    id="division_id" aria-label="Default select example" required>
                                                    <option disabled selected> Select Division </option>
                                                    @foreach ($divisions as $division)
                                                        <option value="{{ $division->id }}"
                                                            @if ($customer->division_id == $division->id) selected = 'selected' @endif
                                                            {{ old('division_id') == $division->division_name ? 'selected' : '' }}>
                                                            {{ $division->division_name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger form-control-feedback">
                                                    {{ $errors->first('division_id') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">District</label>
                                                <select class="form-select bg-dark text-light" name="district_id"
                                                    id="district_id" aria-label="Default select example" required>
                                                    @foreach ($districts as $district)
                                                        <option value="{{ $district->id }}"
                                                            @if ($customer->district_id == $district->id) selected @endif>
                                                            {{ $district->district_name }} </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger form-control-feedback">
                                                    {{ $errors->first('district_id') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Township</label>
                                                <select class="form-select bg-dark text-light" name="township_id"
                                                    id="township_id" aria-label="Default select example" required>
                                                    @foreach ($townships as $township)
                                                        <option value="{{ $township->id }}"
                                                            @if ($customer->township_id == $township->id) selected @endif>
                                                            {{ $township->township_name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger form-control-feedback">
                                                    {{ $errors->first('township_id') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Address </label>
                                                <textarea name="address" id="address" class="form-control bg-dark" required>{{$customer->address}}{{ old('address') }}</textarea>
                                                <div class="text-danger form-control-feedback">
                                                    {{ $errors->first('address') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2">Save</button>
                                    <a href="{{ route('all.customer') }}" class="btn btn-light">Cancel</a>
                                </form>

                            </div>
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
    </script>
@endsection
