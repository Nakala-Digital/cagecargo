<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'code', 'nama', 'tipe', 'email', 'phone', 'alamat',
        'npwp', 'pic_name', 'pic_phone', 'status'
    ];

    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
