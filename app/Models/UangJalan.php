<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UangJalan extends Model
{
    protected $table = 'uang_jalan';

    protected $fillable = [
        'nomor_uang_jalan', 'surat_jalan_id', 'armada_id', 'driver_id',
        'tanggal', 'solar', 'tol', 'parkir', 'makan_driver', 'preman',
        'komisi_driver', 'lainnya', 'total', 'status', 'keterangan',
        'created_by', 'approved_by', 'tanggal_dicairkan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tanggal_dicairkan' => 'date',
    ];

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class);
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

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function pengeluaran()
    {
        return $this->hasMany(PengeluaranArmada::class);
    }
}
