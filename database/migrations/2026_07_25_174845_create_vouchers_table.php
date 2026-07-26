<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();

            // percent = persen, fixed = nominal
            $table->enum('type', ['percent', 'fixed']);

            // Contoh:
            // percent = 50 berarti diskon 50%
            // fixed = 50000 berarti potongan Rp50.000
            $table->decimal('value', 12, 2);

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Jumlah maksimal voucher yang bisa digunakan
            $table->unsignedInteger('quota')->nullable();

            // Jumlah voucher yang sudah digunakan
            $table->unsignedInteger('used')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};