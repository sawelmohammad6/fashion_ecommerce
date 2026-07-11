<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('slug');
            $table->decimal('buying_price', 10, 2)->nullable()->after('discount_price');
            $table->string('discount_type')->nullable()->after('discount_price');
            $table->text('full_description')->nullable()->after('description');
            $table->string('video_url')->nullable()->after('gallery_images');
            $table->json('variations')->nullable()->after('video_url');
            $table->string('sku')->nullable()->after('stock');
            $table->string('barcode')->nullable()->after('sku');
            $table->boolean('pre_order')->default(false)->after('featured');
            $table->string('meta_title')->nullable()->after('status');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'brand', 'buying_price', 'discount_type', 'full_description',
                'video_url', 'variations', 'sku', 'barcode', 'pre_order',
                'meta_title', 'meta_description', 'meta_keywords',
            ]);
        });
    }
};
