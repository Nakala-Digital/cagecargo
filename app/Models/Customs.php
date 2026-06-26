<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customs extends Model
{
    protected $table = 'customs';

    protected $fillable = [
        'job_order_id', 'jenis', 'nomor_pib_peb', 'tanggal_pengajuan',
        'jalur', 'status', 'tanggal_release', 'bea_masuk', 'pajak',
        'denda', 'nomor_bill_of_lading', 'nomor_manifest', 'nomor_invoice',
        'nomor_packing_list', 'nomor_certificate_of_origin',
        'nomor_shipping_instruction', 'nomor_npe', 'catatan', 'ppjk_id'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_release' => 'date',
    ];

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function ppjk()
    {
        return $this->belongsTo(PPJK::class);
    }
}
