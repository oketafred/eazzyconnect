<?php

use App\Models\User;
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
        Schema::create('sms_bundles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('currency_code');
            $table->decimal('amount', 19, 4);
            $table->string('number_of_sms');
            $table->string('token_voucher');
            $table->string('sms_unit_price');
            $table->string('reference_number');
            $table->string('payment_method');
            $table->string('payment_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_bundles');
    }
};
