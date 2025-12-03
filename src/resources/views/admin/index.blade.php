@extends('layouts.appadmin')

@section('content')
<div class="max-w-5xl mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">ระบบชำระค่าบริการอินเตอร์เน็ต</h2>
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">บัญชีผู้ใช้ทั้งหมด</h2>

    <div class="bg-white shadow rounded-lg p-6">
    <div class="overflow-x-auto"> <!-- เพิ่ม wrapper -->
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">โปรไฟล์</th>
                    <th class="px-4 py-2 border">ชื่อ</th>
                    <!-- <th class="px-4 py-2 border">อีเมล</th>
                    <th class="px-4 py-2 border">สิทธิ์</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr onclick="window.location='{{ route('admin.checkpayments', $user->id) }}'"
                    class="hover:bg-gray-50 cursor-pointer">
                    <td class="px-4 py-2 border text-center">
                        @if($user->avatar)
                        <img src="{{ $user->avatar }}"
                            alt="Profile Picture"
                            class="w-16 h-16 rounded-full shadow-md mx-auto">
                        @else
                        <span class="text-gray-400">ไม่มีรูปโปรไฟล์</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">{{ $user->name }}</td>
                    <!-- <td class="px-4 py-2 border">{{ $user->email }}</td>
                    <td class="px-4 py-2 border">{{ $user->role }}</td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</div>
@endsection