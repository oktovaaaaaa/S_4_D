<?php

use App\Http\Controllers\AdminKontakController;
use App\Http\Controllers\AdminTestimoniController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProfileController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserMenuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\UserJadwalController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\UserTentangController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\UserGaleriController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\UserPengumumanController;
use App\Http\Controllers\UserController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Route::get('/dashboard', [MenuController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/', function () {
    return view('userr.home');
})->name('home');

Route::get('/userr/menu', [UserMenuController::class, 'index'])->name('userr.menu');
Route::get('userr/jadwal', [UserJadwalController::class, 'index'])->name('userr.jadwal');
Route::get('userr/tentang', [UserTentangController::class, 'index'])->name('userr.tentang');
Route::get('userr/galeri', [UserGaleriController::class, 'index'])->name('userr.galeri');
// Route::get('userr/kontak', [KontakController::class, 'index'])->name('userr.kontak');
Route::get('/kontak', [KontakController::class, 'create'])->name('kontakuser');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontakuserr');
Route::get('/userr/pengumuman', [UserPengumumanController::class, 'index'])->name('userr.pengumuman');


Route::get('/menu', [UserController::class, 'daftarMenu'])->name('userr.menu');
Route::get('/menu/{id}/detail', [UserController::class, 'tampilDetailMenu'])->name('userr.detailMenu');
Route::post('/keranjang/{menuId}/tambah', [UserController::class, 'tambahKeKeranjang'])->name('userr.tambahKeranjang');
Route::get('/keranjang', [UserController::class, 'lihatKeranjang'])->name('userr.keranjang');
Route::delete('/keranjang/{id}/hapus', [UserController::class, 'hapusDariKeranjang'])->name('userr.hapusKeranjang');
Route::post('/keranjang/proses-pembayaran', [UserController::class, 'prosesPembayaranKeranjang'])->name('userr.prosesPembayaranKeranjang');
Route::post('/menu/proses-pembayaran', [UserController::class, 'prosesPembayaran'])->name('userr.prosesPembayaran'); // Route untuk card menu
Route::get('/riwayat-pesanan', [UserController::class, 'lihatRiwayatPesanan'])->name('userr.riwayatPesanan');
Route::delete('/riwayat-pesanan/{id}/hapus', [UserController::class, 'hapusRiwayatPesanan'])->name('userr.hapusRiwayatPesanan');


Route::get('/userr.jadwal', function () {
    return view('userr.jadwal');
});

    // /* TESTIMONI*/
    // Route::resource('testimoni', TestimoniController::class);
    // Route::get('/testimoni', [TestimoniController::class, 'index'])->name('testimoni.index');
    // Route::get('/testimoni/create', [TestimoniController::class, 'create'])->name('testimoni.create');
    // Route::post('/testimoni/store', [TestimoniController::class, 'store'])->name('testimoni.store');
    // Route::get('/testimoni/{testimoni}/edit', [TestimoniController::class, 'edit'])->name('testimoni.edit');
    // Route::put('/testimoni/{testimoni}', [TestimoniController::class, 'update'])->name('testimoni.update');
    // Route::delete('/testimoni/{testimoni}', [TestimoniController::class, 'destroy'])->name('testimoni.destroy');
    Route::resource('testimoni', TestimoniController::class);


Route::middleware( 'admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //UNTUK Admin menu
    Route::get('menus', [MenuController::class, 'index'])->name('menus.tampilan');
Route::get('menus/create', [MenuController::class, 'create'])->name('menus.create');
Route::post('menus', [MenuController::class, 'store'])->name('menus.store');
Route::get('menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
Route::put('menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
Route::delete('menu/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');



// UNTUK ADMIN JADWAL
Route::get('jadwals', [JadwalController::class, 'index'])->name('jadwals.tampilan');
Route::get('jadwals/create', [JadwalController::class, 'create'])->name('jadwals.create');
Route::post('jadwals', [JadwalController::class, 'store'])->name('jadwals.store');
Route::get('jadwals/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwals.edit');
Route::put('jadwals/{jadwal}', [JadwalController::class, 'update'])->name('jadwals.update');
Route::delete('jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwals.destroy');

// UNTUK ADMIN tentang
Route::get('tentangs', [TentangController::class, 'index'])->name('tentangs.tampilan');
Route::get('tentangs/create', [TentangController::class, 'create'])->name('tentangs.create');
Route::post('tentangs', [TentangController::class, 'store'])->name('tentangs.store');
Route::get('tentangs/{tentang}/edit', [TentangController::class, 'edit'])->name('tentangs.edit');
Route::put('tentangs/{tentang}', [TentangController::class, 'update'])->name('tentangs.update');
Route::delete('tentang/{tentang}', [TentangController::class, 'destroy'])->name('tentangs.destroy');

// UNTUK ADMIN galeri
Route::get('galeris', [GaleriController::class, 'index'])->name('galeris.tampilan');
Route::get('galeris/create', [GaleriController::class, 'create'])->name('galeris.create');
Route::post('galeris', [GaleriController::class, 'store'])->name('galeris.store');
Route::get('galeris/{galeri}/edit', [GaleriController::class, 'edit'])->name('galeris.edit');
Route::put('galeris/{galeri}', [GaleriController::class, 'update'])->name('galeris.update');
Route::delete('galeri/{galeri}', [GaleriController::class, 'destroy'])->name('galeris.destroy');

// UNTUK ADMIN Testimoni
// Route::get('testimonis', [AdminTestimoniController::class, 'index'])->name('testimonis.tampilan');
// Route::delete('/testimoni/{testimoni}', [AdminTestimoniController::class, 'destroy'])->name('testimonis.delete');
Route::resource('testimonis', AdminTestimoniController::class);

//UNTUK ADMIN Notifiaksi Pesan
Route::get('kontaks',[AdminKontakController::class, 'index'])->name('kontaks.tampilan');
Route::delete('kontaks/{kontak}', [AdminKontakController::class, 'destroy'])->name('kontaks.destroy');

//UNTUK ADMIN Pengumuman
Route::get('pengumuman', [PengumumanController::class,'index'])->name('pengumumans.tampilan');
Route::get('pengumumans/create', [PengumumanController::class, 'create'])->name('pengumumans.create');
Route::post('pengumumans', [PengumumanController::class, 'store'])->name('pengumumans.store');
Route::get('pengumumans/{pengumuman}/edit', [PengumumanController::class, 'edit'])->name('pengumumans.edit');
Route::put('pengumumans/{pengumuman}', [PengumumanController::class, 'update'])->name('pengumumans.update');
Route::delete('pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumumans.destroy');



    Route::post('/logout',[AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
});

require __DIR__.'/auth.php';
