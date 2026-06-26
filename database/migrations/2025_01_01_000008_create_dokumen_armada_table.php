<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_armada', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armada_id')->constrained('armada')->cascadeOnDelete();
            $table->string('jenis_dokumen'); // stnk, kir, asuransi, buku_uji, izin_operasional, surat_jalan, manifest, lainnya
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->date('tanggal_expired')->nullable();
            $table->string('file')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_armada');
    }
};
