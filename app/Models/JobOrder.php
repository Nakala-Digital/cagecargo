<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    protected $table = 'job_orders';

    protected $fillable = [
        'nomor_jo', 'customer_id', 'consignee_id', 'shipper_id', 'notify_party_id',
        'jenis_barang', 'berat', 'volume', 'jumlah_container',
        'asal', 'tujuan', 'pelabuhan_asal', 'pelabuhan_tujuan',
        'negara_asal', 'negara_tujuan', 'eta', 'etd', 'incoterms',
        'hs_code', 'armada_id', 'driver_id', 'shipping_line_id',
        'ppjk_id', 'vessel', 'voyage', 'status', 'catatan', 'created_by'
    ];

    protected $casts = [
        'eta' => 'date',
        'etd' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function consignee()
    {
        return $this->belongsTo(Customer::class, 'consignee_id');
    }

    public function shipper()
    {
        return $this->belongsTo(Customer::class, 'shipper_id');
    }

    public function notifyParty()
    {
        return $this->belongsTo(Customer::class, 'notify_party_id');
    }

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function shippingLine()
    {
        return $this->belongsTo(ShippingLine::class);
    }

    public function ppjk()
    {
        return $this->belongsTo(PPJK::class);
    }

    public function jobOrderContainers()
    {
        return $this->hasMany(JobOrderContainer::class);
    }

    public function containers()
    {
        return $this->belongsToMany(Container::class, 'job_order_containers');
    }

    public function customs()
    {
        return $this->hasOne(Customs::class);
    }

    public function gpsTracking()
    {
        return $this->hasMany(GpsTracking::class);
    }

    public function rfidEvents()
    {
        return $this->hasMany(RfidEvent::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
