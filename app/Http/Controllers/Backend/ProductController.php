<?php

namespace App\Http\Controllers\Backend;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DeliveryInfo;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
                'photo.*' => ['required', 'mimetypes:image/jpg,image/png,image/svg,image/jpeg'],
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

            $photoArray = "";
            foreach ($request->photo as $key => $photo) {
                $product_photo = time() . '.' . $photo->getClientOriginalName();
                $destinationPath = 'public/product_photos/';
                $photo->storeAs($destinationPath, $product_photo);

                if ($key === 0) {
                    $photoArray .= $product_photo;
                } else {
                    $photoArray .= "'x'";
                    $photoArray .= $product_photo;
                }
            }

            $product->visable_time = $request->visable_time;
            $product->photo = $photoArray;
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

            $destinationPath = 'public/product_photos/';
            if ($request->hasFile('photo')) {
                $request->validate([
                    'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240']
                ]);
                $product_photo = time() . '.' . $request->photo->getClientOriginalName();
                $request->photo->storeAs($destinationPath, $product_photo);
            } else {
                $product_photo = $product->photo;
            }

            $product->photo = $product_photo;
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

        $photoArray = explode("'x'", $product->photo);
        foreach ($photoArray as $key => $p) {
            $filePath = 'public/product_photos/' . $p;
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            } else {
                Log::error("File not found: $filePath");
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
        $product = Product::find($id);
        $photoArray = explode("'x'", $product->photo);
        $product_id = $id;
        return view('backend.product.gallery', compact('product', 'photoArray', 'product_id'));
    }

    public function uploadPhoto(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $photoArray = $product->photo;
        foreach ($request->photo as $p) {
            $photoName = time() . '.' . $p->getClientOriginalName();


            if ($photoArray != '') {
                $photoArray .= "'x'";
                $photoArray .= $photoName;
            } else {
                $photoArray .= $photoName;
            }

            // store photo
            $destinationPath = 'public/product_photos/';
            $p->storeAs($destinationPath, $photoName);
        }

        $product->photo = $photoArray;
        $product->update();

        return redirect()->back()->with('success', 'Successfully added more images');
    }

    public function deletePhoto(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $photoArray = explode("'x'", $product->photo);
        $photoArrayName = '';

        $deletedKey = '';

        foreach ($photoArray as $key => $p) {

            if ($p === $request->photo) {
                Storage::delete('public/product_photos/' . $request->photo);

                $deletedKey = $key;
            } else {
                if ($key === 0) {
                    $photoArrayName .= $p;
                } else if ($key === 1 && $deletedKey == '0') {
                    $photoArrayName .= $p;
                } else {
                    $photoArrayName .= "'x'";
                    $photoArrayName .= $p;
                }
            }
        }

        $product->photo = $photoArrayName;
        $product->update();

        return redirect()->back()->with('success', 'Successfully deleted an image');
    }
    public function ExportProduct()
    {
        return Excel::download(new ProductsExport, 'product.xlsx');
    }
}
