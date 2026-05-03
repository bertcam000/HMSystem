<?php

use App\Models\AmenityItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('amenity_requests', function (Blueprint $table) {
            $table->foreignIdFor(AmenityItem::class)
                ->nullable()
                ->after('booking_id')
                ->constrained()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('amenity_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('amenity_item_id');
        });
    }
};