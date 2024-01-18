<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Exception;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{
    public function AllAbout()
    {
        $allabout = AboutUs::latest()->get();
        return view('backend.about.all_about', compact('allabout'));
    }
    public function AddAbout()
    {
        $aboutProfile = AboutUs::first();
        return view('backend.about.add_about', compact('aboutProfile'));
    }
    public function storeAbout(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255'],
                'content' => ['required'],
                'photo' => ['required', 'mimes:jpeg,png,jpg|max:2048'],
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                $notification = [
                    'message' => 'About creation failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }

            // Create a new AboutUs instance
            $data = new AboutUs;
            $data->title = $request->title;
            $data->content = $request->content;

            // Handle photo upload
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $file = $request->file('photo');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/about_images'), $filename);
                $data->photo = $filename;
            }

            // Save the data to the database
            $data->save();

            $notification = [
                'message' => 'About created successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.about')->with($notification);
        } catch (Exception $e) {
            // Handle exceptions
            $notification = [
                'message' => 'About creation failed. An unexpected error occurred.',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }

    public function EditAbout($id)
    {
        $about = AboutUs::findOrFail($id);
        return view('backend.about.edit_about', compact('about'));
    }
    public function UpdateAbout(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255'],
                'content' => ['required'],
                'photo' => ['required', 'mimes:jpeg,png,jpg|max:2048'],
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                $notification = [
                    'message' => 'About Update failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }

            $about = AboutUs::findOrFail($id);
            $about->title = $request->title;
            $about->content = $request->content;

            if ($request->file('photo')) {
                $file = $request->file('photo');
                @unlink(public_path('upload/about_images/' . $about->photo));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/about_images'), $filename);
                $about->photo = $filename;

                $about->save();
                $notification = array(
                    'message' => 'About create successfully',
                    'alert-type' => 'success'
                );
                return redirect()->route('all.about')->with($notification);
            }
        } catch (Exception $e) {
            // Handle exceptions
            $notification = [
                'message' => 'About Update failed. An unexpected error occurred.',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }

    public function DeleteAbout($id)
    {
        AboutUs::findOrFail($id)->delete();
        $notification = array(
            'message' => 'About Deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.about')->with($notification);
    }
}
