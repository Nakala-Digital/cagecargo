<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPJK extends Model
{
    protected $table = 'ppjk';

    protected $fillable = [
        'code', 'nama_perusahaan', 'nomor_izin', 'pic', 'email',
        'phone', 'alamat', 'masa_berlaku_izin', 'jenis_layanan', 'status'
    ];

    protected $casts = [
        'masa_berlaku_izin' => 'date',
    ];

    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class);
    }

    public function customs()
    {
        return $this->hasMany(Customs::class);
    }
}
