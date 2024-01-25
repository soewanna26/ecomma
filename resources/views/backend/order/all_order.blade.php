@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('add.order') }}" class="btn btn-inverse-info">Add Order</a>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="card-title d-inline mt-2">ORDER LIST
                            </h4>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Product Name</th>
                                                <th>Delivery Info</th>
                                                <th>Payment method</th>
                                                <th>Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = 1; @endphp
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td id="order-{{ $order->id }}">{{ $order->id }}</td>
                                                    <td>{{ $order->customer ? $order->customer->customer_name : "-" }}</td>
                                                    <td>{{$order->product->product_name}}</td>
                                                    <td>{{ $order->customer ?$order->customer->phone_primary:"-" }}<br><br>
                                                        {{ $order->deli_info->delivery_address ?? '' }}
                                                    </td>
                                                    <td><span class="badge badge-pill bg-info">
                                                            {{ $order->payment_method ?? '' }}
                                                        </span></td>
                                                    <td id="badge-{{ $order->id }}">
                                                        @if ($order->status == 'pending')
                                                            <span class="badge badge-pill badge-warning">
                                                                {{ $order->status }}
                                                            </span>
                                                        @elseif ($order->status == 'success')
                                                            <span class="badge badge-pill badge-success">
                                                                {{ $order->status }}
                                                            </span>
                                                        @elseif ($order->status == 'delivering')
                                                            <span class="badge badge-pill badge-primary">
                                                                {{ $order->status }}
                                                            </span>
                                                        @elseif ($order->status == 'confirmed')
                                                            <span class="badge badge-pill badge-info">
                                                                {{ $order->status }}
                                                            </span>
                                                        @else
                                                            <span class="badge badge-pill badge-danger">
                                                                {{ $order->status }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    {{-- <td>
                                                        <form id="update-status-form" action="{{ route('update_status') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="order_id"
                                                                value="{{ $order->id }}">
                                                            <div class="row g-1">
                                                                <div class="col-md-12">
                                                                    <select name="status" id="{{ $order->id }}"
                                                                        class="status-select form-select bg-light text-dark text-center {{ $order->id }}">
                                                                        <option value="" disabled
                                                                            class="bg-secondary text-light">Select Order
                                                                            Status</option>
                                                                        <option value="pending"
                                                                            {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                                            Pending</option>
                                                                        <option value="confirmed"
                                                                            {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                                                            Confirmed</option>
                                                                        <option value="success"
                                                                            {{ $order->status == 'success' ? 'selected' : '' }}>
                                                                            Success</option>
                                                                        <option value="delivering"
                                                                            {{ $order->status == 'delivering' ? 'selected' : '' }}>
                                                                            Delivering</option>
                                                                        <option value="cancelled"
                                                                            {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                                            Cancelled</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td> --}}
                                                    <td class="text-center">
                                                        <a href="{{route('edit.order',$order->id)}}">
                                                            <button class="btn btn-outline-secondary pt-1 pb-1">
                                                                <i class="fa fa-pencil"></i>
                                                            </button>
                                                        </a>
                                                        <a href="{{route('delete.order',$order->id)}}"id="delete">
                                                            <button class="btn btn-outline-danger pt-1 pb-1"> <i
                                                                    class="fa fa-trash" ></i> </button>
                                                        </a>
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
    </div>
@endsection
