<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gps_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_order_id')->constrained('job_orders')->cascadeOnDelete();
            $table->foreignId('armada_id')->nullable()->constrained('armada');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('speed', 8, 2)->nullable();
            $table->string('heading')->nullable();
            $table->string('status')->default('idle'); // idle, running, stop, delay
            $table->string('lokasi')->nullable();
            $table->timestamp('waktu')->useCurrent();
            $table->timestamps();
        });

        Schema::create('rfid_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_order_id')->nullable()->constrained('job_orders')->nullOnDelete();
            $table->foreignId('armada_id')->nullable()->constrained('armada');
            $table->foreignId('container_id')->nullable()->constrained('containers');
            $table->string('event_type'); // gate_in, gate_out, pickup, delivery
            $table->string('location')->nullable();
            $table->string('rfid_tag')->nullable();
            $table->timestamp('waktu')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfid_events');
        Schema::dropIfExists('gps_tracking');
    }
};
