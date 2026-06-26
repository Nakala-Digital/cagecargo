<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $table = 'costs';

    protected $fillable = [
        'job_order_id', 'vendor_id', 'tipe', 'deskripsi',
        'jumlah', 'tanggal', 'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
