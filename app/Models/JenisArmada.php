<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisArmada extends Model
{
    protected $table = 'jenis_armada';

    protected $fillable = [
        'nama', 'tipe_kendaraan', 'harga_sewa', 'satuan', 'keterangan', 'status'
    ];

    public function armada()
    {
        return $this->hasMany(Armada::class);
    }
}
