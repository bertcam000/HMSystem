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
        Schema::table('night_audits', function (Blueprint $table) {
            $table->integer('total_reservations')->default(0)->after('in_house_count');
            $table->integer('total_cancellations')->default(0)->after('total_reservations');

            $table->decimal('total_payments', 12, 2)->default(0)->after('daily_revenue');

            $table->decimal('vatable_sales', 12, 2)->default(0)->after('total_payments');
            $table->decimal('vat_amount', 12, 2)->default(0)->after('vatable_sales');
            $table->decimal('net_sales', 12, 2)->default(0)->after('vat_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('night_audits', function (Blueprint $table) {
            //
        });
    }
};
