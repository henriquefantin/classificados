<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function validarCampo($valor, $tipo)
    {
        // Se o valor for nulo, retornar NULL
        if ($valor === null) {
            return 'NULL';
        }
        // Determinar o tipo e formatar a string SQL
        switch ($tipo) {
            case 'S':
                return "'$valor'";
            case 'N':
                return $valor;
                // Adicione mais casos conforme necessário

                // Se o tipo não for reconhecido, trate como string por padrão
            default:
                return "'$valor'";
        }
    }

    //Views - Lista
    function listarAnuncio() {
        $sql  = " SELECT P.id, P.titulo, T.descricao AS tipo, F.descricao AS pagamento, ";
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
        $sql .= " ORDER BY P.created_at DESC ";
        $rsLista = DB::select($sql);

        return view('listas.anuncio', ['lista' => $rsLista]);
    }
    
    function listarTipoAnuncio() {
        $sql  = " SELECT id, descricao ";
        $sql .= " FROM tipo_anuncio ";
        $sql .= " WHERE dataFim IS NULL ";
        $sql .= " ORDER BY created_at DESC ";
        $rsLista = DB::select($sql);

        return view('listas.tipoAnuncio', ['lista' => $rsLista]);
    }

    function listarFormaPagamento() {
        $sql  = " SELECT id, descricao, limiteParcelas ";
        $sql .= " FROM forma_pagamento P ";
        $sql .= " WHERE dataFim IS NULL ";
        $sql .= " ORDER BY created_at DESC ";
        $rsLista = DB::select($sql);

        return view('listas.formaPagamento', ['lista' => $rsLista]);
    }

    //Views - Cadastro
    function novoAnuncio()
    {
        $sql  = " SELECT id, descricao, limiteParcelas ";
        $sql .= " FROM forma_pagamento ";
        $sql .= " ORDER BY descricao ";
        $rsFormaPag = DB::select($sql);

        $sql  = " SELECT id, descricao ";
        $sql .= " FROM tipo_anuncio ";
        $sql .= " ORDER BY descricao ";
        $rsTipoAnuncio = DB::select($sql);

        $actionForm = route('salvarAnuncio');
        return view('cadastros.anuncio', ['actionForm' => $actionForm,'formaPagamento' => $rsFormaPag, 'tipoAnuncio' => $rsTipoAnuncio]);
    }

    function novoTipoAnuncio()
    {
        $actionForm = route('salvarTipoAnuncio');
        return view('cadastros.tipoAnuncio', ['actionForm' => $actionForm]);
    }

    function novoFormaPagamento()
    {
        $actionForm = route('salvarFormaPagamento');
        return view('cadastros.formaPagamento', ['actionForm' => $actionForm]);
    }

    //Edit Views
    function editarAnuncio($id)
    {
        $sql  = " SELECT id, descricao, limiteParcelas ";
        $sql .= " FROM forma_pagamento ";
        $sql .= " ORDER BY descricao ";
        $rsFormaPag = DB::select($sql);

        $sql  = " SELECT id, descricao ";
        $sql .= " FROM tipo_anuncio ";
        $sql .= " ORDER BY descricao ";
        $rsTipoAnuncio = DB::select($sql);

        $sql  = " SELECT id, titulo, descricao, codFormaPagamento, codTipoAnuncio ";
        $sql .= " FROM produtos ";
        $sql .= " WHERE id = ".$id;
        $sql .= " LIMIT 1 ";
        $rsProduto = DB::select($sql);

        $actionForm = route('atualizarAnuncio', ['id' => $id]);
        return view('cadastros.anuncio', ['actionForm' => $actionForm,'formaPagamento' => $rsFormaPag, 'tipoAnuncio' => $rsTipoAnuncio, 'produto' => $rsProduto[0]]);
    }

    function editarTipoAnuncio($id)
    {
        $sql  = " SELECT id, descricao ";
        $sql .= " FROM tipo_anuncio ";
        $sql .= " WHERE id = ".$id;
        $sql .= " LIMIT 1 ";
        $rsTipoAnuncio = DB::select($sql);

        $actionForm = route('atualizarTipoAnuncio', ['id' => $id]);
        return view('cadastros.tipoAnuncio', ['actionForm' => $actionForm, 'tipoAnuncio' => $rsTipoAnuncio[0]]);
    }

    function editarFormaPagamento($id)
    {
        $sql  = " SELECT id, descricao, limiteParcelas ";
        $sql .= " FROM forma_pagamento ";
        $sql .= " WHERE id = ".$id;
        $sql .= " LIMIT 1 ";
        $rsFormaPag = DB::select($sql);

        $actionForm = route('atualizarFormaPagamento', ['id' => $id]);
        return view('cadastros.formaPagamento', ['actionForm' => $actionForm, 'pagamento' => $rsFormaPag[0]]);
    }

    //Insert
    function salvarAnuncio(Request $req)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;
        $nomeImagem = "";
        $nomeVideo = "";
        $arrayImagens = [];
        $titulo = $req->input('nome');
        $descricao = $req->input('descricao');
        $codFormaPagamento = $req->input('codFormaPagamento');
        $codTipoAnuncio = $req->input('codTipoAnuncio');

        //imagens
        if ($req->hasFile('imagensUpload')) {
            foreach ($req->file('imagensUpload') as $arquivo) {
                $ext = $arquivo->extension();
                $nomeImagem = md5($arquivo->getClientOriginalName() . strtotime("now")) . "." . $ext;
                $arquivo->move(public_path('arquivos/imagens'), $nomeImagem);
                $arrayImagens[] = $nomeImagem;
            }
        }

        //video
        if ($req->hasFile('videoUpload')) {
            $arquivoVideo = $req->videoUpload;
            $ext = $arquivoVideo->extension();
            $nomeVideo = md5($arquivoVideo->getClientOriginalName() . strtotime("now")) . "." . $ext;
            $req->videoUpload->move(public_path('arquivos/videos'), $nomeVideo);
        }

        try {
            $sql  = "INSERT INTO produtos (titulo,descricao,codFormaPagamento,codTipoAnuncio) VALUES (";
            $sql .= $this->validarCampo($titulo, 'S');
            $sql .= ",".$this->validarCampo($descricao, 'S');
            $sql .= ",".$this->validarCampo($codFormaPagamento, 'N');
            $sql .= ",".$this->validarCampo($codTipoAnuncio, 'N');
            $sql .= ")";
            $rsFormaPag = DB::statement($sql);
            if ($rsFormaPag) {
                $msg = "Anuncio inserido com sucesso.";
                $idAnuncio = DB::getPdo()->lastInsertId();
            } else {
                $msg = "Erro ao inserir anuncio.";
                $erro = true;
            }

            if (!$erro && $nomeVideo != "") {
                $sql  = "INSERT INTO arquivo_produto (codProduto,arquivo,tipo) VALUES (";
                $sql .= $this->validarCampo($idAnuncio, 'N');
                $sql .= ",".$this->validarCampo($nomeVideo, 'S');
                $sql .= ",'V'";
                $sql .= ")";
                DB::statement($sql);
            }

            if (!$erro && count($arrayImagens) > 0) {
                for ($x = 0; count($arrayImagens) > $x; $x++) {
                    $sql  = "INSERT INTO arquivo_produto (codProduto,arquivo,tipo) VALUES (";
                    $sql .= $this->validarCampo($idAnuncio, 'N');
                    $sql .= ",".$this->validarCampo($arrayImagens[$x], 'S');
                    $sql .= ",'I'";
                    $sql .= ")";
                    DB::statement($sql);
                }
            }

            if ($erro) {
                DB::rollBack();
                return $msg;
            } else {
                DB::commit();
                return $idAnuncio . "#" . $msg;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return "Erro no cadastro.";
        }
    }

    function salvarTipoAnuncio(Request $req)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;
        $descricao = $req->input('descricao');

        try {
            $sql  = "INSERT INTO tipo_anuncio (descricao) VALUES (";
            $sql .= $this->validarCampo($descricao, 'S');
            $sql .= ")";
            $rsTipoAnuncio = DB::statement($sql);
            if ($rsTipoAnuncio) {
                $msg = "Tipo do anuncio inserido com sucesso.";
                $idAnuncio = DB::getPdo()->lastInsertId();
            } else {
                $msg = "Erro ao inserir o tipo do anuncio.";
                $erro = true;
            }

            if ($erro) {
                DB::rollBack();
                return $msg;
            } else {
                DB::commit();
                return $idAnuncio . "#" . $msg;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return "Erro no cadastro.";
        }
    }

    function salvarFormaPagamento(Request $req)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;
        $descricao = $req->input('descricao');
        $parcelas = $req->input('parcelas');

        try {
            $sql  = "INSERT INTO forma_pagamento (descricao,limiteParcelas) VALUES (";
            $sql .= $this->validarCampo($descricao, 'S');
            $sql .= ",".$this->validarCampo($parcelas, 'N');
            $sql .= ")";
            $rsFormaPag = DB::statement($sql);
            if ($rsFormaPag) {
                $msg = "Forma de pagamento inserida com sucesso.";
                $idAnuncio = DB::getPdo()->lastInsertId();
            } else {
                $msg = "Erro ao inserir forma de pagamento.";
                $erro = true;
            }

            if ($erro) {
                DB::rollBack();
                return $msg;
            } else {
                DB::commit();
                return $idAnuncio . "#" . $msg;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return "Erro no cadastro.";
        }
    }

    //Update
    function atualizarAnuncio(Request $req, $id)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;
        $nomeImagem = "";
        $nomeVideo = "";
        $arrayImagens = [];
        $titulo = $req->input('nome');
        $descricao = $req->input('descricao');
        $codFormaPagamento = $req->input('codFormaPagamento');
        $codTipoAnuncio = $req->input('codTipoAnuncio');

        //imagens
        if ($req->hasFile('imagensUpload')) {
            foreach ($req->file('imagensUpload') as $arquivo) {
                $ext = $arquivo->extension();
                $nomeImagem = md5($arquivo->getClientOriginalName() . strtotime("now")) . "." . $ext;
                $arquivo->move(public_path('arquivos/imagens'), $nomeImagem);
                $arrayImagens[] = $nomeImagem;
            }
        }

        //video
        if ($req->hasFile('videoUpload')) {
            $arquivoVideo = $req->videoUpload;
            $ext = $arquivoVideo->extension();
            $nomeVideo = md5($arquivoVideo->getClientOriginalName() . strtotime("now")) . "." . $ext;
            $req->videoUpload->move(public_path('arquivos/videos'), $nomeVideo);
        }

        try {
            $sql  = " UPDATE produtos SET ";
            $sql .= " titulo = ".$this->validarCampo($titulo, 'S');
            $sql .= " ,descricao = ".$this->validarCampo($descricao, 'S');
            $sql .= " ,codFormaPagamento = ".$this->validarCampo($codFormaPagamento, 'N');
            $sql .= " ,codTipoAnuncio = ".$this->validarCampo($codTipoAnuncio, 'N');
            $sql .= " WHERE id = ".$id;
            $rsFormaPag = DB::statement($sql);
            if ($rsFormaPag) {
                $msg = "Anuncio atualizado com sucesso.";
            } else {
                $msg = "Erro ao atualizar anuncio.";
                $erro = true;
            }

            if (!$erro && $nomeVideo != "") {
                $sql  = "INSERT INTO arquivo_produto (codProduto,arquivo,tipo) VALUES (";
                $sql .= $this->validarCampo($id, 'N');
                $sql .= ",".$this->validarCampo($nomeVideo, 'S');
                $sql .= ",'V'";
                $sql .= ")";
                DB::statement($sql);
            }

            if (!$erro && count($arrayImagens) > 0) {
                for ($x = 0; count($arrayImagens) > $x; $x++) {
                    $sql  = "INSERT INTO arquivo_produto (codProduto,arquivo,tipo) VALUES (";
                    $sql .= $this->validarCampo($id, 'N');
                    $sql .= ",".$this->validarCampo($arrayImagens[$x], 'S');
                    $sql .= ",'I'";
                    $sql .= ")";
                    DB::statement($sql);
                }
            }

            if ($erro) {
                DB::rollBack();
                return $msg;
            } else {
                DB::commit();
                return $id . "#" . $msg;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return "Erro no cadastro.";
        }
    }

    function atualizarTipoAnuncio(Request $req, $id)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;
        $descricao = $req->input('descricao');

        try {
            $sql  = " UPDATE tipo_anuncio SET ";
            $sql .= " descricao = ".$this->validarCampo($descricao, 'S');
            $sql .= " WHERE id = ".$id;
            $rsTipoAnuncio = DB::statement($sql);
            if ($rsTipoAnuncio) {
                $msg = "Tipo do anuncio atualizado com sucesso.";
            } else {
                $msg = "Erro ao atualizar o tipo do anuncio.";
                $erro = true;
            }

            if ($erro) {
                DB::rollBack();
                return $msg;
            } else {
                DB::commit();
                return $id . "#" . $msg;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return "Erro no cadastro.";
        }
    }

    function atualizarFormaPagamento(Request $req, $id)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;
        $descricao = $req->input('descricao');
        $parcelas = $req->input('parcelas');

        try {
            $sql  = " UPDATE forma_pagamento SET";
            $sql .= " descricao = ".$this->validarCampo($descricao, 'S');
            $sql .= " ,limiteParcelas = ".$this->validarCampo($parcelas, 'N');
            $sql .= " WHERE id = ".$id;
            $rsFormaPag = DB::statement($sql);
            if ($rsFormaPag) {
                $msg = "Forma de pagamento atualizada com sucesso.";
            } else {
                $msg = "Erro ao atualizar forma de pagamento.";
                $erro = true;
            }

            if ($erro) {
                DB::rollBack();
                return $msg;
            } else {
                DB::commit();
                return $id . "#" . $msg;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return "Erro no cadastro.";
        }
    }

    //Delete
    function encerrarAnuncio($id)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;

        try {
            $sql  = " UPDATE produtos SET ";
            $sql .= " dataFim = curdate() ";
            $sql .= " WHERE id = ".$id;
            $rsFormaPag = DB::statement($sql);
            if ($rsFormaPag) {
                $msg = "Anuncio encerrado com sucesso.";
            } else {
                $msg = "Erro ao encerrar anuncio.";
                $erro = true;
            }

            if ($erro) {
                DB::rollBack();
                return $msg;
            } else {
                DB::commit();
                return $id . "#" . $msg;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return "Erro no cadastro.";
        }
    }

    function encerrarTipoAnuncio($id)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;

        try {
            $sql  = " UPDATE tipo_anuncio SET ";
            $sql .= " dataFim = curdate() ";
            $sql .= " WHERE id = ".$id;
            $rsTipoAnuncio = DB::statement($sql);
            if ($rsTipoAnuncio) {
                $msg = "Tipo do anuncio encerrado com sucesso.";
            } else {
                $msg = "Erro ao encerrar o tipo do anuncio.";
                $erro = true;
            }

            if ($erro) {
                DB::rollBack();
                return $msg;
            } else {
                DB::commit();
                return $id . "#" . $msg;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return "Erro no cadastro.";
        }
    }

    function encerrarFormaPagamento($id)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;

        try {
            $sql  = " UPDATE forma_pagamento SET ";
            $sql .= " dataFim = curdate() ";
            $sql .= " WHERE id = ".$id;
            $rsFormaPag = DB::statement($sql);
            if ($rsFormaPag) {
                $msg = "Forma de pagamento encerrada com sucesso.";
            } else {
                $msg = "Erro ao encerrar forma de pagamento.";
                $erro = true;
            }

            if ($erro) {
                DB::rollBack();
                return $msg;
            } else {
                DB::commit();
                return $id . "#" . $msg;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return "Erro no cadastro.";
        }
    }
}
