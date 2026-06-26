<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpsTracking extends Model
{
    protected $table = 'gps_tracking';

    protected $fillable = [
        'job_order_id', 'armada_id', 'latitude', 'longitude',
        'speed', 'heading', 'status', 'lokasi', 'waktu'
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }
}
