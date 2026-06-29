<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PPJKController;
use App\Http\Controllers\ShippingLineController;
use App\Http\Controllers\ArmadaController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\JobOrderController;
use App\Http\Controllers\CustomsController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Controllers\PengeluaranArmadaController;
use App\Http\Controllers\ApArController;
use App\Http\Controllers\MasterArmadaController;
use App\Http\Controllers\DemoIntegrationController;
use App\Http\Controllers\UangJalanController;
use App\Http\Controllers\MaintenanceArmadaController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/demo/seed-presentation-data', [DemoIntegrationController::class, 'seedPresentationData'])->name('demo.seed');

    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('customer', CustomerController::class);
        Route::resource('vendor', VendorController::class);
        Route::resource('ppjk', PPJKController::class);
        Route::resource('shipping-line', ShippingLineController::class);

        Route::resource('armada', ArmadaController::class);
        Route::get('armada/{armada}/pengeluaran', [ArmadaController::class, 'pengeluaran'])->name('armada.pengeluaran');
        Route::post('armada/{armada}/pengeluaran', [ArmadaController::class, 'storePengeluaran'])->name('armada.pengeluaran.store');
        Route::get('armada/{armada}/budget', [ArmadaController::class, 'budget'])->name('armada.budget');
        Route::post('armada/{armada}/budget', [ArmadaController::class, 'storeBudget'])->name('armada.budget.store');
        Route::get('armada/{armada}/izin', [ArmadaController::class, 'izin'])->name('armada.izin');
        Route::post('armada/{armada}/izin', [ArmadaController::class, 'storeIzin'])->name('armada.izin.store');

        Route::get('jenis-armada', [MasterArmadaController::class, 'jenisIndex'])->name('armada.jenis.index');
        Route::post('jenis-armada', [MasterArmadaController::class, 'jenisStore'])->name('armada.jenis.store');
        Route::put('jenis-armada/{jenisArmada}', [MasterArmadaController::class, 'jenisUpdate'])->name('armada.jenis.update');

        Route::get('kontrak-subkon', [MasterArmadaController::class, 'kontrakIndex'])->name('armada.kontrak.index');
        Route::get('kontrak-subkon/create', [MasterArmadaController::class, 'kontrakCreate'])->name('armada.kontrak.create');
        Route::post('kontrak-subkon', [MasterArmadaController::class, 'kontrakStore'])->name('armada.kontrak.store');
        Route::get('kontrak-subkon/{kontrakSubkon}', [MasterArmadaController::class, 'kontrakShow'])->name('armada.kontrak.show');

        Route::resource('driver', DriverController::class);
        Route::resource('container', ContainerController::class);
    });

    Route::prefix('operasional')->name('operasional.')->group(function () {
        Route::resource('job-order', JobOrderController::class)->except(['destroy']);
        Route::patch('job-order/{jobOrder}/status', [JobOrderController::class, 'updateStatus'])->name('job-order.status');
        Route::post('job-order/{jobOrder}/dummy-gps-rfid', [DemoIntegrationController::class, 'gpsRfid'])->name('job-order.dummy-gps-rfid');
        Route::resource('customs', CustomsController::class)
            ->parameters(['customs' => 'customs'])
            ->except(['destroy']);
        Route::post('customs/{customs}/dummy-ceisa-insw', [DemoIntegrationController::class, 'ceisaInsw'])->name('customs.dummy-ceisa-insw');

        Route::get('surat-jalan', [SuratJalanController::class, 'index'])->name('surat-jalan.index');
        Route::get('surat-jalan/create', [SuratJalanController::class, 'create'])->name('surat-jalan.create');
        Route::post('surat-jalan', [SuratJalanController::class, 'store'])->name('surat-jalan.store');
        Route::get('surat-jalan/{suratJalan}', [SuratJalanController::class, 'show'])->name('surat-jalan.show');
        Route::patch('surat-jalan/{suratJalan}/status', [SuratJalanController::class, 'updateStatus'])->name('surat-jalan.status');
        Route::post('surat-jalan/{suratJalan}/dummy-invoice', [DemoIntegrationController::class, 'invoiceFromSuratJalan'])->name('surat-jalan.dummy-invoice');

        Route::get('pengeluaran', [PengeluaranArmadaController::class, 'index'])->name('pengeluaran.index');
        Route::post('pengeluaran/{pengeluaran}/approve', [PengeluaranArmadaController::class, 'approve'])->name('pengeluaran.approve');
        Route::post('pengeluaran/{pengeluaran}/reject', [PengeluaranArmadaController::class, 'reject'])->name('pengeluaran.reject');

        Route::get('uang-jalan', [UangJalanController::class, 'index'])->name('uang-jalan.index');
        Route::get('uang-jalan/create', [UangJalanController::class, 'create'])->name('uang-jalan.create');
        Route::post('uang-jalan', [UangJalanController::class, 'store'])->name('uang-jalan.store');
        Route::get('uang-jalan/{uangJalan}', [UangJalanController::class, 'show'])->name('uang-jalan.show');
        Route::post('uang-jalan/{uangJalan}/approve', [UangJalanController::class, 'approve'])->name('uang-jalan.approve');

        Route::get('maintenance', [MaintenanceArmadaController::class, 'index'])->name('maintenance.index');
        Route::get('maintenance/create', [MaintenanceArmadaController::class, 'create'])->name('maintenance.create');
        Route::post('maintenance', [MaintenanceArmadaController::class, 'store'])->name('maintenance.store');
        Route::get('maintenance/{maintenance}', [MaintenanceArmadaController::class, 'show'])->name('maintenance.show');
    });

    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('invoice/create/{jobOrder?}', [FinanceController::class, 'createInvoice'])->name('invoice.create');
        Route::post('invoice/store', [FinanceController::class, 'storeInvoice'])->name('invoice.store');
        Route::get('invoice/{invoice}', [FinanceController::class, 'showInvoice'])->name('show');
        Route::get('job/{jobOrder}/costs', [FinanceController::class, 'jobCosts'])->name('job.costs');
        Route::post('job/{jobOrder}/costs', [FinanceController::class, 'storeCost'])->name('job.costs.store');
        Route::get('profit', [FinanceController::class, 'profitAnalysis'])->name('profit');
        Route::get('invoice/{invoice}/payment', [FinanceController::class, 'payment'])->name('payment');
        Route::post('invoice/{invoice}/payment', [FinanceController::class, 'storePayment'])->name('payment.store');
        Route::get('export', [FinanceController::class, 'exportData'])->name('export');

        Route::get('ap', [ApArController::class, 'apIndex'])->name('ap.index');
        Route::get('ap/create', [ApArController::class, 'apCreate'])->name('ap.create');
        Route::post('ap', [ApArController::class, 'apStore'])->name('ap.store');
        Route::post('ap/{ap}/pay', [ApArController::class, 'apPay'])->name('ap.pay');

        Route::get('ar', [ApArController::class, 'arIndex'])->name('ar.index');
        Route::get('ar/create', [ApArController::class, 'arCreate'])->name('ar.create');
        Route::post('ar', [ApArController::class, 'arStore'])->name('ar.store');
        Route::post('ar/{ar}/pay', [ApArController::class, 'arPay'])->name('ar.pay');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('aging', [LaporanController::class, 'aging'])->name('aging');
        Route::get('outstanding', [LaporanController::class, 'outstanding'])->name('outstanding');
        Route::get('reminder', [LaporanController::class, 'reminder'])->name('reminder');
        Route::get('laba-rugi', [LaporanController::class, 'labaRugi'])->name('laba-rugi');
        Route::get('neraca', [LaporanController::class, 'neraca'])->name('neraca');
        Route::get('cash-flow', [LaporanController::class, 'cashFlow'])->name('cash-flow');
        Route::get('profit-per-customer', [LaporanController::class, 'profitPerCustomer'])->name('profit-per-customer');
        Route::get('profit-per-armada', [LaporanController::class, 'profitPerArmada'])->name('profit-per-armada');
        Route::get('profit-per-driver', [LaporanController::class, 'profitPerDriver'])->name('profit-per-driver');

        Route::get('closing', [LaporanController::class, 'closingIndex'])->name('closing.index');
        Route::get('closing/create', [LaporanController::class, 'closingCreate'])->name('closing.create');
        Route::post('closing', [LaporanController::class, 'closingStore'])->name('closing.store');
        Route::get('closing/{closing}', [LaporanController::class, 'closingShow'])->name('closing.show');

        Route::get('export-pdf/{type}', [LaporanController::class, 'exportPdf'])->name('export-pdf');
    });
});
