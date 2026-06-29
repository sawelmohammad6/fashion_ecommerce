<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->after('user_id');
            $table->string('phone')->after('customer_name');
            $table->string('email')->after('phone');
            $table->string('division')->after('email');
            $table->string('district')->after('division');
            $table->string('upazila')->nullable()->after('district');
            $table->string('postal_code')->nullable()->after('upazila');
            $table->text('address')->after('postal_code');
            $table->string('payment_method')->after('address');
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->decimal('subtotal', 10, 2)->after('payment_status');
            $table->decimal('shipping_charge', 10, 2)->default(0)->after('subtotal');
            $table->decimal('discount', 10, 2)->default(0)->after('shipping_charge');
            $table->decimal('grand_total', 10, 2)->after('discount');
            $table->text('notes')->nullable()->after('grand_total');
            $table->timestamp('ordered_at')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name', 'phone', 'email', 'division', 'district',
                'upazila', 'postal_code', 'address', 'payment_method',
                'payment_status', 'subtotal', 'shipping_charge', 'discount',
                'grand_total', 'notes', 'ordered_at',
            ]);
        });
    }
};
