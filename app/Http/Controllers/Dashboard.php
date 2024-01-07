<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function novoAnuncio()
    {
        return view('cadastros.anuncio');
    }

    public function tipoAnuncio()
    {
        return view('cadastros.tipoAnuncio');
    }

    public function formaPagamento()
    {
        return view('cadastros.formaPagamento');
    }
}
