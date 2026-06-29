<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uang_jalan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_uang_jalan')->unique();
            $table->foreignId('surat_jalan_id')->constrained('surat_jalan')->cascadeOnDelete();
            $table->foreignId('armada_id')->constrained('armada');
            $table->foreignId('driver_id')->nullable()->constrained('drivers');
            $table->date('tanggal');
            $table->decimal('solar', 15, 2)->default(0);
            $table->decimal('tol', 15, 2)->default(0);
            $table->decimal('parkir', 15, 2)->default(0);
            $table->decimal('makan_driver', 15, 2)->default(0);
            $table->decimal('preman', 15, 2)->default(0);
            $table->decimal('komisi_driver', 15, 2)->default(0);
            $table->decimal('lainnya', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->string('status')->default('draft');
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->date('tanggal_dicairkan')->nullable();
            $table->timestamps();
        });

        Schema::create('maintenance_armada', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armada_id')->constrained('armada')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('jenis');
            $table->string('deskripsi')->nullable();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors');
            $table->decimal('biaya_part', 15, 2)->default(0);
            $table->decimal('biaya_jasa', 15, 2)->default(0);
            $table->decimal('total_biaya', 15, 2)->default(0);
            $table->string('nomor_nota')->nullable();
            $table->integer('km_tempuh')->nullable();
            $table->date('jadwal_berikutnya')->nullable();
            $table->string('status')->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('closing_bulanan', function (Blueprint $table) {
            $table->id();
            $table->string('bulan', 7);
            $table->date('tanggal_closing');
            $table->decimal('total_revenue', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->decimal('total_profit', 15, 2)->default(0);
            $table->decimal('total_ar', 15, 2)->default(0);
            $table->decimal('total_ap', 15, 2)->default(0);
            $table->decimal('cash_in', 15, 2)->default(0);
            $table->decimal('cash_out', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->foreignId('closed_by')->constrained('users');
            $table->unique('bulan');
            $table->timestamps();
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->string('jenis_item')->default('regular');
        });

        Schema::table('pengeluaran_armada', function (Blueprint $table) {
            $table->foreignId('uang_jalan_id')->nullable()->constrained('uang_jalan')->nullOnDelete();
            $table->boolean('is_komisi_driver')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('pengeluaran_armada', function (Blueprint $table) {
            $table->dropForeign(['uang_jalan_id']);
            $table->dropColumn(['uang_jalan_id', 'is_komisi_driver']);
        });
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn('jenis_item');
        });
        Schema::dropIfExists('closing_bulanan');
        Schema::dropIfExists('maintenance_armada');
        Schema::dropIfExists('uang_jalan');
    }
};
