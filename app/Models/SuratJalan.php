<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    protected $table = 'surat_jalan';

    protected $fillable = [
        'nomor_surat_jalan', 'job_order_id', 'armada_id', 'driver_id',
        'tujuan', 'rute', 'tanggal_berangkat', 'tanggal_perkiraan_kembali',
        'tanggal_kembali', 'jenis_muatan', 'berat_muatan', 'biaya_angkut',
        'status', 'catatan', 'created_by'
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_perkiraan_kembali' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
