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
        Schema::create('bom_material_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('bom_departments')->restrictOnDelete();
            $table->string('unit');
            $table->boolean('uses_brand')->default(false);
            $table->timestamps();
        });

        Schema::create('bom_materials', function (Blueprint $table) {
            $table->id();
            $table->double('quantity');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('unit');
            $table->longText('description');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('bom_material_categories')->restrictOnDelete();
            $table->unsignedBigInteger('bom_id'); 
            $table->foreign('bom_id')->references('id')->on('boms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_material_categories');
        Schema::dropIfExists('bom_materials');
    }
};
