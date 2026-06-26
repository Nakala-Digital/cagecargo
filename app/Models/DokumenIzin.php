<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenIzin extends Model
{
    protected $table = 'perijinan';

    protected $fillable = [
        'perijinanable_id', 'perijinanable_type', 'jenis_perijinan',
        'nomor_izin', 'penerbit', 'tanggal_terbit', 'masa_berlaku',
        'tanggal_perpanjangan', 'biaya_perpanjangan', 'sticker_number',
        'file_izin', 'keterangan', 'status'
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'masa_berlaku' => 'date',
        'tanggal_perpanjangan' => 'date',
    ];

    public function perijinanable()
    {
        return $this->morphTo();
    }
}
