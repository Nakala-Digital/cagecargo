<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    protected $fillable = [
        'nomor_container', 'size', 'type', 'shipping_line_id',
        'seal_number', 'status', 'lokasi', 'max_weight', 'tare_weight'
    ];

    public function shippingLine()
    {
        return $this->belongsTo(ShippingLine::class);
    }

    public function jobOrderContainers()
    {
        return $this->hasMany(JobOrderContainer::class);
    }
}
