<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // Redirect ไปหน้า Google OAuth
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    // Callback หลังจาก Google ยืนยันตัวตน
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            // อัพเดทหรือสร้าง user ใหม่ แต่ไม่เขียนทับ role
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                    'avatar' => $googleUser->getAvatar(),
                ]
            );

            // ถ้า user ใหม่ยังไม่มี role → กำหนด default เป็น user
            if (!$user->role) {
                $user->role = 'user';
                $user->save();
            }

            Auth::login($user);

            // สร้างข้อมูลการชำระค่าบริการทุกเดือนจนถึงปี 2125
            $start = Carbon::now()->startOfMonth();
            $end   = Carbon::create(2125, 12, 1);

            while ($start->lte($end)) {
                Payment::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'due_date' => $start->toDateString(),
                    ],
                    [
                        'amount' => 100,
                        'status' => 0,
                    ]
                );

                $start->addMonth();
            }

            // ✅ ตรวจสอบ role แล้ว redirect ไปตามสิทธิ์
            if ($user->role === 'admin') {
                return redirect('/admin');
            }

            return redirect('/user');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'error' => 'ไม่สามารถเข้าสู่ระบบด้วย Google ได้ กรุณาลองใหม่อีกครั้ง'
            ]);
        }
    }
}
