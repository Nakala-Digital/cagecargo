<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_order_containers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_order_id')->constrained('job_orders')->cascadeOnDelete();
            $table->foreignId('container_id')->constrained('containers');
            $table->string('seal_number')->nullable();
            $table->decimal('berat_muat', 12, 2)->nullable();
            $table->timestamp('waktu_pickup')->nullable();
            $table->string('lokasi_pickup')->nullable();
            $table->string('kondisi_container')->nullable();
            $table->timestamp('waktu_loading')->nullable();
            $table->timestamp('waktu_gate_in')->nullable();
            $table->timestamp('waktu_gate_out')->nullable();
            $table->timestamp('waktu_delivery')->nullable();
            $table->string('foto_container')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_order_containers');
    }
};
