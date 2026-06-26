<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfidEvent extends Model
{
    protected $table = 'rfid_events';

    protected $fillable = [
        'job_order_id', 'armada_id', 'container_id',
        'event_type', 'location', 'rfid_tag', 'waktu'
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

    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
