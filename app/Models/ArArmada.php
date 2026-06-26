<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArArmada extends Model
{
    protected $table = 'ar_armada';

    protected $fillable = [
        'nomor_ar', 'job_order_id', 'customer_id', 'tipe', 'jumlah',
        'tanggal', 'jatuh_tempo', 'tanggal_bayar', 'status', 'referensi', 'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jatuh_tempo' => 'date',
        'tanggal_bayar' => 'date',
    ];

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
