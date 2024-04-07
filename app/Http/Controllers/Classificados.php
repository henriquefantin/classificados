<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Classificados extends Controller
{
    function listarClassificados($busca = "", $estado = "", $cidade = "")
    {
        $sql  = " SELECT P.id, P.titulo, P.descricao AS descricao, P.valor, ";
        $sql .= " T.descricao AS tipo, F.descricao AS pagamento, ";
        $sql .= " ( ";
        $sql .= "   SELECT AP.arquivo ";
        $sql .= "   FROM arquivo_produto AP ";
        $sql .= "   WHERE AP.codProduto = P.id ";
        $sql .= "   AND AP.tipo = 'I' ";
        $sql .= "   ORDER BY AP.created_at ";
        $sql .= "   LIMIT 1 ";
        $sql .= " ) AS imagem ";
        $sql .= " FROM produtos P ";
        $sql .= "   JOIN tipo_anuncio T ON T.id = P.codTipoAnuncio ";
        $sql .= "   JOIN forma_pagamento F ON F.id = P.codFormaPagamento ";
        $sql .= " WHERE P.dataFim IS NULL ";
        if ($busca != "") {
            $sql .= " AND P.TITULO LIKE '%".$busca."%'";
        }
        $sql .= " ORDER BY P.created_at DESC ";
        $rsLista = DB::select($sql);
        
        return view('welcome', ['lista' => $rsLista]);
    }
}
