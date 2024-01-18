@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('add.about') }}" class="btn btn-inverse-info">Add Property Type</a>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">About</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>S1</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allabout as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>
                                                <div
                                                    style="display:inline-block; overflow:hidden; text-overflow:ellipsis; position: relative; width:100%">
                                                    {{ $item->content }}</div>
                                            </td>
                                            <td>
                                                <img src="{{ !empty($item->photo) ? url('upload/about_images/' . $item->photo) : url('upload/no_image.jpg') }}"
                                                    class="img-fluid" style="width: 60px; height: 40px;" alt="About Photo">
                                            </td>
                                            <td>
                                                <a href="{{ route('edit.about', $item->id) }}"
                                                    class="btn btn-inverse-warning">Edit</a>
                                                <a href="{{ route('delete.about', $item->id) }}"
                                                    class="btn btn-inverse-danger" id="delete">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
