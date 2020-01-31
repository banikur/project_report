<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class LoginController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getLogin()
    {
        return view('template.front_login.login');
    }

    public function postLogin(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // Attempt to log the user in
        // Passwordnya pake bcrypt
        if(Auth::check()) {


        }

        if (Auth::guard('cashier')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            return redirect()->intended('/Cashier/cashier');
        } else if (Auth::guard('manager')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 4])) {
            return redirect()->intended('/Manager/dashboard');
        } else if (Auth::guard('purchasing')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 2])) {
            return redirect()->intended('/Purchasing/master-dashboard');
        } else if (Auth::guard('koki')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 3])) {
            return redirect()->intended('/Koki/dashboard');
        } else {
            return redirect()->intended('/login');
        }
    }

    public function logout()
    {
        if (Auth::guard('cashier')->check()) {
            Auth::guard('cashier')->logout();
        } elseif (Auth::guard('koki')->check()) {
            Auth::guard('koki')->logout();
        }elseif (Auth::guard('purchasing')->check()) {
            Auth::guard('purchasing')->logout();
        }elseif (Auth::guard('manager')->check()) {
            Auth::guard('manager')->logout();
        }
        
        return redirect('/');
    }
}
