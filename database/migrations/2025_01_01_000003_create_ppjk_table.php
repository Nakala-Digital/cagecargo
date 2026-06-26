<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppjk', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('nama_perusahaan');
            $table->string('nomor_izin')->nullable();
            $table->string('pic')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('alamat')->nullable();
            $table->date('masa_berlaku_izin')->nullable();
            $table->string('jenis_layanan')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppjk');
    }
};
