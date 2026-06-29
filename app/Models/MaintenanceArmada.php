<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceArmada extends Model
{
    protected $table = 'maintenance_armada';

    protected $fillable = [
        'armada_id', 'tanggal', 'jenis', 'deskripsi', 'vendor_id',
        'biaya_part', 'biaya_jasa', 'total_biaya', 'nomor_nota',
        'km_tempuh', 'jadwal_berikutnya', 'status', 'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jadwal_berikutnya' => 'date',
    ];

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
