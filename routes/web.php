<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Classificados;
use Illuminate\Support\Facades\Mail;

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
    return redirect('/anunciantes');
});

Route::get('envio-email', function() {
    return new \App\Mail\emailNovoCliente();
    // Mail::send(new \App\Mail\emailNovoCliente());
}); 

Route::get('/anunciantes', [Classificados::class, 'listarAnunciantes'])->name('listarAnunciantes');
Route::get('/empresa/{empresa?}/{busca?}/{estado?}/{cidade?}', [Classificados::class, 'listarClassificados'])->name('classificados.empresa');
Route::get('/busca/{busca?}/{estado?}/{cidade?}', [Classificados::class, 'listarClassificados'])->name('classificados');
Route::get('/estado/{estado}/{cidade?}', [Classificados::class, 'listarClassificados'])->name('classificados.estado');
Route::post('/redirecionar', [Classificados::class, 'redirecionar'])->name('redirecionar');
Route::post('/detalheProduto', [Classificados::class, 'listarClassificados'])->name('detalheProduto');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', function() {
        return view('dashboard');
    })->name('dashboard');
    
    //Views - Lista
    Route::get('/listar/anuncio/{tipo?}', [Dashboard::class, 'listarAnuncio'])->name('listarAnuncio');
    Route::get('/listar/tipoAnuncio/{tipo?}', [Dashboard::class, 'listarTipoAnuncio'])->name('listarTipoAnuncio');
    Route::get('/listar/formaPagamento/{tipo?}', [Dashboard::class, 'listarFormaPagamento'])->name('listarFormaPagamento');
    Route::get('/listar/listarClientes', [Dashboard::class, 'listarClientes'])->name('listarClientes');
    Route::post('/verificarLimiteAnuncio', [Dashboard::class, 'verificarLimiteAnuncio'])->name('verificarLimiteAnuncio');

    //Views - Cadastro
    Route::get('/cadastro/anuncio', [Dashboard::class, 'novoAnuncio'])->name('novoAnuncio');
    Route::get('/cadastro/tipoAnuncio', [Dashboard::class, 'novoTipoAnuncio'])->name('novoTipoAnuncio');
    Route::get('/cadastro/formaPagamento', [Dashboard::class, 'novoFormaPagamento'])->name('novoFormaPagamento');
    Route::get('/cadastro/cliente', [Dashboard::class, 'novoCliente'])->name('novoCliente');

    //Views - Editar
    Route::get('/editar/anuncio/{id}', [Dashboard::class, 'editarAnuncio'])->name('editarAnuncio');
    Route::get('/editar/tipoAnuncio/{id}', [Dashboard::class, 'editarTipoAnuncio'])->name('editarTipoAnuncio');
    Route::get('/editar/formaPagamento/{id}', [Dashboard::class, 'editarFormaPagamento'])->name('editarFormaPagamento');
    Route::get('/editar/cliente/{id}', [Dashboard::class, 'editarCliente'])->name('editarCliente');

    //Insert
    Route::post('/salvar/anuncio', [Dashboard::class, 'salvarAnuncio'])->name('salvarAnuncio');
    Route::post('/salvar/tipoAnuncio', [Dashboard::class, 'salvarTipoAnuncio'])->name('salvarTipoAnuncio');
    Route::post('/salvar/formaPagamento', [Dashboard::class, 'salvarFormaPagamento'])->name('salvarFormaPagamento');
    Route::post('/salvar/cliente', [Dashboard::class, 'salvarCliente'])->name('salvarCliente');

    //Update
    Route::post('/atualizar/anuncio/{id}', [Dashboard::class, 'atualizarAnuncio'])->name('atualizarAnuncio');
    Route::post('/atualizar/tipoAnuncio/{id}', [Dashboard::class, 'atualizarTipoAnuncio'])->name('atualizarTipoAnuncio');
    Route::post('/atualizar/formaPagamento/{id}', [Dashboard::class, 'atualizarFormaPagamento'])->name('atualizarFormaPagamento');
    Route::post('/atualizar/cliente/{id}', [Dashboard::class, 'atualizarCliente'])->name('atualizarCliente');

    //Excluir - Encerrar
    Route::get('/encerrar/anuncio/{id}', [Dashboard::class, 'encerrarAnuncio'])->name('encerrarAnuncio');
    Route::get('/encerrar/tipoAnuncio/{id}', [Dashboard::class, 'encerrarTipoAnuncio'])->name('encerrarTipoAnuncio');
    Route::get('/encerrar/formaPagamento/{id}', [Dashboard::class, 'encerrarFormaPagamento'])->name('encerrarFormaPagamento');

    //Meus dados
    Route::get('editar/meusDados', [Dashboard::class, 'editarMeusDados'])->name('editarMeusDados');
    Route::post('atualizar/meusDados', [Dashboard::class, 'atualizarMeusDados'])->name('atualizarMeusDados');
});

require __DIR__.'/auth.php';