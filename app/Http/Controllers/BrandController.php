<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Multipic;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;


class BrandController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AllBrand()
    {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    public function StoreBrand(Request $request)
    {
        $validatedData = $request->validate(
            [
                'brand_name' => 'required|unique:brands|min:4',
                'brand_image' => 'required|mimes:jpg,jpeg,png,gif',
            ],
            [
                'brand_name.required' => 'Please Input Brand Name',
                'brand_image.max' => 'Brand should be longer than 4 characters',
            ]
        );

        $brand_image = $request->file('brand_image');

        // $name_gen = hexdec(uniqid());
        // $img_ext = strtolower($brand_image->getClientOriginalExtension());
        // $img_name = $name_gen.'.'.$img_ext;
        // $up_location = 'image/brand/';
        // $last_img = $up_location.$img_name;
        // $brand_image->move($up_location,$img_name);

        $name_gen = hexdec(uniqid()) . '.' . $brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300, 200)->save('image/brand/' . $name_gen);
        $last_img = 'image/brand/' . $name_gen;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);
    }

    public function Edit($id)
    {
        $brands = Brand::find($id);
        return view('admin.brand.edit', compact('brands'));
    }

    public function Update(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'brand_name' => 'required|min:4',

            ],
            [
                'brand_name.required' => 'Please Input Brand Name',
                'brand_image.max' => 'Brand should be longer than 4 characters',
            ]
        );

        $old_image = $request->old_image;

        $brand_image = $request->file('brand_image');

        //If a new image is selected, update the brand name and the image.
        if ($brand_image) {

            // $name_gen = hexdec(uniqid());
            // $img_ext = strtolower($brand_image->getClientOriginalExtension());
            // $img_name = $name_gen.'.'.$img_ext;
            // $up_location = 'image/brand/';
            // $last_img = $up_location.$img_name;
            // $brand_image -> move($up_location,$img_name);

            $name_gen = hexdec(uniqid()) . '.' . $brand_image->getClientOriginalExtension();
            Image::make($brand_image)->resize(300, 200)->save('image/brand/' . $name_gen);
            $last_img = 'image/brand/' . $name_gen;

            unlink($old_image);
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_img,
                'created_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Brand Updated Successfully',
                'alert-type' => 'info'
            );

            return Redirect()->back()->with($notification);

            //Else if no new image is selected, update just the brand name.
        } else {
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,

                'created_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Brand Updated Successfully',
                'alert-type' => 'warning'
            );

            return Redirect()->back()->with($notification);
        }
    }

    public function Delete($id)
    {
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);

        Brand::find($id)->delete();
        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'error'
        );
        return Redirect()->back()->with($notification);
    }

    // This is for the Multi Image All Method

    public function Multipic()
    {
        $images = Multipic::all();
        return view('admin.multipic.index', compact('images'));
    }

    public function StoreImage(Request $request)
    {
        $image = $request->file('image');

        foreach ($image as $multi_img) {
            $name_gen = hexdec(uniqid()) . '.' . $multi_img->getClientOriginalExtension();
            Image::make($multi_img)->resize(300, 300)->save('image/multi/' . $name_gen);
            $last_img = 'image/multi/' . $name_gen;

            Multipic::insert([

                'image' => $last_img,
                'created_at' => Carbon::now()
            ]);
        }
        return Redirect()->back()->with('success', 'Brand Inserted Successfully');
    }

    public function Logout()
    {
        Auth::logout();
        return Redirect()->route('login')->with('success', 'User Logout');
    }
}
