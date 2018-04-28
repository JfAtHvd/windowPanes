<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

//  https://laravel.com/docs/5.6/requests
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //  Source:
    //  https://stackoverflow.com/questions/39327970/how-to-set-laravel-5-3-logout-redirect-path
    use AuthenticatesUsers{
		logout as performLogout;
	}

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    //  Source:
    //  https://stackoverflow.com/questions/39327970/how-to-set-laravel-5-3-logout-redirect-path
    public function logout(Request $request)
	{
		$this->performLogout($request);
		return redirect()->route('home');
	}
    
}
