<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Twist\Base\BaseMigration;

return new class extends BaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->prefix . 'catalog_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained($this->prefix . 'catalog_products')->cascadeOnDelete();
            $table->foreignId('attribute_id')->constrained($this->prefix . 'catalog_attributes')->cascadeOnDelete(); // The attribute being referenced
            $table->foreignId('attribute_value_id')->constrained($this->prefix . 'catalog_attribute_values')->cascadeOnDelete(); // The specific value for this attribute (NULL if is_configurable=true)
            $table->string('sku')->unique();
            $table->enum('type_price', ['force', 'append'])->nullable();
            $table->decimal('special_price', 10, 2)->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'attribute_id', 'attribute_value_id'], 'product_attribute_value_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'catalog_product_attributes');
    }
};
