<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DeliveryInfo;
use App\Models\District;
use App\Models\Division;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\Township;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function AllOrder()
    {
        $orders = Order::get();
        return view('backend.order.all_order', compact('orders'));
    }

    public function AddOrder()
    {
        $products = Product::select('product_name', 'id')->get();
        $categories = Category::select('name', 'id')->get();
        $customers = Customer::select('customer_name', 'id')->get();
        $divisions = Division::orderby('division_name')->select('division_name', 'id')->get();
        return view('backend.order.add_order', compact('products', 'customers', 'divisions', 'categories'));
    }
    public function update_order_status(Request $request)
    {
        $order_id = $request->order_id;
        DB::table('orders')->where('id', $order_id)->update([
            'status' => $request->status
        ]);
        $notification = [
            'message' => 'Product Status Update Successfully.',
            'alert-type' => 'success'
        ];
        return redirect()->route('all.order')->with($notification);
    }
    public function getProductInfo(Request $request)
    {
        if ($request->get('product_id')) {
            $product_id = $request->get('product_id');
            $product = DB::table('products')
                ->leftJoin('discounts', 'discounts.id', '=', 'products.discount_id')
                ->where('products.id', '=', $product_id)->first();

            return response()->json($product);
        }
    }

    public function getCustomerInfo(Request $request)
    {
        if ($request->get('customer_id')) {
            $customer_id = $request->get('customer_id');
            $customer_info = DB::table('customers')
                ->leftJoin('tbl_divisions', 'tbl_divisions.id', '=', 'customers.division_id')
                ->leftJoin('tbl_districts', 'tbl_districts.id', '=', 'customers.district_id')
                ->leftJoin('tbl_townships', 'tbl_townships.id', '=', 'customers.township_id')
                // ->select('customers.division_name', 'customers.district_name', 'customers.township_name')
                ->where('customers.id', '=', $customer_id)
                ->first();
            return response()->json($customer_info);
        }
    }

    public function getProduct(Request $request)
    {
        $products = Product::where('category_id', $request->category_id)->pluck('product_name', 'id');
        return response()->json($products);
    }
    public function StoreOrder(Request $request)
    { {
            $validator = $request->validate([
                'product_id' => ['required', 'string', 'max:255'],
                'original_price' => ['required', 'numeric'],
                'quantity' => ['required', 'numeric'],
                'total_price' => ['required', 'numeric'],
                'status' => ['required', 'string', 'max:255'],
            ]);

            if ($validator) {
                if ($request->customer_id) {
                    $order = new Order;
                    $order->product_id = $request->product_id;
                    $order->customer_id = $request->customer_id;
                    $order->original_price = $request->original_price;
                    $order->quantity = $request->quantity;
                    $order->on_discount = $request->on_discount;
                    $order->total_price = $request->total_price;
                    $order->status = $request->status;
                    $order->save();

                    $delivery_info = new DeliveryInfo;
                    $delivery_info->customer_id = $order->customer_id;
                    $delivery_info->division_id = $request->division_id;
                    $delivery_info->district_id = $request->district_id;
                    $delivery_info->township_id = $request->township_id;
                    $delivery_info->delivery_address = $request->address;
                    $delivery_info->save();
                }

                if ($request->customer_name) {

                    $customer = new Customer;
                    $customer->customer_name = $request->customer_name;
                    $customer->phone_primary = $request->phone_primary;
                    $customer->phone_secondary = $request->phone_secondary;
                    $customer->division_id = $request->division_id;
                    $customer->district_id = $request->district_id;
                    $customer->township_id = $request->township_id;
                    $customer->address = $request->address;
                    $customer->save();

                    $order = new Order;
                    $order->product_id = $request->product_id;
                    $order->customer_id = $customer->id;
                    $order->original_price = $request->original_price;
                    $order->quantity = $request->quantity;
                    $order->on_discount = $request->on_discount;
                    $order->total_price = $request->total_price;
                    $order->status = $request->status;
                    $order->save();

                    $delivery_info = new DeliveryInfo;
                    $delivery_info->customer_id = $customer->id;
                    $delivery_info->division_id = $customer->division_id;
                    $delivery_info->district_id = $customer->district_id;
                    $delivery_info->township_id = $customer->township_id;
                    $delivery_info->delivery_address = $customer->address;
                    $delivery_info->save();
                }

                if ($request->quantity) {
                    $current_quantity = $request->quantity;

                    // Assuming $order is defined
                    $product = DB::table('products')
                        ->where('id', $order->product_id)
                        ->first();

                    // Assuming you have a 'size_type' column in your 'products' table
                    $size_type = $product->size_type;

                    // Check if the property exists before accessing it
                    $column = $size_type . '_quantity';

                    if (property_exists($product, $column)) {
                        // Update the quantity based on the size dynamically
                        $update_quantity = $product->$column - $current_quantity;

                        // Save the updated quantity back to the database
                        DB::table('products')
                            ->where('id', $order->product_id)
                            ->update([
                                $column => $update_quantity,
                            ]);
                    } else {
                    }
                }


                return redirect()->route('all.order')->with("info", 'New Orders is Added');
            } else {
                return redirect()->back()->withErrors($validator);
            }
        }
    }
    public function EditOrder($id)
    {
        $order = Order::find($id);
        $categories = Category::select('name', 'id')->get();
        $products = Product::select('product_name', 'id')->get();
        $customers = Customer::get();
        $delivery_info = DeliveryInfo::where('id', '=', $id)->first();
        // $order_date = date('Y-m-d\TH:i', strtotime($order->order_date));
        // dd($order_date);
        // $loan_application_date = date('Y-m-d\TH:i', strtotime($loan->loan_application_date));

        // dd($delivery_info);
        $divisions = Division::select('division_name', 'id')->get();
        $districts = District::where('division_id', '=', $delivery_info->division_id)->select('district_name', 'id')->get();
        $townships = Township::where('district_id', '=', $delivery_info->district_id)->select('township_name', 'id')->get();
        return view('backend.order.edit_order', compact('order', 'products', 'customers', 'delivery_info', 'divisions', 'districts', 'townships', 'categories'));
    }

    public function UpdateOrder(Request $request, $id)
    {
        $validator = $request->validate([
            'product_id' => ['required', 'string', 'max:255'],
            'original_price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        if ($validator) {
            $order = Order::find($id);
            $order->product_id = $request->product_id;
            $order->customer_id = $request->customer_id;
            $order->original_price = $request->original_price;
            $order->quantity = $request->quantity;
            $order->on_discount = $request->on_discount;
            $order->total_price = $request->total_price;
            // $order->order_date = $request->order_date;
            $order->status = $request->status;
            $order->save();

            if ($request->product_id) {
                $delivery_info = DeliveryInfo::where('id', '=', $id)->first();
                $delivery_info->delete();

                $delivery_info = new DeliveryInfo;
                $delivery_info->customer_id = $order->customer_id;
                $delivery_info->division_id = $request->division_id;
                $delivery_info->district_id = $request->district_id;
                $delivery_info->township_id = $request->township_id;
                $delivery_info->delivery_address = $request->address;
                $delivery_info->save();
            }

            return redirect()->route('all.order')->with("info", 'Existing Orders is Updated');
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    public function DeleteOrder($id)
    {
        DB::table('ordered_products')->where('id', $id)->delete();
        DB::table('delivery_info')->where('id', $id)->delete();


        return redirect()->route('all.order')->with("info", 'Existing Order is deleted');
    }
}
