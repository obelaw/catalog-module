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

            $table->string('inventory_sku')->unique()->index();
            $table->string('inventory_quantity')->nullable();
            $table->string('inventory_safety_stock')->nullable();

            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();
            $table->text('description')->nullable();

            // sold
            $table->boolean('can_sold')->nullable();
            $table->decimal('price_sales', 10, 2)->nullable();

            // purchased
            $table->boolean('can_purchased')->nullable();
            $table->decimal('price_purchase', 10, 2)->nullable();

            // special_price
            $table->decimal('special_price', 10, 2)->nullable();
            $table->date('special_price_from')->nullable();
            $table->date('special_price_to')->nullable();

            // stock
            $table->integer('stock_quantity')->nullable();

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
