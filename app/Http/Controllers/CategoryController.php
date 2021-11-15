<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function AllCat() {
        //Query Builder

        // $categories = DB::table('categories')
        //     ->join('users', 'categories.user_id', 'users.id')
        //     ->select('categories.*', 'users.name')
        //     ->latest()->paginate(5);

        //$categories = DB::table('categories')->latest()->paginate(5);
        
        //Eloquent ORM Reading Data

        $categories = Category::latest()->paginate(5);
        return view('admin.category.index', compact('categories'));
    }

    public function AddCat(Request $request) {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
            
        ],
        //This is how you display your own customized error messages
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category less than 255 characters',
            
        ]);

        //First method for Eloquent ORM

        Category::insert([
           'category_name' => $request->category_name,     //Gets the request as category_name, which is the name of our input field
           'user_id' => Auth::user()->id,                  //Gets the id of the authenticated user
           'created_at' => Carbon::now()                   
        ]);

        //Second method for Eloquent ORM

        // $category = new Category;                           //Creating a new object for our category model
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        //Inserting data with Query Builder

        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return Redirect()->back()->with('success', 'Category Inserted Successfully');
    }

    public function Edit($id) {
        //Eloquent ORM
        // $categories = Category::find($id);

        //Query Builder
        $categories = DB::table('categories')->where('id', $id)->first();

        return view('admin.category.edit', compact('categories'));
    }

    public function Update(Request $request,$id) {
        // Eloquent ORM
        // $update = Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id
        // ]);

        //Query Builder
        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->where('id', $id)->update($data);
        return Redirect()->route('all.category')->with('success', 'Category Updated Successfully');
    }
}
