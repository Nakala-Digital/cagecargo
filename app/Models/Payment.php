<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id', 'jumlah', 'tanggal_pembayaran',
        'metode', 'referensi', 'catatan'
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
