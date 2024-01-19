@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('add.product') }}" class="btn btn-inverse-info">Add Product</a>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Product</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Categories</th>
                                        <th>Description</th>
                                        <th>Price(MMK)</th>
                                        <th>Price($)</th>
                                        <th>Size Type</th>
                                        <th class="text-center">Small <br> Quantity</th>
                                        <th class="text-center">Medium <br> Quantity</th>
                                        <th class="text-center">Large <br> Quantity</th>
                                        <th class="text-center">XLarge <br> Quantity</th>
                                        <th class="text-center">2XLarge <br> Quantity</th>
                                        <th class="text-center">3XLarge <br> Quantity</th>
                                        <th>Update Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $product->id }}</td>
                                            <td>
                                                <img src="{{ !empty($item->photo) ? url('upload/product_images/' . $item->photo) : url('upload/no_image.jpg') }}"
                                                    style="object-fit: cover" alt="" class="rounded">
                                                {{ $item->product_name }}
                                            </td>
                                            <td>{{ $product->cat_name }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td>{{ number_format($product->price) }}</td>
                                            <td>{{ number_format($product->dollor) }}</td>
                                            {{-- <td>{{ $product->color }}</td> --}}
                                            <td>{{ $product->size_type }}</td>
                                            <td>{{ $product->small_quantity }}</td>
                                            <td>{{ $product->medium_quantity }}</td>
                                            <td>{{ $product->large_quantity }}</td>
                                            <td>{{ $product->xlarge_quantity }}</td>
                                            <td>{{ $product->xxlarge_quantity }}</td>
                                            <td>{{ $product->xxxlarge_quantity }}</td>
                                            <td>
                                                <form id="product-update-status" action="{{ route('pupdate_status') }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <div class="row g-1">
                                                        <div class="col-md-12">
                                                            <select name="status" id="{{ $product->id }}"
                                                                class="pstatus-select form-select bg-light text-dark text-center {{ $product->id }}">
                                                                <option value="" disabled
                                                                    class="bg-secondary text-light">Select Order Status
                                                                </option>
                                                                <option value="active"
                                                                    {{ $product->status == 'active' ? 'selected' : '' }}>
                                                                    Active</option>
                                                                <option value="unactive"
                                                                    {{ $product->status == 'unactive' ? 'selected' : '' }}>
                                                                    Unactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                                {{-- {{ $product->status }} --}}
                                            </td>
                                            <td>
                                                <a href="{{route('products.gallery'),$product->id}}"
                                                    class="text-decoration-none">
                                                    <button class="btn btn-outline-info py-1"><i
                                                            class="ti-gallery"></i></button>
                                                </a>
                                                <a href="{{ route('edit.category', $product->id) }}"
                                                    class="btn btn-inverse-warning">Edit</a>
                                                <a href="{{ route('delete.category', $product->id) }}"
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
