<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function checkPayments($id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/user');
        }

        $user = User::findOrFail($id);
        $now = Carbon::now()->startOfMonth();
        $start = $now->copy()->subMonths(3);   // ย้อนหลัง 3 เดือนจากปัจจุบัน
        $end   = $now->copy()->addMonths(12);  // ล่วงหน้า 12 เดือนจากปัจจุบัน

        $payments = Payment::where('user_id', $user->id)
            ->whereBetween('due_date', [$start, $end]) // เลือกเฉพาะช่วงเวลาที่กำหนด
            ->orderBy('due_date', 'asc')              // เรียงจากเก่าไปใหม่ (เช่น 2025 → 2026)
            ->get();


        return view('admin.checkpayments', compact('user', 'payments'));
    }

    // เมธอดสำหรับตรวจสอบ slip
    public function verifySlip($paymentId)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/user');
        }

        $payment = Payment::findOrFail($paymentId);
        $payment->status = 2; // เปลี่ยนสถานะเป็น 2 = ตรวจสอบแล้ว
        $payment->save();

        return back()->with('success', 'ตรวจสอบสลิปเรียบร้อยแล้ว');
    }

    public function profile()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/user');
        }

        $admin = auth()->user();
        return view('admin.profile', compact('admin'));
    }
    // Dashboard
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/user');
        }

        // ดึงเฉพาะผู้ใช้ที่ role = user
        $users = User::where('role', 'user')->get();

        // ส่งตัวแปร users ไปยัง view
        return view('admin.index', compact('users'));
    }
    // รายชื่อผู้ใช้
    public function users()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/user');
        }

        $users = User::all();
        return view('admin.users', compact('users'));
    }

    // รายการชำระเงิน
    public function payments()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/user');
        }

        $payments = Payment::with('user')->orderBy('due_date', 'desc')->get();
        return view('admin.payments', compact('payments'));
    }
}
