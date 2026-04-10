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
        Schema::create('night_audits', function (Blueprint $table) {
            $table->id();
            $table->date('audit_date')->unique();

            $table->integer('arrivals_count')->default(0);
            $table->integer('departures_count')->default(0);
            $table->integer('in_house_count')->default(0);

            $table->integer('occupied_rooms')->default(0);
            $table->integer('available_rooms')->default(0);

            $table->decimal('daily_revenue', 12, 2)->default(0);
            $table->decimal('outstanding_balance', 12, 2)->default(0);

            $table->integer('pending_checkins_count')->default(0);
            $table->integer('pending_checkouts_count')->default(0);
            $table->integer('unsettled_accounts_count')->default(0);

            $table->json('summary')->nullable(); // optional detailed snapshot
            $table->timestamp('audited_at')->nullable();
            $table->string('status')->default('completed');

            $table->foreignId('audited_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('night_audits');
    }
};
