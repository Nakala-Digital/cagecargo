<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontrakSubkon extends Model
{
    protected $table = 'kontrak_subkon';

    protected $fillable = [
        'nomor_kontrak', 'vendor_id', 'jenis', 'tanggal_mulai',
        'tanggal_berakhir', 'nilai_kontrak', 'file_kontrak', 'keterangan', 'status'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function armada()
    {
        return $this->hasMany(Armada::class, 'kontrak_id');
    }
}
