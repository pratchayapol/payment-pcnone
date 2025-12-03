<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->decimal('amount', 10, 2)->default(100); // budget 100 บาท
        $table->date('due_date');                       // วันที่ครบกำหนด (ทุกวันที่ 1)
        $table->string('slip_file')->nullable();        // ชื่อไฟล์สลิป
        $table->tinyInteger('status')->default(0);      // 0=ยังไม่แนบ,1=รอตรวจสอบ,2=ตรวจสอบแล้ว
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
