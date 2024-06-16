<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_request_id');
            $table->string('nama_barang');
            $table->string('satuan');
            $table->integer('rencana_pakai');
            $table->integer('rencana_beli');
            $table->string('mata_uang');
            $table->decimal('harga_satuan', 15, 2);
            $table->text('keterangan')->nullable();
            $table->enum('methode', ['Pembelian Langsung', 'Public Tender', 'Penunjukan langsung'])->nullable();
            $table->enum('state', ['Local', 'Impor', 'Internal'])->nullable();
            $table->enum('inPO', ['yes', 'no'])->default('no');
            $table->timestamps();

            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_request_items');
    }
};
