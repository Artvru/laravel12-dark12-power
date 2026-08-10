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
        Schema::create('covid19s', function (Blueprint $table) {
            $table->id();                                    // PK Auto-increment
            $table->date('date')->nullable();               // วันที่
            $table->string('country')->nullable();          // ประเทศ
            $table->integer('cases')->default(0);            // จำนวนผู้ติดเชื้อ
            $table->integer('deaths')->default(0);           // จำนวนผู้เสียชีวิต
            $table->integer('recovered')->default(0);        // จำนวนผู้หายป่วย
            $table->timestamps();                           // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('covid19s');
    }
};