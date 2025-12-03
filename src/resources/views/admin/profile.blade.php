@extends('layouts.appadmin')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">ข้อมูลผู้ใช้งาน</h2>

    <div class="bg-white shadow rounded-lg p-6 space-y-4">
        <!-- Avatar -->

        <div class="flex items-center space-x-4 items-center justify-center">
            @if($admin->avatar)
            <img src="{{ $admin->avatar }}" alt="Profile Picture" class="w-24 h-24 rounded-full shadow-md">
            @else
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xl font-bold">
                {{ substr($admin->name, 0, 1) }}
            </div>
            @endif


        </div>

        <!-- ข้อมูลทั่วไป -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
            <div>
                <p class="text-lg font-semibold text-gray-800">{{ $admin->name }}</p>
                <p class="text-sm text-gray-500">{{ $admin->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">ชื่อผู้ใช้:</p>
                <p class="text-gray-800">{{ $admin->name }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">อีเมล:</p>
                <p class="text-gray-800">{{ $admin->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">วันที่สมัคร:</p>
                <p class="text-gray-800">{{ $admin->created_at->locale('th')->translatedFormat('d F Y') }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-medium">สถานะ:</p>
                <p class="text-gray-800">
                    @if($admin->status == 0)
                    <span class="text-green-600 font-semibold">Active</span>
                    @else
                    <span class="text-red-600 font-semibold">Inactive</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection