<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClosingBulanan extends Model
{
    protected $table = 'closing_bulanan';

    protected $fillable = [
        'bulan', 'tanggal_closing', 'total_revenue', 'total_cost',
        'total_profit', 'total_ar', 'total_ap', 'cash_in', 'cash_out',
        'catatan', 'closed_by',
    ];

    protected $casts = [
        'tanggal_closing' => 'date',
    ];

    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }
}
