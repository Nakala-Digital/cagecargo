<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_jo')->unique();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('consignee_id')->nullable()->constrained('customers');
            $table->foreignId('shipper_id')->nullable()->constrained('customers');
            $table->foreignId('notify_party_id')->nullable()->constrained('customers');
            $table->string('jenis_barang')->nullable();
            $table->decimal('berat', 12, 2)->nullable();
            $table->decimal('volume', 12, 2)->nullable();
            $table->integer('jumlah_container')->default(0);
            $table->string('asal')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('pelabuhan_asal')->nullable();
            $table->string('pelabuhan_tujuan')->nullable();
            $table->string('negara_asal')->nullable();
            $table->string('negara_tujuan')->nullable();
            $table->date('eta')->nullable();
            $table->date('etd')->nullable();
            $table->string('incoterms')->nullable();
            $table->string('hs_code')->nullable();
            $table->foreignId('armada_id')->nullable()->constrained('armada');
            $table->foreignId('driver_id')->nullable()->constrained('drivers');
            $table->foreignId('shipping_line_id')->nullable()->constrained('shipping_lines');
            $table->foreignId('ppjk_id')->nullable()->constrained('ppjk');
            $table->string('vessel')->nullable();
            $table->string('voyage')->nullable();
            $table->string('status')->default('draft');
            // draft, assigned, pickup, on_delivery, gate_in, customs, sailing, delivered, closed
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_orders');
    }
};
