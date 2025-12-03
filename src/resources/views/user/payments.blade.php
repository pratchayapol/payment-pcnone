@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">วิธีการชำระเงิน</h2>

    <div class="bg-white shadow rounded-lg p-6 space-y-6">
        <!-- PromptPay QR -->
        <div class="text-center">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">ชำระเงินผ่าน PromptPay</h3>
            <p class="text-sm text-gray-600 mb-4">สแกน QR Code เพื่อชำระเงิน</p>
            <img src="{{ asset('images/qr.JPG') }}"
                alt="PromptPay QR"
                class="mx-auto rounded shadow">
            <p class="mt-2 text-gray-700">จำนวนเงิน: <span class="font-bold text-indigo-600">100.00 บาท</span></p>
        </div>

        <!-- โอนผ่านบัญชีธนาคาร -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">โอนผ่านบัญชีธนาคาร</h3>
            <ul class="space-y-2 text-gray-700">
                <li><span class="font-medium">ธนาคาร:</span> MAKE Kbank</li>
                <li><span class="font-medium">ชื่อบัญชี:</span> ปรัชญาพล  จำปาลาด</li>
                <li><span class="font-medium">เลขที่บัญชี:</span> 1991419175</li>
            </ul>
        </div>



        <!-- หมายเหตุ -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-sm text-gray-700">
                ⚠️ กรุณาอัปโหลดสลิปหลังจากชำระเงินเสร็จสิ้น เพื่อให้ระบบตรวจสอบและปรับสถานะการชำระเงินของคุณ
            </p>
        </div>
    </div>
</div>
@endsection