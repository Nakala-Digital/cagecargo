<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApArmada extends Model
{
    protected $table = 'ap_armada';

    protected $fillable = [
        'nomor_ap', 'vendor_id', 'job_order_id', 'tipe', 'jumlah',
        'tanggal', 'jatuh_tempo', 'tanggal_bayar', 'status', 'referensi', 'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jatuh_tempo' => 'date',
        'tanggal_bayar' => 'date',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class);
    }
}
