<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

class ChangePassword extends Controller
{
    public function ChangePassword() {
        return view('admin.body.change_password');
    }

    public function UpdatePassword(Request $request) {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed'
        ]);
        // This below checks if the old password is the same as the hashed password in the database,
        // finds the loggedin user
        // hashes the new password, saves it and logs the old user out.
        // Beautiful
        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->oldpassword, $hashedPassword)) {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();

            $notification = array(
                'message' => 'Password Changed Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('login')->with($notification);
        } else {

            $notification = array(
                'message' => 'Current Password is Invalid',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
    }

    public function PasswordUpdate() {
        if(Auth::user()) {
            $user = User::find(Auth::user()->id);
            if($user) {
                return view('admin.body.update_profile', compact('user'));
            }
        }
    }

        public function UpdateProfile(Request $request) {
 
            $id = Auth::user()->id;
           $data = User::find($id);
           $data->name = $request->name;
           $data->email = $request->email;
    
    
           if ($request->file('profile_photo_path')) {
               $file = $request->file('profile_photo_path');
               
               $filename = date('YmdHi').$file->getClientOriginalName();
               $file->move(public_path('upload/user_images'),$filename);
               $data['profile_photo_path'] = $filename;
           }
           $data->save();
    
           $notification = array(
               'message' => 'User Profile Updated Successfully',
               'alert-type' => 'success'
           );
    
           return redirect()->back()->with($notification);
    
         } // end method 
    
}
