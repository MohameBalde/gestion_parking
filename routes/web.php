<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\HistoriqueVehiculeController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\HistoriquePaiementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('vehicules', VehiculeController::class);
    Route::resource('paiements', PaiementController::class);
    Route::resource('historiques', HistoriqueVehiculeController::class);
    Route::resource('utilisateurs', UtilisateurController::class);
    Route::post('utilisateurs/{id}/approve', [UtilisateurController::class, 'approve'])->name('utilisateurs.approve');
    Route::post('utilisateurs/{id}/reject', [UtilisateurController::class, 'reject'])->name('utilisateurs.reject');
    Route::post('utilisateurs/{id}/toggle-active', [UtilisateurController::class, 'toggleActive'])->name('utilisateurs.toggle_active');
    Route::get('utilisateurs/{id}/activities', [UtilisateurController::class, 'activities'])->name('utilisateurs.activities');
    Route::resource('historiques_paiements', HistoriquePaiementController::class)->only(['index', 'show']);
});

require __DIR__.'/auth.php';
