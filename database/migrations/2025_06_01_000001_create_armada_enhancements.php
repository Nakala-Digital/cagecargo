<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontrak_subkon', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kontrak')->unique();
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->string('jenis'); // armada, driver, keduanya
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->decimal('nilai_kontrak', 15, 2)->nullable();
            $table->string('file_kontrak')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->default('aktif'); // aktif, expired, terminated
            $table->timestamps();
        });

        Schema::create('jenis_armada', function (BluePrint $table) {
            $table->id();
            $table->string('nama'); // tronton, fuso, wingbox, engkel, trailer, dsb
            $table->string('tipe_kendaraan');
            $table->decimal('harga_sewa', 15, 2)->nullable();
            $table->string('satuan')->default('per_kirim'); // per_kirim, per_hari, per_bulan, per_ton
            $table->text('keterangan')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();
        });

        Schema::table('armada', function (Blueprint $table) {
            $table->foreignId('jenis_armada_id')->nullable()->constrained('jenis_armada')->nullOnDelete();
            $table->string('jenis_kepemilikan')->default('milik_sendiri'); // milik_sendiri, subkon_armada, subkon_driver, subkon_keduanya
            $table->foreignId('kontrak_id')->nullable()->constrained('kontrak_subkon')->nullOnDelete();
            $table->decimal('harga_sewa', 15, 2)->nullable();
            $table->date('tanggal_ganti_oli_terakhir')->nullable();
            $table->integer('jarak_tempuh_ganti_oli')->nullable()->comment('dalam km');
            $table->date('tanggal_service_terakhir')->nullable();
            $table->integer('jarak_tempuh_service')->nullable()->comment('dalam km');
            $table->decimal('level_solar', 8, 2)->nullable()->comment('dalam liter');
            $table->date('tanggal_isi_solar_terakhir')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('armada', function (Blueprint $table) {
            $table->dropForeign(['jenis_armada_id']);
            $table->dropForeign(['kontrak_id']);
            $table->dropColumn(['jenis_armada_id', 'jenis_kepemilikan', 'kontrak_id', 'harga_sewa', 'tanggal_ganti_oli_terakhir', 'jarak_tempuh_ganti_oli', 'tanggal_service_terakhir', 'jarak_tempuh_service', 'level_solar', 'tanggal_isi_solar_terakhir']);
        });
        Schema::dropIfExists('jenis_armada');
        Schema::dropIfExists('kontrak_subkon');
    }
};
