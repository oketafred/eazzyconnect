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
        Schema::table('sms_bundles', function (Blueprint $table) {
            $table->text('failure_reason')
                ->nullable()
                ->after('payment_type');
            $table->dateTime('checked_at')
                ->nullable()
                ->after('payment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sms_bundles', function (Blueprint $table) {
            $table->dropColumn('failure_reason');
            $table->dropColumn('checked_at');
        });
    }
};
