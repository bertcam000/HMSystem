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
        Schema::create('event_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_booking_id')
                ->constrained('event_bookings')
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->enum('type', [
                'downpayment',
                'partial',
                'full_payment',
                'remaining_balance',
                'additional'
            ])->default('partial');

            $table->enum('method', [
                'cash',
                'gcash',
                'bank_transfer',
                'card'
            ])->default('cash');

            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();

            $table->dateTime('paid_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_payments');
    }
};
