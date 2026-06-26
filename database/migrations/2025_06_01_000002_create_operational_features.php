<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perijinan', function (Blueprint $table) {
            $table->id();
            $table->morphs('perijinanable'); // armada, vendor, or perusahaan
            $table->string('jenis_perijinan'); // kepabeanan, kawasan_berikat, pelabuhan, izin_trayek, izin_operasional, lainnya
            $table->string('nomor_izin')->nullable();
            $table->string('penerbit')->nullable(); // instansi penerbit
            $table->date('tanggal_terbit')->nullable();
            $table->date('masa_berlaku');
            $table->date('tanggal_perpanjangan')->nullable();
            $table->decimal('biaya_perpanjangan', 15, 2)->nullable();
            $table->string('sticker_number')->nullable();
            $table->string('file_izin')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->default('aktif'); // aktif, expired, diperpanjang
            $table->timestamps();
        });

        Schema::create('surat_jalan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat_jalan')->unique();
            $table->foreignId('job_order_id')->constrained('job_orders');
            $table->foreignId('armada_id')->constrained('armada');
            $table->foreignId('driver_id')->nullable()->constrained('drivers');
            $table->string('tujuan');
            $table->text('rute')->nullable();
            $table->date('tanggal_berangkat');
            $table->date('tanggal_perkiraan_kembali')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->string('jenis_muatan')->nullable();
            $table->decimal('berat_muatan', 12, 2)->nullable();
            $table->decimal('biaya_angkut', 15, 2)->nullable();
            $table->string('status')->default('diterbitkan'); // diterbitkan, dalam_perjalanan, selesai, bermasalah
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('pengeluaran_armada', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armada_id')->constrained('armada');
            $table->foreignId('job_order_id')->nullable()->constrained('job_orders')->nullOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->string('jenis'); // solar, sparepart, tol, parkir, preman, makan_driver, service, ban, pajak, asuransi, lainnya
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal');
            $table->string('bukti')->nullable();
            $table->decimal('volume_solar', 10, 2)->nullable()->comment('liter jika jenis solar');
            $table->string('vendor_penyedia')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('nomor_nota')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_armada');
        Schema::dropIfExists('surat_jalan');
        Schema::dropIfExists('perijinan');
    }
};
