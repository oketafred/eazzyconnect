<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sms_bundles', function (Blueprint $table) {
            $table->decimal('transaction_percent')
                ->unsigned()
                ->after('transaction_fee');
            $table->decimal('additional_fee')
                ->unsigned()
                ->after('transaction_fee');
            $table->decimal('additional_percent')
                ->unsigned()
                ->after('transaction_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sms_bundles', function (Blueprint $table) {
            $table->dropColumn('transaction_percent');
            $table->dropColumn('additional_fee');
            $table->dropColumn('additional_percent');
        });
    }
};
