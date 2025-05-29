<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Obelaw\Catalog\Enums\ProductScope;
use Obelaw\Catalog\Enums\ProductType;
use Obelaw\Catalog\Enums\StockType;
use Obelaw\Twist\Base\BaseMigration;

return new class extends BaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->prefix . 'catalog_products', function (Blueprint $table) {
            $table->id(); // Typo fixed
            $table->foreignId('category_id')->nullable()->constrained($this->prefix . 'catalog_categories')->cascadeOnDelete();
            $table->integer('product_type')->default(ProductType::SIMPLE);
            $table->integer('product_scope')->default(ProductScope::FINISHED);
            $table->integer('stock_type')->default(StockType::CONSUMABLE);

            $table->string('name');

            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();
            $table->text('description')->nullable();

            // sales
            $table->boolean('sales_can_sold')->nullable();
            $table->decimal('sales_sale_price', 10, 2)->nullable();
            // special_price
            $table->decimal('sales_special_price', 10, 2)->nullable();
            $table->date('sales_special_price_from')->nullable();
            $table->date('sales_special_price_to')->nullable();

            // purchase
            $table->boolean('purchase_can_purchased')->nullable();

            // inventory
            $table->string('inventory_sku')->unique()->index();
            $table->string('inventory_quantity')->nullable();
            $table->string('inventory_safety_stock')->nullable();
            $table->integer('inventory_dimension_length')->nullable();
            $table->integer('inventory_dimension_width')->nullable();
            $table->integer('inventory_dimension_height')->nullable();
            $table->integer('inventory_weight')->nullable();
            $table->integer('inventory_volume')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'catalog_products');
    }
};
