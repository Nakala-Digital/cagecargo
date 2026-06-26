<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_invoice')->unique();
            $table->foreignId('job_order_id')->constrained('job_orders')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers');
            $table->date('tanggal_invoice');
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('ppn', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->string('status')->default('unpaid'); // unpaid, paid, partial, overdue
            $table->date('tanggal_pembayaran')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->string('deskripsi');
            $table->string('tipe'); // trucking, container, ppjk_fee, storage, thc, handling, bea_masuk, pajak, vendor_cost, lainnya
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_order_id')->constrained('job_orders')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->string('tipe'); // trucking, container, ppjk_fee, storage, thc, handling, bea_masuk, pajak, vendor_cost, lainnya
            $table->string('deskripsi')->nullable();
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->date('tanggal')->nullable();
            $table->string('status')->default('pending'); // pending, approved, paid
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal_pembayaran');
            $table->string('metode'); // transfer, tunai, cek, kartu_kredit
            $table->string('referensi')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('costs');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
