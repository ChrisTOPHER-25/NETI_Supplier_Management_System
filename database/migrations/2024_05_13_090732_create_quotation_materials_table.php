<?php

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
        Schema::create('quotation_materials', function (Blueprint $table) {
            $table->id();
            $table->double('quantity');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('unit');
            $table->longText('description');
            $table->double('unit_price');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('bom_material_categories')->restrictOnDelete();
            $table->unsignedBigInteger('quotation_id');
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_materials');
    }
};
