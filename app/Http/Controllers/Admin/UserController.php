<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * แสดงรายชื่อสมาชิกทั้งหมด
     */
    public function index()
    {
        // 2. ดึงข้อมูล User ทั้งหมด
        // $users = User::latest()->get();

        // 3. ส่งไปที่ View ใหม่
        return view('admin.index');
    }
}
