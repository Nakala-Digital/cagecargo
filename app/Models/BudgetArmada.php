<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetArmada extends Model
{
    protected $table = 'budget_armada';

    protected $fillable = [
        'armada_id', 'bulan',
        'alokasi_solar', 'realisasi_solar',
        'alokasi_sparepart', 'realisasi_sparepart',
        'alokasi_tol_parkir', 'realisasi_tol_parkir',
        'alokasi_lainnya', 'realisasi_lainnya',
        'catatan',
    ];

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }

    public function getSisaSolarAttribute()
    {
        return $this->alokasi_solar - $this->realisasi_solar;
    }

    public function getSisaSparepartAttribute()
    {
        return $this->alokasi_sparepart - $this->realisasi_sparepart;
    }

    public function getTotalAlokasiAttribute()
    {
        return $this->alokasi_solar + $this->alokasi_sparepart + $this->alokasi_tol_parkir + $this->alokasi_lainnya;
    }

    public function getTotalRealisasiAttribute()
    {
        return $this->realisasi_solar + $this->realisasi_sparepart + $this->realisasi_tol_parkir + $this->realisasi_lainnya;
    }
}
