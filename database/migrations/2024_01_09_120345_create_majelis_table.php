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
        Schema::create('majelis', function (Blueprint $table) {
            $table->id('id_majelis');
            $table->string('name');
            $table->string('code');
            $table->enum('type', ['Majelis','Lembaga']);
            $table->longText('description')->nullable();
            $table->enum('isActive', ['Yes', 'No'])->default('Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majelis');
    }
};
