<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->decimal('price', 12, 2);

            $table->date('start_date');

            $table->date('end_date')->nullable();

            $table->unsignedInteger('quota')->nullable();

            $table->unsignedInteger('sold')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_prices');
    }
};