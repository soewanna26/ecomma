<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function AllCountry()
    {
        $countries = Country::get();
        return view('backend.country.all_country',compact('countries'));
    }
    public function AddCountry()
    {
        return view('backend.country.add_country');
    }
    public function StoreCountry(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => ['required'],
            ]);
            if ($validator->fails()) {
                $notification = [
                    'message' => 'Contact creation failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }
            $data = new Country;
            $data->name = $request->name;
            $data->code = $request->code;
            $data->save();

            $notification = [
                'message' => 'Country created successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('all.country')->with($notification);
        }catch(Exception $e){
            Log::error('Country created failed');
            return redirect()->back()->with('Error');
        }
    }

    public function EditCountry($id)
    {
        $country = Country::findOrFail($id);
        return view('backend.country.edit_country', compact('country'));
    }
    public function UpdateCountry(Request $request,$id)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => ['required'],
            ]);
            if ($validator->fails()) {
                $notification = [
                    'message' => 'Contact Update failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }
            $data = Country::findOrFail($id);
            $data->name = $request->name;
            $data->code = $request->code;
            $data->save();

            $notification = [
                'message' => 'Country Update successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('all.country')->with($notification);
        }catch(Exception $e){
            Log::error('Country Update failed');
            return redirect()->back()->with('Error');
        }
    }

    public function DeleteCountry($id)
    {
        Country::findOrFail($id)->delete();
        $notification = [
            'message' => 'Country delected successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('all.country')->with($notification);
    }
}
