<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Obelaw\Catalog\Models\ContactVendor;
use Twist\Base\BaseMigration;

return new class extends BaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->prefix . 'catalog_product_vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained($this->prefix . 'catalog_products')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained((new ContactVendor)->getTable())->cascadeOnDelete(); // The vendor being referenced
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'vendor_id'], 'product_vendor_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'catalog_product_vendors');
    }
};
