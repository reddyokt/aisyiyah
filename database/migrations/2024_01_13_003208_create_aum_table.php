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
        Schema::create('aum', function (Blueprint $table) {
            $table->id('id_aum');
            $table->unsignedBigInteger('ranting_id')->index()->nullable();
            $table->foreign('ranting_id')->references('ranting_id')->on('ranting')->onDelete('restrict');
            $table->unsignedBigInteger('pca_id')->index()->nullable();
            $table->foreign('pca_id')->references('pca_id')->on('pca')->onDelete('restrict');
            $table->unsignedBigInteger('pda_id')->index();
            $table->foreign('pda_id')->references('pda_id')->on('pda')->onDelete('restrict');
            $table->unsignedBigInteger('id_kepemilikan')->index();
            $table->foreign('id_kepemilikan')->references('id_kepemilikan')->on('kepemilikan')->onDelete('restrict');
            $table->unsignedBigInteger('id_bidangusaha')->index();
            $table->foreign('id_bidangusaha')->references('id_bidangusaha')->on('bidangusaha')->onDelete('restrict');
            $table->string('aum_name');
            $table->enum('pengelolaby',['Ranting', 'PCA', 'PDA']);
            $table->longText('address')->nullable();
            $table->enum('isActive',['Yes','No'])->default('Yes');
            $table->integer('created_by')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aum');
    }
};
