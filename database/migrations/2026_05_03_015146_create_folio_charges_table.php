<?php

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('folio_charges', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Booking::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->string('charge_code')->unique();

            $table->string('category'); 
            // room, amenity, consumable, bar, food, damage, service, other

            $table->string('description');

            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('amount', 12, 2)->default(0);

            $table->boolean('is_void')->default(false);
            $table->text('void_reason')->nullable();
            $table->timestamp('voided_at')->nullable();

            $table->foreignId('created_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('voided_by')->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folio_charges');
    }
};