<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingLine extends Model
{
    protected $fillable = [
        'code', 'nama', 'email', 'phone', 'alamat', 'status'
    ];

    public function containers()
    {
        return $this->hasMany(Container::class);
    }

    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class);
    }
}
