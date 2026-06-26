<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenArmada extends Model
{
    protected $table = 'dokumen_armada';

    protected $fillable = [
        'armada_id', 'jenis_dokumen', 'nomor_dokumen',
        'tanggal_terbit', 'tanggal_expired', 'file', 'keterangan'
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_expired' => 'date',
    ];

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }
}
