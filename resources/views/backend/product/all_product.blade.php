@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('add.product') }}" class="btn btn-inverse-info">Add Product</a>&nbsp;&nbsp;&nbsp;
                <a href="{{ route('export.product') }}" class="btn btn-inverse-danger">Export Excel</a>
            </ol>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Product</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableExample">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Product Name</th>
                                            <th>Categories</th>
                                            <th>Description</th>
                                            <th>Price(MMK)</th>
                                            <th>Price($)</th>
                                            <th>Size Type</th>
                                            <th>Quantities</th>
                                            <th>Update Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    {{ $product->product_name }}
                                                </td>
                                                <td>{{ $product->cat_name }}</td>
                                                <td>{{ $product->description }}</td>
                                                <td>{{ number_format($product->price) }}</td>
                                                <td>{{ number_format($product->dollor) }}</td>
                                                <td>{{ $product->size_type }}</td>
                                                <td class="text-center">
                                                    @foreach (['small', 'medium', 'large', 'xlarge', 'xxlarge', 'xxxlarge'] as $size)
                                                        {{ ucfirst($size) }}: {{ $product->{$size . '_quantity'} }}<br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <form class="d-flex align-items-center justify-content-center"
                                                        action="{{ route('pupdate_status') }}" method="POST"
                                                        id="statusForm">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $product->id }}">
                                                        <div class="row g-1">
                                                            <div class="col-md-12">
                                                                <select name="status" class="form-select"
                                                                    onchange="submitForm()">
                                                                    <option value="active"
                                                                        {{ $product->status == 'active' ? 'selected' : '' }}>
                                                                        Active</option>
                                                                    <option value="inactive"
                                                                        {{ $product->status == 'inactive' ? 'selected' : '' }}>
                                                                        Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="{{ route('products.gallery', ['id' => $product->id]) }}"
                                                        class="btn btn-info btn-sm"> Gallery</a>
                                                    <a href="{{ route('edit.product', ['id' => $product->id]) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="{{ route('delete.product', ['id' => $product->id]) }}"
                                                        class="btn btn-danger btn-sm" id="delete">Delete</a>
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
    </div>
    <script>
        function submitForm() {
            document.getElementById('statusForm').submit();
        }
    </script>
@endsection
