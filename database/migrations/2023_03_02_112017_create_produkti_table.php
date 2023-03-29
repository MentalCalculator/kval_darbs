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
        Schema::create('produkti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userid')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('pirkumsid')->references('id')->on('pirkumi')->onDelete('cascade');
            $table->string('nosaukums');
            $table->decimal('cena');
            $table->decimal('sveramais')->nullable();
            $table->string('sveramaistype');
            $table->decimal('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produkti');
    }
};
