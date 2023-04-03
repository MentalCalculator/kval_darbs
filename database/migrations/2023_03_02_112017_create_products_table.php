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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userid')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('purchaseid')->references('id')->on('purchases')->onDelete('cascade');
            $table->string('productname',20);
            $table->decimal('productprice');
            $table->decimal('productamount')->nullable();
            $table->string('producttype');
            $table->decimal('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
