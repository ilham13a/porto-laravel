<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CountController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ExperienceController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('latihan', [CountController::class, 'index']);
Route::get('penjumlahan', [CountController::class, 'jumlah'])->name('penjumlahan');
Route::get('pengurangan', [CountController::class, 'kurang'])->name('pengurangan');


Route::post('storejumlah', [CountController::class, 'storejumlah'])->name('store_penjumlahan');
Route::post('storekurang', [CountController::class, 'storekurang'])->name('store_pengurangan');

Route::get('/dashboard', function () {
    if (Auth::user()->id_level == 1) {
        return view('admin.dashboard');
    } elseif (Auth::user()->id_level == 2) {
        return view('user.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'admin']);
//profile
route::get('admin/profiles', [ProfController::class, 'index'])->name('profiles.index')->middleware(['auth', 'admin']);
route::get('admin/profiles/create', [ProfController::class, 'create'])->name('profiles.create')->middleware(['auth', 'admin']);
route::post('admin/profiles/store', [ProfController::class, 'store'])->name('profiles.makes')->middleware(['auth', 'admin']);
route::get('admin/profiles/edit/{id}', [ProfController::class, 'edit'])->name('profiles.edit')->middleware(['auth', 'admin']);
// update dan softdelete
route::put('admin/profiles/update/{id}', [ProfController::class, 'update'])->name('profiles.update')->middleware(['auth', 'admin']);
route::delete('admin/profiles/softdelete/{id}', [ProfController::class, 'softDelete'])->name('profiles.softdelete')->middleware(['auth', 'admin']);
route::post('admin/profiles/update-status/{id}', [ProfController::class, 'updateStatus'])->name('profiles.update-status');
route::get('admin/profiles/recycle', [ProfController::class, 'recycle'])->name('profiles.recycle');
route::get('admin/restore/{id}', [ProfController::class, 'restore'])->name('profiles.restore');
route::delete('admin/destroy/{id}', [ProfController::class, 'destroy'])->name('profiles.destroy');
route::get('compro', [ContentController::class, 'index']);

route::resource('experience', ExperienceController::class);

route::get('user/dashboard', [HomeController::class, 'userindex'])->middleware(['auth', 'user']);
