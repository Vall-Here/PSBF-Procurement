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
        Schema::create('rush_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_anggaran');
            $table->decimal('jumlah_anggaran', 15, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->json('review_status')->default(json_encode(['gudang' => 'pending', 'financial' => 'pending', 'procurement' => 'pending']));
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('rush_orders');
    }
    
};
