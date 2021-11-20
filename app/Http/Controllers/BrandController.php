<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    public function AllBrand() {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    public function StoreBrand(Request $request) {
        $validatedData = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg,jpeg,png,gif',
        ],
        [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_image.max' => 'Brand should be longer than 4 characters',
        ]);

        $brand_image = $request->file('brand_image');

        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location,$img_name);

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Brand Inserted Successfully');
    }

    public function Edit($id) {
        $brands = Brand::find($id);
        return view('admin.brand.edit', compact('brands'));
    }

    public function Update(Request $request, $id) {
        $validatedData = $request->validate([
            'brand_name' => 'required|min:4',
            
        ],
    [
        'brand_name.required' => 'Please Input Brand Name',
        'brand_image.max' => 'Brand should be longer than 4 characters',
    ]);

    $old_image = $request->old_image;

    $brand_image = $request->file('brand_image');

//If a new image is selected, update the brand name and the image.
    if($brand_image){

        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image -> move($up_location,$img_name);

        unlink($old_image);
        Brand::find($id)->update([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);
        return Redirect() -> back() -> with('success', 'Brand Updated Successfully');
        
//Else if no new image is selected, update just the brand name.
    } else {
        Brand::find($id)->update([
            'brand_name' => $request->brand_name,
            
            'created_at' => Carbon::now()
        ]);
        return Redirect() -> back() -> with('success', 'Brand Updated Successfully');

    }


    

    }
}



