<?php

use App\Models\SmsBundle;
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
            $table->string('currency_code')->default('UGX');
            $table->decimal('amount', 19, 4);
            $table->string('number_of_sms');
            $table->string('sms_unit_price');
            $table->string('transaction_reference');
            $table->string('external_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('phone_number')->nullable();
            $table->string('transaction_fee')->nullable();
            $table->string('status')->default(SmsBundle::STATUS_PENDING);
            $table->string('payment_type')->nullable();

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
