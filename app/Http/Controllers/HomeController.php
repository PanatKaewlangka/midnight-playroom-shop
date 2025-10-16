<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // *** FIX: ลบบรรทัดนี้ออก หรือคอมเมนต์ไว้ เพื่อให้ Guest สามารถเข้าถึงได้ ***
        // $this->middleware('auth'); 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Logic การตรวจสอบสิทธิ์ที่เหลืออยู่จะถูกใช้เพื่อแสดงเนื้อหาที่แตกต่างกัน
        if (Auth::check()) {
            if (Auth::user()->is_admin) {
                // Admin ควรถูก Redirect ไปที่ Admin Dashboard
                return redirect()->route('admin.dashboard');
            }
            // Member ล็อกอินแล้ว แสดง Member Dashboard
            return view('home'); 
        }

        // Guest ไม่ได้ล็อกอิน แสดง Public Landing Page (ใช้ View เดียวกัน)
        return view('home'); 
    }
}
