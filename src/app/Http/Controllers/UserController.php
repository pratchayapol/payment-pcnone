<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function payments()
    {
        $user = Auth::user();

        // ดึง payment ล่าสุดของ user (ถ้ามี)
        $payment = \App\Models\Payment::where('user_id', $user->id)
            ->orderBy('due_date', 'desc')
            ->first();

        return view('user.payments', compact('user', 'payment'));
    }
    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->withErrors([
                'error' => 'กรุณาเข้าสู่ระบบก่อนเข้าหน้า Profile'
            ]);
        }

        return view('user.profile', compact('user'));
    }


    public function uploadSlip(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'slip' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('slip')->store('slips', 'public');

        // อัปเดต slip ลง DB
        $payment = Payment::find($request->payment_id);
        $payment->update([
            'slip_file' => $path,
            'status' => 1, // อัปโหลดแล้ว → รอตรวจสอบ
        ]);

        return back()->with('success', 'อัปโหลดสลิปเรียบร้อยแล้ว');
    }

    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->withErrors([
                'error' => 'กรุณาเข้าสู่ระบบก่อนเข้าหน้า User'
            ]);
        }

        $now = Carbon::now()->startOfMonth();
        $start = $now->copy()->subMonths(3);
        $end = $now->copy()->addMonths(12);

        $payments = Payment::where('user_id', $user->id)
            ->whereBetween('due_date', [$start, $end])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('user.index', compact('payments'));
    }
}
