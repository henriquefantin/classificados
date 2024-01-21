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
    
    //Views - Lista
    Route::get('/listar/anuncio', [Dashboard::class, 'listarAnuncio'])->name('listarAnuncio');
    Route::get('/listar/tipoAnuncio', [Dashboard::class, 'listarTipoAnuncio'])->name('listarTipoAnuncio');
    Route::get('/listar/formaPagamento', [Dashboard::class, 'listarFormaPagamento'])->name('listarFormaPagamento');

    //Views - Cadastro
    Route::get('/cadastro/anuncio', [Dashboard::class, 'novoAnuncio'])->name('novoAnuncio');
    Route::get('/cadastro/tipoAnuncio', [Dashboard::class, 'novoTipoAnuncio'])->name('novoTipoAnuncio');
    Route::get('/cadastro/formaPagamento', [Dashboard::class, 'novoFormaPagamento'])->name('novoFormaPagamento');

    //Insert
    Route::post('/salvar/anuncio', [Dashboard::class, 'salvarAnuncio'])->name('salvarAnuncio');
    Route::post('/salvar/tipoAnuncio', [Dashboard::class, 'salvarTipoAnuncio'])->name('salvarTipoAnuncio');
    Route::post('/salvar/formaPagamento', [Dashboard::class, 'salvarFormaPagamento'])->name('salvarFormaPagamento');

    //Update
});



require __DIR__.'/auth.php';
