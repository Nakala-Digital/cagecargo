<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOrderContainer extends Model
{
    protected $fillable = [
        'job_order_id', 'container_id', 'seal_number', 'berat_muat',
        'waktu_pickup', 'lokasi_pickup', 'kondisi_container',
        'waktu_loading', 'waktu_gate_in', 'waktu_gate_out',
        'waktu_delivery', 'foto_container', 'catatan'
    ];

    protected $casts = [
        'waktu_pickup' => 'datetime',
        'waktu_loading' => 'datetime',
        'waktu_gate_in' => 'datetime',
        'waktu_gate_out' => 'datetime',
        'waktu_delivery' => 'datetime',
    ];

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
