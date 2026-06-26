<?php

namespace Database\Seeders;

use App\Models\Armada;
use App\Models\ArArmada;
use App\Models\Container;
use App\Models\Cost;
use App\Models\Customer;
use App\Models\Customs;
use App\Models\DokumenArmada;
use App\Models\DokumenIzin;
use App\Models\Driver;
use App\Models\GpsTracking;
use App\Models\Invoice;
use App\Models\JenisArmada;
use App\Models\JobOrder;
use App\Models\KontrakSubkon;
use App\Models\PPJK;
use App\Models\PengeluaranArmada;
use App\Models\RfidEvent;
use App\Models\ShippingLine;
use App\Models\SuratJalan;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoPresentationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@cargogate.com'],
            ['name' => 'Admin CargoGate', 'password' => Hash::make('password'), 'role' => 'admin', 'phone' => '081234567890']
        );

        $customer = Customer::updateOrCreate(
            ['code' => 'DEMO-CUST'],
            ['nama' => 'PT Demo Kawasan Berikat', 'tipe' => 'customer', 'email' => 'finance@demokb.co.id', 'phone' => '021-7001000', 'alamat' => 'Kawasan Berikat Nusantara, Cakung', 'npwp' => '01.234.567.8-999.000', 'pic_name' => 'Ibu Sinta', 'pic_phone' => '081200000111', 'status' => 'aktif']
        );

        $vendor = Vendor::updateOrCreate(
            ['code' => 'DEMO-VEN'],
            ['nama' => 'PT Demo Subkon Transport', 'tipe' => 'transport', 'email' => 'ops@demosubkon.co.id', 'phone' => '021-7002000', 'status' => 'aktif']
        );

        $ppjk = PPJK::updateOrCreate(
            ['code' => 'DEMO-PPJK'],
            ['nama_perusahaan' => 'PT Demo Prima Kepabeanan', 'nomor_izin' => 'PPJK-DEMO-2026', 'pic' => 'Pak Rafi', 'email' => 'clearance@demoppjk.co.id', 'phone' => '021-7003000', 'alamat' => 'Jl. Pelabuhan Demo No. 8', 'masa_berlaku_izin' => now()->addDays(22)->toDateString(), 'jenis_layanan' => 'Impor, Ekspor, CEISA 5.0', 'status' => 'aktif']
        );

        $shippingLine = ShippingLine::updateOrCreate(
            ['code' => 'DEMO-SL'],
            ['nama' => 'Demo Ocean Line', 'email' => 'booking@demoocean.test', 'phone' => '021-7004000', 'status' => 'aktif']
        );

        $jenis = JenisArmada::updateOrCreate(
            ['nama' => 'Trailer 40FT Demo'],
            ['tipe_kendaraan' => 'Trailer', 'harga_sewa' => 4500000, 'satuan' => 'per_kirim', 'keterangan' => 'Unit demo untuk presentasi', 'status' => 'aktif']
        );

        $kontrak = KontrakSubkon::updateOrCreate(
            ['nomor_kontrak' => 'KTR-DEMO-2026'],
            ['vendor_id' => $vendor->id, 'jenis' => 'keduanya', 'tanggal_mulai' => now()->subMonth()->toDateString(), 'tanggal_berakhir' => now()->addYear()->toDateString(), 'nilai_kontrak' => 250000000, 'keterangan' => 'Dummy kontrak subkon armada dan driver', 'status' => 'aktif']
        );

        $armada = Armada::updateOrCreate(
            ['nomor_polisi' => 'B 9090 DEMO'],
            ['jenis_kendaraan' => 'Trailer', 'merk' => 'Hino', 'tahun' => 2024, 'kapasitas' => 28000, 'vendor_id' => $vendor->id, 'gps_device_id' => 'GPS-DEMO-001', 'rfid_tag' => 'RFID-DEMO-001', 'status' => 'aktif', 'jenis_armada_id' => $jenis->id, 'jenis_kepemilikan' => 'subkon_keduanya', 'kontrak_id' => $kontrak->id, 'harga_sewa' => 4500000, 'tanggal_ganti_oli_terakhir' => now()->subDays(96)->toDateString(), 'jarak_tempuh_ganti_oli' => 9500, 'tanggal_service_terakhir' => now()->subDays(185)->toDateString(), 'jarak_tempuh_service' => 18000, 'level_solar' => 120, 'tanggal_isi_solar_terakhir' => now()->subDay()->toDateString()]
        );

        $driver = Driver::updateOrCreate(
            ['nik' => 'DEMO-DRIVER-001'],
            ['nama' => 'Pak Damar Demo', 'nomor_sim' => 'SIM-DEMO-001', 'masa_berlaku_sim' => now()->addDays(19)->toDateString(), 'nomor_hp' => '081200000222', 'vendor_id' => $vendor->id, 'status' => 'aktif']
        );

        $container = Container::updateOrCreate(
            ['nomor_container' => 'DEMO1234567'],
            ['size' => '40HC', 'type' => 'dry', 'shipping_line_id' => $shippingLine->id, 'seal_number' => 'SEAL-DEMO-01', 'status' => 'dipakai', 'lokasi' => 'Depot Tanjung Priok', 'max_weight' => 30000, 'tare_weight' => 3900]
        );

        $jobOrder = JobOrder::updateOrCreate(
            ['nomor_jo' => 'JO-DEMO-001'],
            ['customer_id' => $customer->id, 'jenis_barang' => 'Sparepart elektronik', 'berat' => 18500, 'volume' => 58, 'jumlah_container' => 1, 'asal' => 'Tanjung Priok', 'tujuan' => 'Kawasan Berikat Cakung', 'pelabuhan_asal' => 'IDTPP - Tanjung Priok', 'pelabuhan_tujuan' => 'IDJKT - Jakarta', 'negara_asal' => 'China', 'negara_tujuan' => 'Indonesia', 'eta' => now()->addDays(2)->toDateString(), 'etd' => now()->subDay()->toDateString(), 'incoterms' => 'CIF', 'hs_code' => '8473.30.90', 'armada_id' => $armada->id, 'driver_id' => $driver->id, 'shipping_line_id' => $shippingLine->id, 'ppjk_id' => $ppjk->id, 'vessel' => 'DEMO VESSEL', 'voyage' => 'DV-026', 'status' => 'on_delivery', 'catatan' => 'Dummy job untuk presentasi alur end-to-end.', 'created_by' => $admin->id]
        );

        $jobOrder->jobOrderContainers()->updateOrCreate(
            ['container_id' => $container->id],
            ['seal_number' => 'SEAL-DEMO-01', 'berat_muat' => 18500, 'waktu_pickup' => now()->subHours(5), 'lokasi_pickup' => 'Depot Tanjung Priok', 'kondisi_container' => 'Baik', 'waktu_loading' => now()->subHours(4), 'waktu_gate_in' => now()->subHours(3)]
        );

        $suratJalan = SuratJalan::updateOrCreate(
            ['nomor_surat_jalan' => 'SJ-DEMO-001'],
            ['job_order_id' => $jobOrder->id, 'armada_id' => $armada->id, 'driver_id' => $driver->id, 'tujuan' => 'Kawasan Berikat Cakung', 'rute' => 'Tanjung Priok - Tol Pelabuhan - Cakung', 'tanggal_berangkat' => now()->toDateString(), 'tanggal_perkiraan_kembali' => now()->addDay()->toDateString(), 'jenis_muatan' => 'Sparepart elektronik', 'berat_muatan' => 18500, 'biaya_angkut' => 5250000, 'status' => 'dalam_perjalanan', 'catatan' => 'Dummy surat jalan demo', 'created_by' => $admin->id]
        );

        ArArmada::updateOrCreate(
            ['referensi' => 'SJ:' . $suratJalan->nomor_surat_jalan],
            ['nomor_ar' => 'AR-DEMO-001', 'job_order_id' => $jobOrder->id, 'customer_id' => $customer->id, 'tipe' => 'surat_jalan', 'jumlah' => $suratJalan->biaya_angkut, 'tanggal' => now()->toDateString(), 'jatuh_tempo' => now()->addDays(14)->toDateString(), 'status' => 'unpaid', 'keterangan' => 'Auto dummy A/R dari surat jalan demo']
        );

        $customs = Customs::updateOrCreate(
            ['job_order_id' => $jobOrder->id],
            ['jenis' => 'impor', 'nomor_pib_peb' => 'PIB-DEMO-20260625', 'tanggal_pengajuan' => now()->subDay()->toDateString(), 'jalur' => 'kuning', 'status' => 'under_inspection', 'nomor_bill_of_lading' => 'BL-DEMO-001', 'nomor_manifest' => 'MAN-DEMO-001', 'nomor_invoice' => 'CI-DEMO-001', 'nomor_packing_list' => 'PL-DEMO-001', 'ppjk_id' => $ppjk->id, 'catatan' => 'Dummy CEISA/INSW belum release, siap diproses tombol sync.']
        );

        Cost::updateOrCreate(
            ['job_order_id' => $jobOrder->id, 'tipe' => 'trucking', 'deskripsi' => 'Solar, tol, parkir, dan operasional demo'],
            ['vendor_id' => $vendor->id, 'jumlah' => 1850000, 'tanggal' => now()->toDateString(), 'status' => 'approved']
        );

        PengeluaranArmada::updateOrCreate(
            ['armada_id' => $armada->id, 'job_order_id' => $jobOrder->id, 'jenis' => 'solar', 'tanggal' => now()->toDateString()],
            ['driver_id' => $driver->id, 'jumlah' => 900000, 'volume_solar' => 90, 'lokasi' => 'SPBU Priok', 'nomor_nota' => 'SOL-DEMO-001', 'keterangan' => 'Dummy solar presentasi', 'status' => 'approved', 'approved_by' => $admin->id]
        );

        DokumenArmada::updateOrCreate(
            ['armada_id' => $armada->id, 'jenis_dokumen' => 'stnk'],
            ['nomor_dokumen' => 'STNK-DEMO-001', 'tanggal_terbit' => now()->subYear()->toDateString(), 'tanggal_expired' => now()->addDays(12)->toDateString(), 'keterangan' => 'Dummy reminder STNK']
        );

        $armada->izin()->updateOrCreate(
            ['jenis_perijinan' => 'pelabuhan'],
            ['nomor_izin' => 'IZIN-PEL-DEMO', 'penerbit' => 'Otoritas Pelabuhan', 'tanggal_terbit' => now()->subMonths(11)->toDateString(), 'masa_berlaku' => now()->addDays(8)->toDateString(), 'biaya_perpanjangan' => 750000, 'sticker_number' => 'STICKER-DEMO-01', 'keterangan' => 'Dummy izin pelabuhan mendekati expired', 'status' => 'aktif']
        );

        foreach ([
            ['Depot Tanjung Priok', -6.1256, 106.8650, 0, 'idle', 90],
            ['Tol Pelabuhan', -6.1540, 106.8764, 38, 'running', 60],
            ['Cawang', -6.2088, 106.8456, 45, 'running', 30],
            ['Kawasan Berikat Cakung', -6.1839, 106.9437, 0, 'stop', 5],
        ] as [$lokasi, $lat, $lng, $speed, $status, $minutes]) {
            GpsTracking::updateOrCreate(
                ['job_order_id' => $jobOrder->id, 'lokasi' => $lokasi],
                ['armada_id' => $armada->id, 'latitude' => $lat, 'longitude' => $lng, 'speed' => $speed, 'heading' => 'E', 'status' => $status, 'waktu' => now()->subMinutes($minutes)]
            );
        }

        foreach (['pickup', 'gate_in', 'gate_out', 'delivery'] as $event) {
            RfidEvent::updateOrCreate(
                ['job_order_id' => $jobOrder->id, 'event_type' => $event],
                ['armada_id' => $armada->id, 'container_id' => $container->id, 'location' => $event === 'delivery' ? 'Kawasan Berikat Cakung' : 'Tanjung Priok', 'rfid_tag' => 'RFID-DEMO-001', 'waktu' => now()->subMinutes(rand(10, 80))]
            );
        }

        $invoice = Invoice::updateOrCreate(
            ['nomor_invoice' => 'INV-DEMO-001'],
            ['job_order_id' => $jobOrder->id, 'customer_id' => $customer->id, 'tanggal_invoice' => now()->toDateString(), 'tanggal_jatuh_tempo' => now()->addDays(14)->toDateString(), 'subtotal' => 5250000, 'ppn' => 577500, 'total' => 5827500, 'status' => 'unpaid', 'catatan' => 'Dummy invoice presentasi dari surat jalan demo']
        );

        $invoice->items()->updateOrCreate(
            ['deskripsi' => 'Biaya angkut berdasarkan SJ-DEMO-001'],
            ['tipe' => 'trucking', 'jumlah' => 1, 'harga_satuan' => 5250000, 'total' => 5250000]
        );
    }
}
