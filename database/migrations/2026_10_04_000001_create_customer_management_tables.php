<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // These guards also support local databases that already have the tables
        // from migrations which were not included in the cloned repository.
        if (! Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('name')->index();
                $table->string('email')->unique();
                $table->string('phone', 50)->index();
                $table->text('address')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('purchase_histories')) {
            Schema::create('purchase_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
                $table->text('description');
                $table->decimal('amount', 12, 2)->default(0);
                $table->date('purchase_date');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Keep customer data intact on rollback because these tables may have
        // been created by an earlier, locally applied migration.
    }
};
