<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function HomeSlider() {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function AddSlider() {
        return view('admin.slider.create');
    }

    public function StoreSlider(Request $request) {
        $slider_image = $request->file('image');

        

        $name_gen = hexdec(uniqid()) . '.' . $slider_image->getClientOriginalExtension();
        Image::make($slider_image)->resize(1920, 1088)->save('image/slider/' . $name_gen);
        $last_img = 'image/slider/' . $name_gen;

        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->route('home.slider')->with('success', 'Slider Inserted Successfully');
    }

    public function Edit($id)
    {
        $sliders = Slider::find($id);
        return view('admin.slider.edit', compact('sliders'));
    }

    public function Update(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'title' => 'required|min:4',
                'description' => 'required|min:4',

            ],
            [
                'title.required' => 'Please Input Slider Title',
                'description.required' => 'Please Input Description',
                'brand_image.max' => 'Brand should be longer than 4 characters',
            ]
        );

        $old_image = $request->old_image;

        $image = $request->file('image');

        //If a new image is selected, update the brand name and the image.
        if ($image) {

           

            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 200)->save('image/slider/' . $name_gen);
            $last_img = 'image/slider/' . $name_gen;

            unlink($old_image);
            Slider::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $last_img,
                'created_at' => Carbon::now()
            ]);
            return Redirect()->route('home.slider')->with('success', 'Slider Updated Successfully');

            //Else if no new image is selected, update just the brand name.
        } else {
            Slider::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,

                'created_at' => Carbon::now()
            ]);
            return Redirect()->route('home.slider')->with('success', 'Slider Updated Successfully');
        }
    }

    public function Delete($id)
    {
        $image = Slider::find($id);
        $old_image = $image->image;
        unlink($old_image);

        Slider::find($id)->delete();
        return Redirect()->route('home.slider')->with('success', 'Slider Deleted Successfully');
    }

}
