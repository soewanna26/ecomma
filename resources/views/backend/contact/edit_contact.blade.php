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
                                <h6 class="card-title">Update Contact Form</h6>

                                <form class="forms-sample" method="POST" action={{ route('update.contact', $contact->id) }}
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">Company_name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                            value="{{ $contact->company_name }}" autocomplete="off">
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('company_name') }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" name="address" id="address" placeholder="address" style="height: 100px; width:50%;">{{ $contact->address }}</textarea>
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('address') }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            autocomplete="off" value="{{ $contact->phone }}">
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2">Update Change</button>
                                    <a href="{{ route('all.contact') }}" class="btn btn-danger">Cancel</a>
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
