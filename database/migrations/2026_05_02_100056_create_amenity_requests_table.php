<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amenity_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->cascadeOnDelete();

            $table->foreignId('guest_id')
                ->nullable()
                ->constrained('guests')
                ->nullOnDelete();

            $table->string('item_name');
            $table->string('category')->default('amenity');
            // amenity, consumable, service, other

            $table->unsignedInteger('quantity')->default(1);

            $table->boolean('is_chargeable')->default(false);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);

            $table->text('notes')->nullable();

            $table->string('status')->default('pending');
            // pending, approved, rejected, delivered, completed, cancelled

            $table->foreignId('requested_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->foreignId('rejected_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->foreignId('delivered_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amenity_requests');
    }
};