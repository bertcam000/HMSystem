<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amenity_items', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('category')->default('amenity');
            // amenity, consumable, service, other

            $table->decimal('unit_price', 12, 2)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->integer('minimum_stock')->default(5);

            $table->boolean('is_chargeable')->default(true);
            $table->boolean('is_active')->default(true);

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amenity_items');
    }
};