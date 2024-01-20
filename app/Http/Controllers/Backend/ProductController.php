<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DeliveryInfo;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function AllProduct()
    {
        $products = DB::table('products')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.*', 'categories.name as cat_name')
            ->get();
        return view('backend.product.all_product', compact('products'));
    }
    public function AddProduct()
    {
        $categories = Category::select('name', 'id')->get();
        return view('backend.product.add_product', compact('categories'));
    }
    public function StoreProduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_name' => ['required', 'string', 'max:255'],
                'category_id' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
                'price' => ['required', 'string', 'max:255'],
                'dollor' => ['required', 'string', 'max:255'],
                'size_type' => ['required'],
                'small_quantity' => ['required', 'numeric', 'max:255'],
                'medium_quantity' => ['required', 'numeric', 'max:255'],
                'large_quantity' => ['required', 'numeric', 'max:255'],
                'xlarge_quantity' => ['required', 'numeric', 'max:255'],
                'xxlarge_quantity' => ['required', 'numeric', 'max:255'],
                'xxxlarge_quantity' => ['required', 'numeric', 'max:255'],
                'photo' => ['required', 'mimetypes:image/jpg,image/png,image/svg,image/jpeg'],
                'status' => ['required']
            ]);
            if ($validator->fails()) {
                $notification = [
                    'message' => 'Product creation failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }

            $product = new Product;
            $product->product_name = $request->product_name;
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->dollor = $request->dollor;
            if ($request->size_type === 'no' || $request->size_type === 'free') {
                // $product->has_size = 0;
                $product->size_type = $request->size_type;
                $product->small_quantity = $request->one_quantity;
            } else {
                // $product->has_size = 1;
                $product->size_type = $request->size_type;
                $product->small_quantity = $request->small_quantity;
                $product->medium_quantity = $request->medium_quantity;
                $product->large_quantity = $request->large_quantity;
                $product->xlarge_quantity = $request->xlarge_quantity;
                $product->xxlarge_quantity = $request->xxlarge_quantity;
                $product->xxxlarge_quantity = $request->xxxlarge_quantity;
            }
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/product_images'), $filename);
                $product->photo = $filename;
            }
            $product->visable_time = $request->visable_time;
            $product->status = $request->status;
            $product->save();

            $notification = [
                'message' => 'Product created successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.product')->with($notification);
        } catch (Exception $e) {
            $notification = [
                'message' => 'Product creation failed. An unexpected error occurred.',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }

    public function EditProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::get();
        return view('backend.product.edit_product', compact('product', 'categories'));
    }
    public function UpdateProduct(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_name' => ['required', 'string', 'max:255'],
                'category_id' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
                'price' => ['required', 'string', 'max:255'],
                'dollor' => ['required', 'string', 'max:255'],
            ]);
            if ($validator->fails()) {
                $notification = [
                    'message' => 'About Update failed. Please check the form for errors.',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->withErrors($validator)->with($notification);
            }
            $product = Product::findOrFail($id);
            $product->product_name = $request->product_name;
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->dollor = $request->dollor;
            if ($product->size_type != "normal") {
                $product->small_quantity = $request->one_quantity;
            } else {
                $product->small_quantity = $request->small_quantity;
                $product->medium_quantity = $request->medium_quantity;
                $product->large_quantity = $request->large_quantity;
                $product->xlarge_quantity = $request->xlarge_quantity;
                $product->xxlarge_quantity = $request->xxlarge_quantity;
                $product->xxxlarge_quantity = $request->xxxlarge_quantity;
            }
            if ($request->file('photo')) {
                $file = $request->file('photo');
                @unlink(public_path('upload/about_images/' . $product->photo));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/product_images'), $filename);
                $product->photo = $filename;
            }
            $product->visable_time = $request->visable_time;
            $product->save();
            $notification = [
                'message' => 'Product update successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.product')->with($notification);
        } catch (Exception $e) {
            $notification = [
                'message' => 'Product Update failed. An unexpected error occurred.',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }

    public function DeleteProduct($id)
    {
        $product = Product::find($id);
        $order_product = Order::where('product_id', $id)->first();

        // Delete the associated photo file
        if (!empty($product->photo)) {
            $filePath = public_path('upload/product_images') . '/' . $product->photo;

            // Check if the file exists before attempting to delete
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the file
            }
        }

        if ($order_product) {
            Order::where('product_id', $id)->delete();
            Invoice::where('id', $order_product->invoice_id)->delete();
            DeliveryInfo::where('id', $order_product->id)->delete();
        }

        $product->delete();
        $notification = [
            'message' => 'Product Deleted Successfully.',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.product')->with($notification);
    }
    public function update_product_status(Request $request)
    {
        $product_id = $request->product_id;
        DB::table('products')->where('id', $product_id)->update([
            'status' => $request->status
        ]);
        $notification = [
            'message' => 'Product Status Update Successfully.',
            'alert-type' => 'success'
        ];
        return redirect()->route('all.product')->with($notification);
    }
    public function gallery($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.product.gallery', compact('product'));
    }

    public function uploadPhoto(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Ensure that $product->photo is an array or initialize it as an empty array
        $product->photo = $product->photo ?? [];

        if ($request->hasFile('photo')) {
            $files = $request->file('photo');
            $newPhotos = [];

            foreach ($files as $file) {
                // Handle each file individually
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/product_images'), $filename);

                // Add the filename to the list of new photos
                $newPhotos[] = $filename;
            }

            // Concatenate the new photos with the existing ones
            $product->photo = array_merge($product->photo, $newPhotos);

            // Save the updated photos in the database
            $product->update();
        }

        return redirect()->back()->with('success', 'Successfully added more images');
    }

    public function deletePhoto(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Remove the specified photo from the array
        $photos = is_array($product->photo) ? $product->photo : explode(',', $product->photo);
        $photoToDelete = $request->photo;

        if (($key = array_search($photoToDelete, $photos)) !== false) {
            // Remove the photo from the array
            unset($photos[$key]);

            // Update the product with the modified photo array
            $product->photo = $photos;
            $product->update();

            // Delete the actual file from the server
            $filePath = public_path('upload/product_images/' . $photoToDelete);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            return redirect()->back()->with('success', 'Successfully deleted the photo');
        } else {
            return redirect()->back()->with('error', 'Photo not found');
        }
    }
}
