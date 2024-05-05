<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Classificados extends Controller
{
    public function redirecionar(Request $req)
    {
        $codEmpresa = $req->input("codEmpresa");
        $descricao = $req->input("descricao");
        $estado = $req->input("estado");
        $cidade = $req->input("cidade");

        if ($codEmpresa != "") {
            $urlRedirecionar = route("classificados.empresa", ["empresa" => $codEmpresa, "busca" => $descricao, "estado" => $estado, "cidade" => $cidade]);
        } else if ($estado != "" && $descricao == "") {
            $urlRedirecionar = route("classificados.estado", ["estado" => $estado, "cidade" => $cidade]);
        } else {
            $urlRedirecionar = route("classificados", ["busca" => $descricao, "estado" => $estado, "cidade" => $cidade]);
        }
        return response()->json(['url' => $urlRedirecionar]);
    }

    function listarAnunciantes()
    {
        $sql  = " SELECT id, arquivo, nome, email, telefone, celular, instagram, estado, ";
        $sql .= " cidade, bairro, rua, numero, complemento, ";
        $sql .= " CASE WHEN nivelCliente = 3 THEN 0 ELSE 1 END AS ordem ";
        $sql .= " FROM empresa E ";
        $sql .= " WHERE EXISTS ( ";
        $sql .= "     SELECT 1 ";
        $sql .= "     FROM users U ";
        $sql .= "     WHERE U.codEmpresa = E.id ";
        $sql .= "     AND U.ativo = 'S' ";
        $sql .= " ) ";
        $sql .= " ORDER BY ordem ";
        $rsEmpresa = DB::select($sql);

        return view('anunciantes',['empresa' => $rsEmpresa]);
    }

    function listarClassificados(Request $req, $codEmpresa = "", $busca = "", $estado = "", $cidade = "")
    {
        $retornoBusca = "";
        $retornoEstado = "";
        $retornoCidade = "";
        $valorReq = explode("/", urldecode($req->path()));
        $tipo = "";
        if ($valorReq[0] == "empresa" || $valorReq[0] == "busca" || $valorReq[0] == "estado") {
            $tipo = $valorReq[0];
            if (count($valorReq) > 1) {
                if ($tipo == "busca") {
                    $busca = $valorReq[1];
                    $retornoBusca = $valorReq[1];
                } else if ($tipo == "estado") {
                    if (!is_null($valorReq[1]) && $valorReq[1] != "") {
                        $estado = $valorReq[1];
                        $retornoEstado = $valorReq[1];
                    }
                    if (count($valorReq) > 2) {
                        if (!is_null($valorReq[2]) && $valorReq[2] != "") {
                            $cidade = $valorReq[2];
                            $retornoCidade = $valorReq[2];
                        }
                    }
                }
            }
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
        $sql .= " E.nome AS nomeEmpresa, E.email, E.telefone, E.celular, E.cep ";
        $sql .= " FROM produtos P ";
        $sql .= "   JOIN tipo_anuncio T ON T.id = P.codTipoAnuncio ";
        $sql .= "   JOIN forma_pagamento F ON F.id = P.codFormaPagamento ";
        $sql .= "   JOIN empresa E ON E.id = P.codEmpresa ";
        $sql .= " WHERE P.dataFim IS NULL ";
        if (!is_null($codEmpresa) && $codEmpresa != ""&& ($tipo == "empresa")) {
            $sql .= " AND P.codEmpresa = " . $codEmpresa;
        }
        if (!is_null($codProduto) && $codProduto != "") {
            $sql .= " AND P.id = " . $codProduto;
        }
        if (!is_null($busca) && $busca != "" && ($tipo == "" || $tipo == "busca")) {
            $sql .= " AND P.TITULO LIKE '%" . $busca . "%'";
        }
        if (!is_null($estado) && $estado !== '') {
            $sql .= " AND E.estado = '" . $estado . "'";
        }
        if (!is_null($cidade) && $cidade !== '') {
            $sql .= " AND E.cidade LIKE '%" . $cidade . "%'";
        }
        // if ($tipoAnuncio != 0) {
        //     $sql .= " AND T.id = " . $tipoAnuncio;
        // }
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
                $arrayImagens[$contImg] = url('arquivos/imagens/' . $reg->arquivo);
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
                $video = url('arquivos/videos/' . $rsVideo[0]->arquivo);
            }

            return response()->json(['lista' => $rsLista, 'imagens' => $arrayImagens, 'video' => $video]);
        } else {
            return view('produtos', ['lista' => $rsLista, 'busca' => $retornoBusca, 'estado' => $retornoEstado, 'cidade' => $retornoCidade, 'tipo' => $rsTipo]);
        }
    }
}
