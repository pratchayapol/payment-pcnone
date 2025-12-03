<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('name');
            $table->string('email')->unique();
            $table->string('google_id')->nullable();
            $table->string('role')->default('user'); // ค่า default เป็น user
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps(); // created_at และ updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
