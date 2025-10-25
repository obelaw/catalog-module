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
        Schema::create($this->prefix . 'catalog_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained($this->prefix . 'catalog_attributes')->cascadeOnDelete(); // Link to the attribute
            $table->string('value'); // The actual value/label (e.g., "Red", "Small")
            $table->timestamps();

            $table->unique(['attribute_id', 'value']); // Option value must be unique per attribute
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'catalog_attribute_values');
    }
};
