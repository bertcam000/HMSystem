<?php

use App\Models\Booking;
use App\Models\User;
use App\Models\FolioCharge;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amenity_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Booking::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(FolioCharge::class)->nullable()->constrained()->nullOnDelete();

            $table->string('item_name');
            $table->string('category')->default('amenity'); 
            // amenity, consumable, service, other

            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);

            $table->boolean('is_chargeable')->default(true);

            $table->string('status')->default('pending');
            // pending, approved, fulfilled, rejected, cancelled

            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('fulfilled_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('fulfilled_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amenity_requests');
    }
};