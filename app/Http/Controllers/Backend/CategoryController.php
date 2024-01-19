<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function AllCategory()
    {
        $category_data = Category::latest()->get();
        return view('backend.category.all_category', compact('category_data'));
    }
    public function AddCategory()
    {
        return view('backend.category.add_category');
    }
    public function StoreCategory(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:255'],
                'name_mm' => ['required'],
            ]);
            if ($validator->fails()) {
                $notification = [
                    'message' => 'Category creation failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }
            $data = new Category;
            $data->name = $request->name;
            $data->name_mm = $request->name_mm;
            $data->save();
            $notification = [
                'message' => 'Category creation successful',
                'alert-type' => 'success',
            ];
            return redirect()->route('all.category')->with($notification);
        } catch (Exception $e) {
            $notification = [
                'message' => 'Category creation failed. An unexpected error occurred.',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }
    public function EditCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.category.edit_category',compact('category'));
    }
    public function UpdateCategory(Request $request,$id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:255'],
                'name_mm' => ['required'],
            ]);
            if ($validator->fails()) {
                $notification = [
                    'message' => 'Category Update failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }
            $data = Category::findOrFail($id);
            $data->name = $request->name;
            $data->name_mm = $request->name_mm;
            $data->save();
            $notification = [
                'message' => 'Category Update successful',
                'alert-type' => 'success',
            ];
            return redirect()->route('all.category')->with($notification);
        } catch (Exception $e) {
            $notification = [
                'message' => 'Category Update failed. An unexpected error occurred.',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }
    public function DeleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        $notification = [
            'message' => 'Contact Deleted Successfully.',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }
}
