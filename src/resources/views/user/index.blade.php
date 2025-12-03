@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">ระบบชำระค่าบริการอินเตอร์เน็ต</h2>
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">รายการชำระเงิน</h2>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">เดือน</th>
                    <th class="px-4 py-2 text-left">จำนวนเงิน</th>
                    <th class="px-4 py-2 text-left">สถานะ</th>
                    <th class="px-4 py-2 text-left">สลิป</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($payment->due_date)->locale('th')->translatedFormat('F Y') }}
                    </td>
                    <td class="px-4 py-2">
                        {{ number_format($payment->amount, 2) }} บาท
                    </td>
                    <td class="px-4 py-2">
                        @if($payment->status == 0)
                        <span class="text-red-600 font-semibold">ยังไม่แนบสลิป</span>
                        @elseif($payment->status == 1)
                        <span class="text-yellow-600 font-semibold">รอตรวจสอบสลิป</span>
                        @else
                        <span class="text-green-600 font-semibold">ตรวจสอบแล้ว</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($payment->slip_file)
                        <div class="flex justify-center">
                            <img src="{{ asset('storage/'.$payment->slip_file) }}"
                                alt="Slip"
                                class="w-32 h-auto rounded shadow">
                        </div>
                        @else
                        @if(isset($qrCode))
                        <div class="flex justify-center">
                            <img src="{{ $qrCode }}" alt="PromptPay QR" class="w-48 h-48">
                        </div>
                        @endif
                        <form action="{{ route('upload.slip') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                            @csrf
                            <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                            <input type="file" name="slip" class="border rounded px-2 py-1 text-sm" required>
                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                อัปโหลด
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection