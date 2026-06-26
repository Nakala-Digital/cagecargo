<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_order_id')->constrained('job_orders')->cascadeOnDelete();
            $table->string('jenis'); // impor, ekspor
            $table->string('nomor_pib_peb')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->string('jalur')->nullable(); // hijau, kuning, merah
            $table->string('status')->default('waiting_clearance');
            // waiting_clearance, under_inspection, released
            $table->date('tanggal_release')->nullable();
            $table->decimal('bea_masuk', 15, 2)->nullable();
            $table->decimal('pajak', 15, 2)->nullable();
            $table->decimal('denda', 15, 2)->nullable();
            $table->string('nomor_bill_of_lading')->nullable();
            $table->string('nomor_manifest')->nullable();
            $table->string('nomor_invoice')->nullable();
            $table->string('nomor_packing_list')->nullable();
            $table->string('nomor_certificate_of_origin')->nullable();
            $table->string('nomor_shipping_instruction')->nullable();
            $table->string('nomor_npe')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('ppjk_id')->nullable()->constrained('ppjk');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customs');
    }
};
