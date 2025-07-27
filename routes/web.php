<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JenisGajiController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PerhitunganController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dash', function () {
    return view('layouts.aps');
});

Route::get('/gate', function () {
    return view('gate');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//admin
Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
    Route::get('/admin/gate', [HomeController::class, 'gate'])->name('gate');
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::resource('/admin/jabatan', JabatanController::class);
    Route::resource('/admin/karyawan', KaryawanController::class);
    Route::resource('/admin/absensi', AbsensiController::class);
    Route::resource('/admin/jenisgaji', JenisGajiController::class);
    Route::resource('/admin/gaji', GajiController::class);
    Route::get('/admin/gaji/slipgaji/{gaji}', [GajiController::class, 'slipGaji'])->name('admin.gaji.slipgaji');

    //spk
    Route::get('/spk/home', [HomeController::class, 'spk'])->name('spk.home');
    Route::resource('/spk/alternatif', AlternatifController::class);
    Route::resource('/spk/kriteria', KriteriaController::class)->parameters([
        'kriteria' => 'kriteria'
    ]);
    Route::resource('/spk/perhitungan', PerhitunganController::class)->except(['show']);
    Route::get('/spk/perhitungan/{id}/nilai', [PerhitunganController::class, 'formNilai'])->name('perhitungan.nilai');
    Route::post('/spk/perhitungan/{id}/nilai', [PerhitunganController::class, 'simpanNilai'])->name('perhitungan.nilai.store');
    Route::get('/spk/perhitungan/hasil', [PerhitunganController::class, 'hasil'])->name('perhitungan.hasil');
    Route::get('/spk/perhitungan/keputusan', [PerhitunganController::class, 'keputusan'])->name('perhitungan.keputusan');
    Route::get('/keputusan-pdf', [PerhitunganController::class, 'exportPDF'])->name('perhitungan.keputusan.export.pdf');
});

