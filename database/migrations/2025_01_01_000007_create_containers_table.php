<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_container')->unique();
            $table->string('size'); // 20, 40, 40HC, 45
            $table->string('type'); // dry, reefer, open_top, flat_rack, tank
            $table->foreignId('shipping_line_id')->nullable()->constrained('shipping_lines')->nullOnDelete();
            $table->string('seal_number')->nullable();
            $table->string('status')->default('aktif'); // aktif, dipakai, maintenance, rusak
            $table->string('lokasi')->nullable(); // depot, pelabuhan, gudang, on_delivery
            $table->decimal('max_weight', 12, 2)->nullable();
            $table->decimal('tare_weight', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
