<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function AllCat() {
        return view('admin.category.index');
    }

    public function AddCat(Request $request) {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
            
        ],
        //This is how you display your own customized error messages
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category less than 255 characters',
            
        ]
    );
    }
}
