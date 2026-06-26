<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengeluaranArmada extends Model
{
    protected $table = 'pengeluaran_armada';

    protected $fillable = [
        'armada_id', 'job_order_id', 'driver_id', 'jenis', 'jumlah',
        'tanggal', 'bukti', 'volume_solar', 'vendor_penyedia',
        'lokasi', 'nomor_nota', 'keterangan', 'status', 'approved_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
