<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\ContentUs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function AllContact()
    {
        $contact_data = ContactUs::latest()->get();
        return view('backend.contact.all_contact', compact('contact_data'));
    }
    public function AddContact()
    {
        return view('backend.contact.add_contact');
    }
    public function StoreContact(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'company_name' => ['required', 'max:255'],
                'address' => ['required'],
                'phone'  => ['required'],
            ]);
            if ($validator->fails()) {
                $notification = [
                    'message' => 'Contact creation failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }
            $data = new ContactUs;
            $data->company_name = $request->company_name;
            $data->address = $request->address;
            $data->phone  = $request->phone;
            $data->save();

            $notification = [
                'message' => 'Contact created successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.contact')->with($notification);
        } catch (Exception $e) {
            $notification = [
                'message' => 'Contact creation failed. An unexpected error occurred.',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }
    public function EditContact($id)
    {
        $contact = ContactUs::findOrFail($id);
        return view('backend.contact.edit_contact', compact('contact'));
    }
    public function UpdateContact(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'company_name' => ['required', 'max:255'],
                'address' => ['required'],
                'phone'  => ['required', 'numeric'],
            ]);
            if ($validator->fails()) {
                $notification = [
                    'message' => 'Contact update failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }
            $data = ContactUs::findOrFail($id);
            $data->company_name = $request->company_name;
            $data->address = $request->address;
            $data->phone  = $request->phone;
            $data->save();

            $notification = [
                'message' => 'Contact Updated successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.contact')->with($notification);
        } catch (Exception $e) {
            $notification = [
                'message' => 'Contact update failed. An unexpected error occurred.',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }
    public function DeleteContact($id)
    {
        ContactUs::findOrFail($id)->delete();
        $notification = [
            'message' => 'Contact Deleted Successfully.',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.contact')->with($notification);
    }
}
