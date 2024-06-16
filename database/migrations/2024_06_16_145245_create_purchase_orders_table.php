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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->enum('source', ['purchase_request', 'rush_order']);
            $table->enum('methode', ['Pembelian Langsung', 'Public Tender', 'Penunjukan langsung']);
            $table->enum('state', ['Local', 'Impor', 'Internal']);
            $table->date('order_date');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->timestamps();
        
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
