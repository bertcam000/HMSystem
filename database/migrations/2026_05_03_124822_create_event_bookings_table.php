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
        Schema::create('event_bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_venue_id')
                ->constrained('event_venues')
                ->cascadeOnDelete();

            $table->string('booking_code')->unique();

            $table->string('client_name');
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();

            $table->string('event_title');
            $table->string('event_type')->nullable();

            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');

            $table->integer('guest_count')->default(1);

            $table->decimal('venue_amount', 10, 2)->default(0);
            $table->decimal('additional_charges', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);

            $table->enum('status', [
                'pending',
                'confirmed',
                'ongoing',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->enum('payment_status', [
                'unpaid',
                'partial',
                'paid'
            ])->default('unpaid');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_bookings');
    }
};
