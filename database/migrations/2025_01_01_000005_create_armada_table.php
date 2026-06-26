<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('armada', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_polisi')->unique();
            $table->string('jenis_kendaraan');
            $table->string('merk')->nullable();
            $table->year('tahun')->nullable();
            $table->string('nomor_mesin')->nullable();
            $table->string('nomor_rangka')->nullable();
            $table->decimal('kapasitas', 12, 2)->nullable();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->string('gps_device_id')->nullable();
            $table->string('rfid_tag')->nullable();
            $table->string('status')->default('aktif'); // aktif, maintenance, nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('armada');
    }
};
