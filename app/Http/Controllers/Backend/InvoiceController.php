<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function AllInvoice()
    {
        $invoices = DB::table('invoices')
            ->leftJoin('customers', 'customers.id', '=', 'invoices.customer_id')
            ->select('invoices.*', 'customers.customer_name as cus_name')
            ->get();

        return view('backend.invoice.all_invoice', compact('invoices'));
    }

    public function AddInvoice()
    {
        $customers = Customer::select('customer_name', 'id')->get();
        return view('backend.invoice.add_invoice', compact('customers'));
    }
    public function StoreInvoice(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required',
                'payment_method' => 'required',
                'total_price' => 'required',
                'status' => 'required',
            ]);
            if ($validator->fails()) {
                $notification = [
                    'message' => 'Invoice creation failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }
            $invoice = new Invoice;
            $invoice->customer_id = $request->customer_id;
            $invoice->payment_method = $request->payment_method;
            $invoice->total_price = $request->total_price;
            $invoice->status = $request->status;
            $invoice->save();

            $notification = [
                'message' => 'Invoice Create Successful',
                'alert-type' => 'success',
            ];
            return redirect()->route('all.invoice')->with($notification);
        } catch (Exception $e) {
            Log::error('error');

            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function EditInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $customer = Customer::select('customer_name', 'id')->get();
        return view('backend.invoice.edit_invoice', compact('invoice', 'customer'));
    }

    public function UpdateInvoice(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required',
                'payment_method' => 'required',
                'total_price' => 'required',
            ]);

            if ($validator->fails()) {
                $notification = [
                    'message' => 'Invoice Update failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }

            $invoice = Invoice::findOrFail($id);
            $invoice->customer_id = $request->customer_id;
            $invoice->payment_method = $request->payment_method;
            $invoice->total_price = $request->total_price;
            $invoice->status = $request->status;
            $invoice->save();

            $notification = [
                'message' => 'Invoice Update Successful',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.invoice')->with($notification);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function DeleteInvoice($id)
    {
        Invoice::findOrFail($id)->delete();
        $notification = [
            'message' => 'Invoice Delete Successful',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
