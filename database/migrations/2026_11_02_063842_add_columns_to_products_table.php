<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('category_id')
                    ->after('id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->string('name')->after('category_id');
                $table->string('sku')->unique()->after('name');
                $table->text('description')->nullable()->after('sku');

                $table->decimal('purchase_price', 12, 2)->default(0);
                $table->decimal('selling_price', 12, 2)->default(0);

                $table->integer('quantity')->default(0);
                $table->integer('min_stock_level')->default(5);

                $table->string('unit')->default('pcs');
                $table->boolean('status')->default(true);
            });
        }
    }

    public function down(): void
    {
        // Existing database data should not be removed here.
    }
};