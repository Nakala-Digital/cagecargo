<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'documentable_id', 'documentable_type', 'jenis_dokumen',
        'nomor_dokumen', 'file', 'tanggal_terbit', 'tanggal_expired', 'keterangan'
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_expired' => 'date',
    ];

    public function documentable()
    {
        return $this->morphTo();
    }
}
