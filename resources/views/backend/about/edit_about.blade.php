@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        .equal-size-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
        }

        .size-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
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
                                <h6 class="card-title">Update About Form</h6>

                                <form class="forms-sample" method="POST" action={{ route('update.about', $about->id) }}
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ $about->title }}" autocomplete="off" required>
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('title') }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Content</label>
                                        <textarea class="form-control" name="content" id="content" placeholder="Content" style="height: 100px; width:50%;">{{ $about->content }}</textarea>
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('content') }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="formFile">File upload</label>
                                        <input class="form-control" type="file" id="image" name="photo"
                                            value="{{ $about->photo }}">
                                        <div class="text-danger form-control-feedback">
                                            {{ $errors->first('photo') }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <img class="wd-80 rounded-circle equal-size-image" id="showImage"
                                            src="{{ !empty($about->photo) ? asset('upload/about_images/' . $about->photo) : asset('upload/no_image.jpg') }}"
                                            alt="profile">
                                    </div>

                                    <button type="submit" class="btn btn-primary me-2">Update Change</button>
                                    <a href="{{ route('all.about') }}" class="btn btn-danger">Cancel</a>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    </script>
@endsection
