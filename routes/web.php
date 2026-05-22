<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HalalCenterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonsultanController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Trainerpelatihancontroller;
use App\Http\Controllers\AbsensiController;

// =====================
// HALAMAN UMUM (Bebas Akses)
// =====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/media', [MediaController::class, 'index'])->name('media');
Route::get('/produk/{id}', [UmkmController::class, 'produkDetail'])->name('produk.show')->middleware('auth');

// Auth System
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/umkm/pilih-mentor/{mentorId}', [\App\Http\Controllers\UmkmDashboardController::class, 'pilihMentor'])->name('umkm.pilih-mentor');
// Pelatihan, UMKM, Halal, Konsultan (Prefix Groups)
Route::prefix('pelatihan')->name('pelatihan.')->group(function () {
    // Bebas akses
    Route::get('/', [PelatihanController::class, 'program'])->name('index');
    Route::get('/program', [PelatihanController::class, 'program'])->name('program');
    Route::get('/event', [PelatihanController::class, 'event'])->name('event');
    Route::get('/mentor', [PelatihanController::class, 'pembimbing'])->name('pembimbing');

    // Wajib login
    Route::middleware('auth')->group(function () {
        Route::get('/program/{id}', [PelatihanController::class, 'detailProgram'])->name('detail');
        Route::get('/event/{id}', [PelatihanController::class, 'detailEvent'])->name('event.detail');
        Route::get('/mentor/{id}', [PelatihanController::class, 'detailMentor'])->name('mentor.detail');
        Route::post('/mentor/{id}/ulasan', [PelatihanController::class, 'simpanUlasan'])->name('mentor.ulasan');
    });
});

Route::prefix('umkm')->group(function () {
    // Bebas akses
    Route::get('/', [UmkmController::class, 'index'])->name('umkm');
    Route::get('/produk', [UmkmController::class, 'produk'])->name('umkm.produk');
    Route::get('/pembimbing', [UmkmController::class, 'pembimbing'])->name('umkm.pembimbing');
    Route::get('/peta-data', [UmkmController::class, 'petaData'])->name('umkm.peta-data');
    Route::get('/peta-data-mentor', [UmkmController::class, 'petaDataMentor'])->name('umkm.peta-data-mentor');

    // Wajib login
    Route::middleware('auth')->group(function () {
        Route::get('/pembimbing/{id}', [UmkmController::class, 'showMentor'])->name('umkm.mentor.detail');
        Route::get('/lokasi', [UmkmController::class, 'lokasi'])->name('umkm.lokasi');
    });
});

Route::prefix('halal-center')->group(function () {
    Route::get('/', [HalalCenterController::class, 'index'])->name('halal-center');
    Route::get('/gratis', [HalalCenterController::class, 'gratis'])->name('halal-center.gratis');
    Route::get('/berbayar', [HalalCenterController::class, 'berbayar'])->name('halal-center.berbayar');
});

Route::prefix('konsultan')->group(function () {
    Route::get('/', [KonsultanController::class, 'index'])->name('konsultan');
    Route::get('/layanan', [KonsultanController::class, 'layanan'])->name('konsultan.layanan');
    Route::get('/paket', [KonsultanController::class, 'paket'])->name('konsultan.paket');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Daftar UMKM
    Route::get('/profile/daftar-umkm', [ProfileController::class, 'showDaftarUmkm'])->name('profile.daftar-umkm');
    Route::post('/profile/simpan-umkm', [ProfileController::class, 'simpanUmkm'])->name('profile.simpan-umkm');

    // Daftar Mentor
    Route::get('/profile/daftar-mentor', [ProfileController::class, 'showDaftarMentor'])->name('profile.daftar-mentor');
    Route::post('/profile/simpan-mentor', [ProfileController::class, 'simpanMentor'])->name('profile.simpan-mentor');

    // Daftar Trainer
    Route::get('/profile/daftar-trainer', [ProfileController::class, 'showDaftarTrainer'])->name('profile.daftar-trainer');
    Route::post('/profile/simpan-trainer', [ProfileController::class, 'simpanTrainer'])->name('profile.simpan-trainer');

    // Dashboard UMKM
    Route::get('/dashboard-umkm', [App\Http\Controllers\UmkmDashboardController::class, 'index'])
         ->name('dashboard-umkm');
    Route::post('/dashboard-umkm/join-program/{id}', [App\Http\Controllers\UmkmDashboardController::class, 'joinProgram'])
         ->name('dashboard.umkm.join-program');

    Route::get('/dashboard-umkm/produk/{id}/edit', [\App\Http\Controllers\UmkmDashboardController::class, 'editProduk'])
         ->name('dashboard.produk.edit');
         
    Route::put('/dashboard-umkm/produk/{id}/update', [\App\Http\Controllers\UmkmDashboardController::class, 'updateProduk'])
         ->name('dashboard.produk.update');
         
    // Dashboard Trainer
    Route::get('/trainer/dashboard', [App\Http\Controllers\TrainerController::class, 'index'])
         ->name('trainer.dashboard')
         ->middleware('trainer');

    // Peserta absen 1 klik
    Route::post('/absensi/{pelatihan}/submit', [AbsensiController::class, 'submit'])
        ->name('absensi.submit');

    // Trainer: lihat daftar (JSON)
    Route::get('/trainer/kurikulum/{pelatihan}/absensi', [AbsensiController::class, 'daftarAbsensi'])
        ->name('trainer.absensi.daftar');

    // Trainer: export CSV
    Route::get('/trainer/kurikulum/{pelatihan}/absensi/export', [AbsensiController::class, 'exportCsv'])
        ->name('trainer.absensi.export');

    // =========================
    // TRAINER PROGRAM
    // =========================
    Route::post('/trainer/pelatihan/store', [App\Http\Controllers\TrainerController::class, 'storeProgram'])
        ->name('trainer.pelatihan.store');

    Route::put('/trainer/pelatihan/{id}', [App\Http\Controllers\TrainerController::class, 'updateProgram'])
        ->name('trainer.pelatihan.update');

    Route::delete('/trainer/pelatihan/{id}', [App\Http\Controllers\TrainerController::class, 'destroyProgram'])
        ->name('trainer.pelatihan.destroy');

    // =========================
    // TRAINER EVENT
    // =========================
    Route::post('/trainer/event/store', [App\Http\Controllers\TrainerController::class, 'storeEvent'])
        ->name('trainer.event.store');

    Route::put('/trainer/event/{id}', [App\Http\Controllers\TrainerController::class, 'updateEvent'])
        ->name('trainer.event.update');

    Route::delete('/trainer/event/{id}', [App\Http\Controllers\TrainerController::class, 'destroyEvent'])
        ->name('trainer.event.destroy');

    // =========================
    // TRAINER PROFILE
    // =========================
    Route::put('/trainer/profil/update', [App\Http\Controllers\TrainerController::class, 'updateProfil'])
        ->name('trainer.profil.update');
});

// =========================
// TRAINER KURIKULUM & MATERI
// =========================
Route::post('/kurikulum',       [Trainerpelatihancontroller::class, 'storeKurikulum'])  ->name('trainer.kurikulum.store');
Route::put('/kurikulum/{id}',   [Trainerpelatihancontroller::class, 'updateKurikulum']) ->name('trainer.kurikulum.update');
Route::delete('/kurikulum/{id}',[Trainerpelatihancontroller::class, 'destroy'])         ->name('trainer.kurikulum.destroy');

Route::post('/modul',           [Trainerpelatihancontroller::class, 'storeModul'])      ->name('trainer.modul.store');
Route::put('/modul/{id}',       [Trainerpelatihancontroller::class, 'updateModul'])     ->name('trainer.modul.update');
Route::delete('/modul/{id}',    [Trainerpelatihancontroller::class, 'destroy'])         ->name('trainer.modul.destroy');

// =========================================================
// GRUP ADMIN (KHUSUS ADMIN)
// =========================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Approval Program
    Route::get('/approval/program', [AdminController::class, 'approvalProgram'])->name('approval.program');
    Route::patch('/approval/program/{program}/approve', [AdminController::class, 'approveProgram'])->name('approval.program.approve');
    Route::patch('/approval/program/{program}/reject',  [AdminController::class, 'rejectProgram'])->name('approval.program.reject');

// APPROVAL PRODUK
Route::get('/approval/produk',                      [AdminController::class, 'approvalProduk'])->name('approval.produk');
Route::patch('/approval/produk/{produk}/approve',   [AdminController::class, 'approveProduk'])->name('approval.produk.approve');
Route::patch('/approval/produk/{produk}/reject',    [AdminController::class, 'rejectProduk'])->name('approval.produk.reject');
Route::delete('/approval/produk/{produk}',          [AdminController::class, 'destroyProduk'])->name('approval.produk.destroy'); // ← BARU

    // Approval Event
    Route::get('/approval/event', [AdminController::class, 'approvalEvent'])->name('approval.event');
    Route::patch('/approval/event/{event}/approve', [AdminController::class, 'approveEvent'])->name('approval.event.approve');
    Route::patch('/approval/event/{event}/reject',  [AdminController::class, 'rejectEvent'])->name('approval.event.reject');

    // Approval Trainer
    Route::get('/approval/trainer', [AdminController::class, 'approvalTrainer'])->name('approval.trainer');

    // ↓ Fallback GET: cegah error 405 jika browser akses URL approve via GET (history/refresh)
    Route::get('/approval/trainer/{user}/approve', fn() => redirect()->route('admin.approval.trainer'))
        ->name('trainer.approve.get');

    Route::post('/approval/trainer/{user}/approve', [AdminController::class, 'approveTrainer'])->name('trainer.approve');
    Route::post('/approval/trainer/{user}/reject',  [AdminController::class, 'rejectTrainer'])->name('trainer.reject');

// APPROVAL MENTOR (sudah ada, pastikan destroy-nya juga terdaftar)
Route::get('/approval/mentor',                      [AdminController::class, 'approvalMentor'])->name('approval.mentor');
Route::patch('/approval/mentor/{mentor}/approve',   [AdminController::class, 'approveMentor'])->name('approval.mentor.approve');
Route::patch('/approval/mentor/{mentor}/reject',    [AdminController::class, 'rejectMentor'])->name('approval.mentor.reject');
Route::delete('/approval/mentor/{mentor}',          [AdminController::class, 'destroyMentor'])->name('approval.mentor.destroy');

    // Pengguna
    Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('pengguna');
    Route::patch('/pengguna/{user}/verifikasi', [AdminController::class, 'verifikasiPengguna'])->name('pengguna.verifikasi');
    Route::patch('/pengguna/{user}/suspend',    [AdminController::class, 'suspendPengguna'])->name('pengguna.suspend');
    Route::patch('/pengguna/{user}/unsuspend',  [AdminController::class, 'unsuspendPengguna'])->name('pengguna.unsuspend');
});