<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;

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
    return view('welcome');
});


Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/cadastro/anuncio', [Dashboard::class, 'novoAnuncio'])->name('novoAnuncio');
    Route::get('/cadastro/tipo', [Dashboard::class, 'tipoAnuncio'])->name('tipoAnuncio');
    Route::get('/cadastro/pagamento', [Dashboard::class, 'formaPagamento'])->name('formaPagamento');

    Route::post('/salvar/tipo', [Dashboard::class, 'salvarTipoAnuncio'])->name('salvarTipoAnuncio');
});



require __DIR__.'/auth.php';
