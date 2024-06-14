<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rkb_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rkb_id');
            $table->string('nama_barang');
            $table->string('satuan');
            $table->integer('rencana_pakai');
            $table->integer('rencana_beli');
            $table->string('mata_uang');
            $table->decimal('harga_satuan', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
    
            $table->foreign('rkb_id')->references('id_rkb')->on('rkb')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rkb_items');
    }
};
