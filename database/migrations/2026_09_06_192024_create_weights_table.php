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
        Schema::create('weights', function (Blueprint $table) {
            $table->id();
            
            // เพิ่ม Column สำหรับติดตามน้ำหนัก
            $table->date('date');                   // วันที่บันทึก
            $table->decimal('weight', 5, 2);        // น้ำหนัก (เช่น 65.50 kg)
            $table->text('notes')->nullable();       // หมายเหตุ (ไม่บังคับ)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weights');
    }
};