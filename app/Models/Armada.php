<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armada extends Model
{
    protected $table = 'armada';

    protected $fillable = [
        'nomor_polisi', 'jenis_kendaraan', 'merk', 'tahun',
        'nomor_mesin', 'nomor_rangka', 'kapasitas', 'vendor_id',
        'gps_device_id', 'rfid_tag', 'status',
        'jenis_armada_id', 'jenis_kepemilikan', 'kontrak_id', 'harga_sewa',
        'tanggal_ganti_oli_terakhir', 'jarak_tempuh_ganti_oli',
        'tanggal_service_terakhir', 'jarak_tempuh_service',
        'level_solar', 'tanggal_isi_solar_terakhir',
    ];

    protected $casts = [
        'tanggal_ganti_oli_terakhir' => 'date',
        'tanggal_service_terakhir' => 'date',
        'tanggal_isi_solar_terakhir' => 'date',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function jenisArmada()
    {
        return $this->belongsTo(JenisArmada::class);
    }

    public function kontrak()
    {
        return $this->belongsTo(KontrakSubkon::class, 'kontrak_id');
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenArmada::class);
    }

    public function izin()
    {
        return $this->morphMany(DokumenIzin::class, 'perijinanable');
    }

    public function jobOrders()
    {
        return $this->hasMany(JobOrder::class);
    }

    public function gpsTracking()
    {
        return $this->hasMany(GpsTracking::class);
    }

    public function rfidEvents()
    {
        return $this->hasMany(RfidEvent::class);
    }

    public function suratJalan()
    {
        return $this->hasMany(SuratJalan::class);
    }

    public function uangJalan()
    {
        return $this->hasMany(UangJalan::class);
    }

    public function maintenance()
    {
        return $this->hasMany(MaintenanceArmada::class);
    }

    public function pengeluaran()
    {
        return $this->hasMany(PengeluaranArmada::class);
    }

    public function budget()
    {
        return $this->hasMany(BudgetArmada::class);
    }

    public function budgetBulanIni()
    {
        $bulan = now()->format('Y-m');
        return $this->hasOne(BudgetArmada::class)->where('bulan', $bulan);
    }

    public function scopeMilikSendiri($query)
    {
        return $query->where('jenis_kepemilikan', 'milik_sendiri');
    }

    public function scopeSubkon($query)
    {
        return $query->where('jenis_kepemilikan', 'like', 'subkon%');
    }
}
