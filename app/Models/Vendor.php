<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'code', 'nama', 'tipe', 'email', 'phone', 'alamat',
        'npwp', 'pic_name', 'pic_phone', 'status'
    ];

    public function armada()
    {
        return $this->hasMany(Armada::class);
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
}
