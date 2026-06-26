<?php

namespace App\Http\Controllers;

use App\Models\Customs;
use App\Models\GpsTracking;
use App\Models\Invoice;
use App\Models\JobOrder;
use App\Models\RfidEvent;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class DemoIntegrationController extends Controller
{
    public function seedPresentationData()
    {
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\DemoPresentationSeeder']);

        return redirect()->route('dashboard')
            ->with('success', 'Dummy data presentasi berhasil dibuat. Login demo: admin@cargogate.com / password.');
    }

    public function invoiceFromSuratJalan(SuratJalan $suratJalan)
    {
        $suratJalan->loadMissing('jobOrder.customer');

        if (!$suratJalan->biaya_angkut || !$suratJalan->jobOrder?->customer_id) {
            return redirect()->route('operasional.surat-jalan.show', $suratJalan)
                ->with('error', 'Biaya angkut atau customer belum lengkap, invoice dummy belum bisa dibuat.');
        }

        $subtotal = (float) $suratJalan->biaya_angkut;
        $ppn = round($subtotal * 0.11);
        $invoice = Invoice::firstOrCreate(
            ['catatan' => 'Dummy invoice dari Surat Jalan ' . $suratJalan->nomor_surat_jalan],
            [
                'nomor_invoice' => 'INV-' . date('Ymd') . '-' . Str::upper(Str::random(6)),
                'job_order_id' => $suratJalan->job_order_id,
                'customer_id' => $suratJalan->jobOrder->customer_id,
                'tanggal_invoice' => now()->toDateString(),
                'tanggal_jatuh_tempo' => now()->addDays(14)->toDateString(),
                'subtotal' => $subtotal,
                'ppn' => $ppn,
                'total' => $subtotal + $ppn,
                'status' => 'unpaid',
            ]
        );

        $invoice->items()->updateOrCreate(
            ['deskripsi' => 'Biaya angkut berdasarkan ' . $suratJalan->nomor_surat_jalan],
            ['tipe' => 'trucking', 'jumlah' => 1, 'harga_satuan' => $subtotal, 'total' => $subtotal]
        );

        return redirect()->route('finance.show', $invoice)
            ->with('success', 'Dummy invoice dari Surat Jalan berhasil dibuat.');
    }

    public function gpsRfid(JobOrder $jobOrder)
    {
        $jobOrder->load(['armada', 'containers']);

        if (!$jobOrder->gpsTracking()->exists()) {
            $points = [
                ['latitude' => -6.1256, 'longitude' => 106.8650, 'speed' => 0, 'heading' => 'N', 'status' => 'idle', 'lokasi' => 'Depot Tanjung Priok'],
                ['latitude' => -6.1540, 'longitude' => 106.8764, 'speed' => 42, 'heading' => 'SE', 'status' => 'running', 'lokasi' => 'Tol Pelabuhan'],
                ['latitude' => -6.2088, 'longitude' => 106.8456, 'speed' => 36, 'heading' => 'S', 'status' => 'running', 'lokasi' => 'Cawang'],
                ['latitude' => -6.2416, 'longitude' => 106.9924, 'speed' => 0, 'heading' => 'E', 'status' => 'stop', 'lokasi' => $jobOrder->tujuan ?: 'Kawasan Berikat'],
            ];

            foreach ($points as $index => $point) {
                GpsTracking::create($point + [
                    'job_order_id' => $jobOrder->id,
                    'armada_id' => $jobOrder->armada_id,
                    'waktu' => now()->subMinutes((count($points) - $index) * 15),
                ]);
            }
        }

        if (!$jobOrder->rfidEvents()->exists()) {
            $container = $jobOrder->containers->first();
            foreach (['pickup', 'gate_in', 'gate_out', 'delivery'] as $index => $event) {
                RfidEvent::create([
                    'job_order_id' => $jobOrder->id,
                    'armada_id' => $jobOrder->armada_id,
                    'container_id' => $container?->id,
                    'event_type' => $event,
                    'location' => $index < 2 ? 'Tanjung Priok' : ($jobOrder->tujuan ?: 'Customer Site'),
                    'rfid_tag' => $jobOrder->armada?->rfid_tag ?: 'DEMO-RFID-' . str_pad((string) $jobOrder->id, 4, '0', STR_PAD_LEFT),
                    'waktu' => now()->subMinutes((4 - $index) * 12),
                ]);
            }
        }

        if (in_array($jobOrder->status, ['draft', 'assigned', 'pickup'])) {
            $jobOrder->update(['status' => 'on_delivery']);
        }

        return redirect()->route('operasional.job-order.show', $jobOrder)
            ->with('success', 'Dummy GPS/RFID berhasil dibuat untuk demo tracking.');
    }

    public function ceisaInsw(Customs $customs)
    {
        $customs->load('jobOrder');

        $customs->update([
            'nomor_pib_peb' => $customs->nomor_pib_peb ?: strtoupper($customs->jenis) . '-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
            'tanggal_pengajuan' => $customs->tanggal_pengajuan ?: now()->subDay()->toDateString(),
            'jalur' => $customs->jalur ?: collect(['hijau', 'kuning', 'merah'])->random(),
            'status' => 'released',
            'tanggal_release' => now()->toDateString(),
            'bea_masuk' => $customs->bea_masuk ?? 2500000,
            'pajak' => $customs->pajak ?? 1100000,
            'denda' => $customs->denda ?? 0,
            'nomor_manifest' => $customs->nomor_manifest ?: 'MAN-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5)),
            'nomor_bill_of_lading' => $customs->nomor_bill_of_lading ?: 'BL-' . Str::upper(Str::random(8)),
            'nomor_invoice' => $customs->nomor_invoice ?: 'CI-' . Str::upper(Str::random(8)),
            'nomor_packing_list' => $customs->nomor_packing_list ?: 'PL-' . Str::upper(Str::random(8)),
            'nomor_npe' => $customs->jenis === 'ekspor' ? ($customs->nomor_npe ?: 'NPE-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4))) : $customs->nomor_npe,
            'catatan' => trim(($customs->catatan ? $customs->catatan . "\n" : '') . 'Dummy CEISA 5.0 / INSW sync: dokumen valid, jalur ditetapkan, barang release.'),
        ]);

        $customs->jobOrder?->update(['status' => 'sailing']);

        return redirect()->route('operasional.customs.show', $customs)
            ->with('success', 'Dummy CEISA/INSW berhasil mengisi status clearance.');
    }
}
