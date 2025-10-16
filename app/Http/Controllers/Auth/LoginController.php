<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * นี่คือการแก้ไขที่ต้นตอของปัญหาทั้งหมด
     * เราจะเปลี่ยนเส้นทางจาก '/home' ไปยัง '/products'
     *
     * @var string
     */
    protected $redirectTo = '/home'; // <--- แก้ไขที่บรรทัดนี้

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

