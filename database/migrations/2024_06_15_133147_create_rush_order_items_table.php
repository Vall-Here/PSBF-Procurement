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
        Schema::create('rush_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rush_orders_id');
            $table->string('nama_barang');
            $table->string('satuan');
            $table->integer('rencana_pakai');
            $table->integer('rencana_beli');
            $table->string('mata_uang');
            $table->decimal('harga_satuan', 15, 2);
            $table->text('keterangan')->nullable();
            $table->enum('methode', ['Pembelian Langsung', 'Public Tender', 'Penunjukan langsung'])->nullable();
            $table->enum('state', ['Local', 'Impor', 'Internal'])->nullable();
            $table->enum('inPO', ['yes', 'no'])->nullable();
            $table->timestamps();

            $table->foreign('rush_orders_id')->references('id')->on('rush_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rush_order_items');
    }
};
