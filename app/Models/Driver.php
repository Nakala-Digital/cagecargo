<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'nik', 'nama', 'nomor_sim', 'masa_berlaku_sim', 'nomor_hp',
        'email', 'alamat', 'vendor_id', 'foto', 'status'
    ];

    protected $casts = [
        'masa_berlaku_sim' => 'date',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class);
    }
}
