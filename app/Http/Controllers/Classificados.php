<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Classificados extends Controller
{
    public function redirecionar(Request $req)
    {
        $descricao = $req->input("descricao");
        $estado = $req->input("estado");
        $cidade = $req->input("cidade");
        $tipoAnuncio = $req->input("tipoAnuncio");

        if ($descricao != "" && $estado == "") {
            $urlRedirecionar = route("classificados.busca", ["tipoA" => $tipoAnuncio, "busca" => $descricao]);
        } else if ($estado != "" && $descricao == "") {
            $urlRedirecionar = route("classificados.estado", ["tipoA" => $tipoAnuncio, "estado" => $estado, "cidade" => $cidade]);
        } else {
            $urlRedirecionar = route("classificados", ["tipoA" => $tipoAnuncio, "busca" => $descricao, "estado" => $estado, "cidade" => $cidade]);
        }
        return response()->json(['url' => $urlRedirecionar]);
    }

    function listarClassificados(Request $req, $tipoAnuncio = 0, $busca = "", $estado = "", $cidade = "")
    {
        $retornoBusca = "";
        $retornoEstado = "";
        $retornoCidade = "";
        $valorReq = explode("/", $req->path());
        $tipo = "";
        if ($valorReq[0] == "busca" || $valorReq[0] == "estado") {
            $tipo = $valorReq[0];
        }
        $codProduto = $req->input("codProduto");

        $sql  = " SELECT P.id, P.titulo, P.descricao AS descricao, P.valor, ";
        $sql .= " T.descricao AS tipo, F.descricao AS pagamento, ";
        $sql .= " ( ";
        $sql .= "   SELECT AP.arquivo ";
        $sql .= "   FROM arquivo_produto AP ";
        $sql .= "   WHERE AP.codProduto = P.id ";
        $sql .= "   AND AP.tipo = 'I' ";
        $sql .= "   ORDER BY AP.created_at ";
        $sql .= "   LIMIT 1 ";
        $sql .= " ) AS imagem, ";
        $sql .= " E.nome AS nomeEmpresa, E.email, E.telefone, E.celular ";
        $sql .= " FROM produtos P ";
        $sql .= "   JOIN tipo_anuncio T ON T.id = P.codTipoAnuncio ";
        $sql .= "   JOIN forma_pagamento F ON F.id = P.codFormaPagamento ";
        $sql .= "   JOIN empresa E ON E.id = P.codEmpresa ";
        $sql .= " WHERE P.dataFim IS NULL ";
        if (!is_null($codProduto) && $codProduto != "") {
            $sql .= " AND P.id = " . $codProduto;
        }
        if (!is_null($busca) && $busca != "" && ($tipo == "" || $tipo == "busca")) {
            $sql .= " AND P.TITULO LIKE '%" . $busca . "%'";
            $retornoBusca = $busca;
        }
        if (!is_null($estado) && $estado !== '' && ($tipo == "" || $tipo == "estado")) {
            $sql .= " AND E.estado = '" . $estado . "'";
            $retornoEstado = $estado;
        }
        if (!is_null($cidade) && $cidade !== '' && ($tipo == "" || $tipo == "estado")) {
            $sql .= " AND E.cidade LIKE '%" . $cidade . "%'";
            $retornoCidade = $cidade;
        }
        if ($tipoAnuncio != 0) {
            $sql .= " AND T.id = " . $tipoAnuncio;
        }
        $sql .= " ORDER BY P.created_at DESC ";
        $rsLista = DB::select($sql);

        $sql  = " SELECT id, descricao ";
        $sql .= " FROM tipo_anuncio ";
        $sql .= " WHERE dataFim IS NULL ";
        $rsTipo = DB::select($sql);

        
        if (!is_null($codProduto) && $codProduto != "") {
            $sql  = " SELECT AP.arquivo ";
            $sql .= " FROM arquivo_produto AP ";
            $sql .= " WHERE AP.codProduto = " . $codProduto;
            $sql .= " AND AP.tipo = 'I' ";
            $sql .= " ORDER BY AP.created_at ";
            $rsImagens = DB::select($sql);
            
            $arrayImagens = [];
            $contImg = 0;
            foreach ($rsImagens as $reg) {
                $arrayImagens[$contImg] = url('arquivos/imagens/'.$reg->arquivo);
                $contImg++;
            }

            $sql  = " SELECT AP.arquivo ";
            $sql .= " FROM arquivo_produto AP ";
            $sql .= " WHERE AP.codProduto = " . $codProduto;
            $sql .= " AND AP.tipo = 'V' ";
            $sql .= " ORDER BY AP.created_at ";
            $rsVideo = DB::select($sql);
            
            $video = "";
            if ($rsVideo) {
                $video = url('arquivos/videos/'.$rsVideo[0]->arquivo);
            }

            return response()->json(['lista' => $rsLista, 'imagens' => $arrayImagens, 'video' => $video]);
        } else {
            return view('welcome', ['lista' => $rsLista, 'busca' => $retornoBusca, 'estado' => $retornoEstado, 'cidade' => $retornoCidade, 'tipo' => $rsTipo, 'tipoAnuncio' => $tipoAnuncio]);
        }
    }
}
