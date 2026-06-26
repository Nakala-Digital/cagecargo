<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_armada', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armada_id')->constrained('armada');
            $table->string('bulan'); // YYYY-MM
            $table->decimal('alokasi_solar', 15, 2)->default(0);
            $table->decimal('realisasi_solar', 15, 2)->default(0);
            $table->decimal('alokasi_sparepart', 15, 2)->default(0);
            $table->decimal('realisasi_sparepart', 15, 2)->default(0);
            $table->decimal('alokasi_tol_parkir', 15, 2)->default(0);
            $table->decimal('realisasi_tol_parkir', 15, 2)->default(0);
            $table->decimal('alokasi_lainnya', 15, 2)->default(0);
            $table->decimal('realisasi_lainnya', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['armada_id', 'bulan']);
        });

        Schema::create('ap_armada', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_ap')->unique();
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->foreignId('job_order_id')->nullable()->constrained('job_orders')->nullOnDelete();
            $table->string('tipe'); // sewa_armada, driver, solar, sparepart, service, perijinan, lainnya
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal');
            $table->date('jatuh_tempo')->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->string('status')->default('unpaid'); // unpaid, paid, overdue
            $table->string('referensi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('ar_armada', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_ar')->unique();
            $table->foreignId('job_order_id')->constrained('job_orders');
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('tipe'); // sewa_angkut, surat_jalan, lainnya
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal');
            $table->date('jatuh_tempo')->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->string('status')->default('unpaid');
            $table->string('referensi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ar_armada');
        Schema::dropIfExists('ap_armada');
        Schema::dropIfExists('budget_armada');
    }
};
