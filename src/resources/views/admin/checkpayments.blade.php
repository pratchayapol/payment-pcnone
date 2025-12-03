@extends('layouts.appadmin')

@section('content')
<div class="max-w-6xl mx-auto mt-8">
    @if($user->avatar)
    <img src="{{ $user->avatar }}"
        alt="Profile Picture"
        class="w-24 h-24 rounded-full shadow-md mx-auto">
    @else
    <span class="text-gray-400">ไม่มีรูปโปรไฟล์</span>
    @endif
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">
        ตรวจสอบยอดโอนของ {{ $user->name }}
    </h2>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">เดือน/ปี</th>
                    <th class="px-4 py-2 border">จำนวนเงิน</th>
                    <th class="px-4 py-2 border">สถานะ</th>
                    <th class="px-4 py-2 border">สลิป</th>
                    <th class="px-4 py-2 border">การตรวจสอบ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">
                        {{ \Carbon\Carbon::parse($payment->due_date)->locale('th')->translatedFormat('F Y') }}
                    </td>
                    <td class="px-4 py-2 border">{{ number_format($payment->amount, 2) }}</td>
                    <td class="px-4 py-2 border">
                        @if($payment->status == 0)
                        <span class="text-red-600 font-bold">ยังไม่ชำระ</span>
                        @elseif($payment->status == 1)
                        <span class="text-green-600 font-bold">ชำระแล้ว</span>
                        @elseif($payment->status == 2)
                        <span class="text-blue-600 font-bold">ตรวจสอบแล้ว</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">
                        @if($payment->slip_file)
                        <div class="flex justify-center">
                            <img src="{{ asset('storage/'.$payment->slip_file) }}"
                                alt="Slip"
                                class="w-32 h-auto rounded shadow">
                        </div>
                        @else
                        <span class="text-gray-500">ไม่มีสลิป</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border text-center">
                        @if($payment->status == 1)
                        <form action="{{ route('admin.verifyslip', $payment->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                                ตรวจสอบแล้ว
                            </button>
                        </form>
                        @elseif($payment->status == 2)
                        <span class="text-blue-600">✔ ตรวจสอบแล้ว</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection