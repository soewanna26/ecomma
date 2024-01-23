<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Customer;
use App\Models\District;
use App\Models\Division;
use App\Models\Township;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function AllCustomer()
    {
        $customers = Customer::get();
        return view('backend.customer.all_customer', compact('customers'));
    }
    public function AddCustomer()
    {
        $countries = Country::select('name','id')->get();
        $divisions = Division::orderby('division_name')->select('division_name','id')->get();
        return view('backend.customer.add_customer',compact('divisions','countries'));
    }
    public function StoreCustomer(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_name' => ['required'],
                'phone_primary' => ['required'],
                'address'  => ['required'],
                'country_id' => ['required'],
                'division_id' => ['required'],
                'district_id' => ['required'],
                'township_id' => ['required'],
            ]);
            if ($validator->fails()) {
                $notification = [
                    'message' => 'Customer creation failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }
            $data = new Customer;
            $data->customer_name = $request->customer_name;
            $data->phone_primary = $request->phone_primary;
            $data->address = $request->address;
            $data->country_id  = $request->country_id;
            $data->division_id = $request->division_id;
            $data->district_id = $request->district_id;
            $data->township_id = $request->township_id;

            $data->save();
            $notification = [
                'message' => 'Customer create Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('all.customer')->with($notification);
        } catch (Exception $e) {
            Log::error($request->all());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function EditCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('backend.customer.add_customer', compact('customer'));
    }

    public function UpdateCustomer(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_name' => ['required'],
                'phone_primary' => ['required'],
                'address'  => ['required'],
                'country_id' => ['required'],
                'division_id' => ['required'],
                'district_id' => ['required'],
                'township_id' => ['required'],
            ]);
            if ($validator->fails()) {
                $notification = [
                    'message' => 'Customer creation failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }
            $data = Customer::findOrFail($id);
            $data->customer_name = $request->customer_name;
            $data->phone_primary = $request->phone_primary;
            $data->address = $request->address;
            $data->country_id  = $request->country_id;
            $data->division_id = $request->division_id;
            $data->district_id = $request->district_id;
            $data->township_id = $request->township_id;

            $data->save();
            $notification = [
                'message' => 'Customer create Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('all.customer')->with($notification);
        } catch (Exception $e) {
            Log::error($request->all());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function DeleteCustomer($id)
    {
        Customer::findOrFail($id)->delete();
        $notification = [
            'message' => 'Customer Delete Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('all.customer')->with($notification);
    }

    public function getDistrict(Request $request)
    {
        $dists = District::where("division_id",$request->division_id)
                    ->pluck("district_name","id");
        return response()->json($dists);
    }

    public function getTownship(Request $request)
    {
        $towns = Township::where("district_id",$request->district_id)
                    ->pluck("township_name","id");
        return response()->json($towns);
    }
}
