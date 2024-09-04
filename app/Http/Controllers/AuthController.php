<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use App\Models\User;

class AuthController extends Controller
{
    public function login(){
        $data['title'] = 'Login';
        return view("admin.authentication.login")->with($data);
    }

    public function checkuser(Request $request){
        // if(Auth::attempt(["email"=>$r->email,"password"=>$r->password])){
        //     return redirect(url('admin/dashboard'));
        // }else{
        //     return redirect(url('/admin-login'))->with(["msg"=>"Invalid Login"]);
        // }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Authentication passed
            return redirect(route('dashboard'));
        }

        // Authentication failed
        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function change_password(){
        $data['title'] = 'Change Password';
        return view("admin.authentication.change_pass")->with($data);
    }

    public function change_pass(Request $r){
        $cp = $r->cp;
        $np = $r->np;
        $conpass = $r->conpass;
        if (Hash::check($cp, Auth::user()->password)) {
            if($np == $conpass){
                $obj = User::find(Auth::user()->id);
                $obj->password = bcrypt($np);
                $obj->update();
                Auth::logout();
                return redirect(url('/'));
            } else{
                return redirect(url('/changepass'))->with(["msg"=>"Not Matched Confirm Password"]);
            }
        } else {
            return redirect(url('/changepass'))->with(["msg"=>"Not Matched Current Password"]);
        }
    }  
}
