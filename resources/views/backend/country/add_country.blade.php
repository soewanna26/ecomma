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
                                <h6 class="card-title">Country Form</h6>

                                <form class="forms-sample" method="POST" action={{ route('store.country') }}>
                                    @csrf

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            autocomplete="off">
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="code" class="form-label">Code</label>
                                        <input type="number" class="form-control" id="code" name="code"
                                            autocomplete="off">
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('code') }}
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2">Save Change</button>
                                    <a href="{{ route('all.country') }}" class="btn btn-danger">Cancel</a>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
