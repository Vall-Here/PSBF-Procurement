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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rkb_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('tahun_anggaran');
            $table->decimal('jumlah_anggaran', 15, 2);
            $table->timestamps();
            $table->enum('status', ['pending', 'approved', 'rejected'])->nullable();
            $table->json('review_status')->default(json_encode(['pengendali_gudang' => 'pending', 'pengendali_finansial' => 'pending', 'pengendali_proc' => 'pending']));
            $table->text('review')->nullable();
            $table->foreign('rkb_id')->references('id_rkb')->on('rkb')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_requests');
    }
};
