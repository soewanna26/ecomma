@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('add.invoice') }}" class="btn btn-inverse-info">Add Invoice</a>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Invoice</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer Name</th>
                                        <th>PayMent</th>
                                        <th>Total-Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $invoice->cus_name }}</td>
                                            <td>{{ $invoice->payment_method }}</td>
                                            <td>{{ $invoice->payment_method }}</td>
                                            <td>{{ $invoice->status }}</td>
                                            <td>
                                                <a href="{{ route('edit.invoice', $invoice->id) }}"
                                                    class="btn btn-inverse-warning">Edit</a>
                                                <a href="{{ route('delete.invoice', $invoice->id) }}"
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
