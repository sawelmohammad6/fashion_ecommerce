<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('transaction_id', 100)->nullable()->after('payment_status');
            $table->string('coupon_code', 50)->nullable()->after('discount');
            $table->decimal('tax', 10, 2)->default(0)->after('shipping_charge');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['transaction_id', 'coupon_code', 'tax']);
        });
    }
};
