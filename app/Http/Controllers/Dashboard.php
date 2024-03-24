<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            default:
                // Se o tipo não for reconhecido, trate como string por padrão
                return "'$valor'";
        }
    }

    //Views - Lista
    function listarAnuncio($tipo = "A") {
        $sql  = " SELECT P.id, P.titulo, T.descricao AS tipo, F.descricao AS pagamento, P.valor, ";
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
        if ($tipo == "A") {
            $sql .= " WHERE P.dataFim IS NULL ";
        } else if ($tipo == "E") {
            $sql .= " WHERE P.dataFim IS NOT NULL ";
        }
        if (Auth::user()->tipo == 1) {
            $sql .= " AND P.codEmpresa = ". Auth::user()->codEmpresa;
        }
        $sql .= " ORDER BY P.created_at DESC ";
        $rsLista = DB::select($sql);

        return view('listas.anuncio', ['lista' => $rsLista, 'tipo' => $tipo]);
    }
    
    function listarTipoAnuncio($tipo = "A") {
        $sql  = " SELECT id, descricao ";
        $sql .= " FROM tipo_anuncio ";
        if ($tipo == "A") {
            $sql .= " WHERE dataFim IS NULL ";
        } else if ($tipo == "E") {
            $sql .= " WHERE dataFim IS NOT NULL ";
        }
        $sql .= " ORDER BY created_at DESC ";
        $rsLista = DB::select($sql);

        return view('listas.tipoAnuncio', ['lista' => $rsLista, 'tipo' => $tipo]);
    }

    function listarFormaPagamento($tipo = "A") {
        $sql  = " SELECT id, descricao, limiteParcelas ";
        $sql .= " FROM forma_pagamento P ";
        if ($tipo == "A") {
            $sql .= " WHERE dataFim IS NULL ";
        } else if ($tipo == "E") {
            $sql .= " WHERE dataFim IS NOT NULL ";
        }
        $sql .= " ORDER BY created_at DESC ";
        $rsLista = DB::select($sql);

        return view('listas.formaPagamento', ['lista' => $rsLista, 'tipo' => $tipo]);
    }

    function listarClientes() {
        $sql  = " SELECT id, nome, cnpj, IFNULL(nivelCliente,'-') AS nivelCliente, ";
        $sql .= " IFNULL((SELECT 'N' FROM users U WHERE U.codEmpresa = E.id AND (U.ativo = 'N' OR U.ativo IS NULL) LIMIT 1),'S') AS ativo ";
        $sql .= " FROM empresa E ";
        $sql .= " ORDER BY nome ";
        $rsLista = DB::select($sql);

        return view('listas.clientes', ['lista' => $rsLista]);
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

        $arrayImagens = [];
        $arrayVideos = [];
        $actionForm = route('salvarAnuncio');
        return view('cadastros.anuncio', [
            'actionForm' => $actionForm,
            'formaPagamento' => $rsFormaPag,
            'tipoAnuncio' => $rsTipoAnuncio,
            'imagens' => $arrayImagens,
            'video' => $arrayVideos
        ]);
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

        $sql  = " SELECT id, titulo, descricao, codFormaPagamento, codTipoAnuncio, valor ";
        $sql .= " FROM produtos ";
        $sql .= " WHERE id = ".$id;
        $sql .= " LIMIT 1 ";
        $rsProduto = DB::select($sql);

        $sql  = " SELECT arquivo ";
        $sql .= " FROM arquivo_produto ";
        $sql .= " WHERE codProduto = ".$id;
        $sql .= " AND tipo = 'I' ";
        $rsImagens = DB::select($sql);

        $arrayImagens = [];
        $contImg = 0;
        foreach ($rsImagens as $reg) {
            $arrayImagens[$contImg] = url('arquivos/imagens/'.$reg->arquivo);
            $contImg++;
        }

        $sql  = " SELECT arquivo ";
        $sql .= " FROM arquivo_produto ";
        $sql .= " WHERE codProduto = ".$id;
        $sql .= " AND tipo = 'V' ";
        $rsVideo = DB::select($sql);

        $arrayVideos = [];
        $contVid = 0;
        foreach ($rsVideo as $reg) {
            $arrayVideos[$contVid] = url('arquivos/videos/'.$reg->arquivo);
            $contVid++;
        }

        $actionForm = route('atualizarAnuncio', ['id' => $id]);
        return view('cadastros.anuncio', [
            'actionForm' => $actionForm,
            'formaPagamento' => $rsFormaPag,
            'tipoAnuncio' => $rsTipoAnuncio,
            'produto' => $rsProduto[0],
            'imagens' => $arrayImagens,
            'video' => $arrayVideos
        ]);
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

    function editarCliente($id)
    {
        $sql  = " SELECT nome, cnpj, IFNULL(nivelCliente,'') AS nivelCliente, ";
        $sql .= " IFNULL((SELECT 'N' FROM users U WHERE U.codEmpresa = E.id AND (U.ativo = 'N' OR U.ativo IS NULL) LIMIT 1),'S') AS ativo ";
        $sql .= " FROM empresa E ";
        $sql .= " WHERE E.id = ".$id;
        $sql .= " ORDER BY nome ";
        $rsEmpresa = DB::select($sql);

        $actionForm = route('atualizarCliente', ['id' => $id]);
        return view('cadastros.cliente', ['actionForm' => $actionForm, 'empresa' => $rsEmpresa[0]]);
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
        $valor = $req->input('valor');

        if ($titulo == "") {
            $msg = "O nome do produto é obrigatório.";
            $erro = true;
        } else if ($descricao == "") {
            $msg = "A descrição do produto é obrigatória.";
            $erro = true;
        } else if ($valor == "") {
            $msg = "O valor é obrigatório.";
            $erro = true;
        } else if ($codFormaPagamento == "") {
            $msg = "A forma de pagamento é obrigatória.";
            $erro = true;
        } else if ($codTipoAnuncio == "") {
            $msg = "O tipo de anuncio é obrigatório.";
            $erro = true;
        }

        if (!$erro) {
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

            if (sizeof($arrayImagens) == 0) {
                $msg = "É necessário incluir pelo menos uma imagem do produto.";
                $erro = true;
            }
    
            if (!$erro) {
                try {
                    $sql  = "INSERT INTO produtos (titulo,descricao,codFormaPagamento,codTipoAnuncio,valor) VALUES (";
                    $sql .= $this->validarCampo($titulo, 'S');
                    $sql .= ",".$this->validarCampo($descricao, 'S');
                    $sql .= ",".$this->validarCampo($codFormaPagamento, 'N');
                    $sql .= ",".$this->validarCampo($codTipoAnuncio, 'N');
                    $sql .= ",".$this->validarCampo($valor, 'S');
                    $sql .= ")";
                    $rsFormaPag = DB::statement($sql);
                    if ($rsFormaPag) {
                        $msg = "Anuncio inserido com sucesso.";
                        $idProduto = DB::getPdo()->lastInsertId();
                    } else {
                        $msg = "Erro ao inserir anuncio.";
                        $erro = true;
                    }
        
                    if (!$erro && $nomeVideo != "") {
                        $sql  = "INSERT INTO arquivo_produto (codProduto,arquivo,tipo) VALUES (";
                        $sql .= $this->validarCampo($idProduto, 'N');
                        $sql .= ",".$this->validarCampo($nomeVideo, 'S');
                        $sql .= ",'V'";
                        $sql .= ")";
                        DB::statement($sql);
                    }
        
                    if (!$erro && count($arrayImagens) > 0) {
                        for ($x = 0; count($arrayImagens) > $x; $x++) {
                            $sql  = "INSERT INTO arquivo_produto (codProduto,arquivo,tipo) VALUES (";
                            $sql .= $this->validarCampo($idProduto, 'N');
                            $sql .= ",".$this->validarCampo($arrayImagens[$x], 'S');
                            $sql .= ",'I'";
                            $sql .= ")";
                            DB::statement($sql);
                        }
                    }
                } catch (\Exception $e) {
                    $msg = "Erro no cadastro.";
                    $erro = true;
                }
            }
        }
    
        if ($erro) {
            DB::rollBack();
            return response()->json(["success" => false, "msg" => $msg]);
        } else {
            DB::commit();
            return response()->json(["success" => true, "msg" => $msg, "id" => $idProduto]);
        }
    }

    function salvarTipoAnuncio(Request $req)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;
        $descricao = $req->input('descricao');
        
        if ($descricao == "") {
            $msg = "A descrição do tipo do anuncio é obrigatória.";
            $erro = true;
        }

        if (!$erro) {
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
            } catch (\Exception $e) {
                $msg = "Erro no cadastro.";
                $erro = true;
            }
        }
    
        if ($erro) {
            DB::rollBack();
            return response()->json(["success" => false, "msg" => $msg]);
        } else {
            DB::commit();
            // return redirect('/listar/anuncio')->with('mensagemAlertSuccess', $msg);
            return response()->json(["success" => true, "msg" => $msg, "id" => $idAnuncio]);
        }
    }

    function salvarFormaPagamento(Request $req)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;
        $descricao = $req->input('descricao');
        $parcelas = $req->input('parcelas');
        
        if ($descricao == "") {
            $msg = "A descrição da forma de pagamento é obrigatória.";
            $erro = true;
        } else if ($parcelas = "") {
            $msg = "O limite de parcelas é obrigatório.";
            $erro = true;
        }

        if (!$erro) {
            try {
                $sql  = "INSERT INTO forma_pagamento (descricao,limiteParcelas) VALUES (";
                $sql .= $this->validarCampo($descricao, 'S');
                $sql .= ",".$this->validarCampo($parcelas, 'N');
                $sql .= ")";
                $rsFormaPag = DB::statement($sql);
                if ($rsFormaPag) {
                    $msg = "Forma de pagamento inserida com sucesso.";
                    $idFormaPagamento = DB::getPdo()->lastInsertId();
                } else {
                    $msg = "Erro ao inserir forma de pagamento.";
                    $erro = true;
                }
            } catch (\Exception $e) {
                $msg = "Erro no cadastro.";
                $erro = true;
            }
        }
    
        if ($erro) {
            DB::rollBack();
            return response()->json(["success" => false, "msg" => $msg]);
        } else {
            DB::commit();
            return response()->json(["success" => true, "msg" => $msg, "id" => $idFormaPagamento]);
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
        $valor = $req->input('valor');

        if ($titulo == "") {
            $msg = "O nome do produto é obrigatório.";
            $erro = true;
        } else if ($descricao == "") {
            $msg = "A descrição do produto é obrigatória.";
            $erro = true;
        } else if ($valor == "") {
            $msg = "O valor é obrigatório.";
            $erro = true;
        } else if ($codFormaPagamento == "") {
            $msg = "A forma de pagamento é obrigatória.";
            $erro = true;
        } else if ($codTipoAnuncio == "") {
            $msg = "O tipo de anuncio é obrigatório.";
            $erro = true;
        }

        if (!$erro) {
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

            if (!$erro) {
                try {
                    $sql  = " UPDATE produtos SET ";
                    $sql .= " titulo = ".$this->validarCampo($titulo, 'S');
                    $sql .= " ,descricao = ".$this->validarCampo($descricao, 'S');
                    $sql .= " ,codFormaPagamento = ".$this->validarCampo($codFormaPagamento, 'N');
                    $sql .= " ,codTipoAnuncio = ".$this->validarCampo($codTipoAnuncio, 'N');
                    $sql .= " ,valor = ".$this->validarCampo($valor, 'S');
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
                } catch (\Exception $e) {
                    $msg = "Erro no cadastro.";
                    $erro = true;
                }
            }
        }
    
        if ($erro) {
            DB::rollBack();
            return response()->json(["success" => false, "msg" => $msg]);
        } else {
            DB::commit();
            return response()->json(["success" => true, "msg" => $msg, "id" => $id]);
        }
    }

    function atualizarTipoAnuncio(Request $req, $id)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;
        $descricao = $req->input('descricao');
        
        if ($descricao == "") {
            $msg = "A descrição do tipo do anuncio é obrigatória.";
            $erro = true;
        }

        if (!$erro) {
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
            } catch (\Exception $e) {
                $msg = "Erro no cadastro.";
                $erro = true;
            }
        }
    
        if ($erro) {
            DB::rollBack();
            return response()->json(["success" => false, "msg" => $msg]);
        } else {
            DB::commit();
            return response()->json(["success" => true, "msg" => $msg, "id" => $id]);
        }
    }

    function atualizarFormaPagamento(Request $req, $id)
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;
        $descricao = $req->input('descricao');
        $parcelas = $req->input('parcelas');
        
        if ($descricao == "") {
            $msg = "A descrição da forma de pagamento é obrigatória.";
            $erro = true;
        } else if ($parcelas = "") {
            $msg = "O limite de parcelas é obrigatório.";
            $erro = true;
        }

        if (!$erro) {
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
            } catch (\Exception $e) {
                $msg = "Erro no cadastro.";
                $erro = true;
            }
        }
    
        if ($erro) {
            DB::rollBack();
            return response()->json(["success" => false, "msg" => $msg]);
        } else {
            DB::commit();
            return response()->json(["success" => true, "msg" => $msg, "id" => $id]);
        }
    }

    function atualizarCliente(Request $req, $id) 
    {
        DB::beginTransaction();

        $msg = "";
        $erro = false;
        $nivel = $req->input('nivel');
        $ativo = $req->input('ativo');
        // dd($ativo);
        
        if ($nivel == "") {
            $msg = "O nível é obrigatório.";
            $erro = true;
        } else if ($ativo == "") {
            $msg = "O status é obrigatório.";
            $erro = true;
        }

        if (!$erro) {
            try {
                $sql  = " UPDATE empresa SET";
                $sql .= " nivelCliente = ".$this->validarCampo($nivel, 'N');
                $sql .= " WHERE id = ".$id;
                $rsAttEmpresa = DB::statement($sql);
                
                $sql  = " UPDATE users SET";
                $sql .= " ativo = ".$this->validarCampo($ativo, 'S');
                $sql .= " WHERE codEmpresa = ".$id;
                $rsAttUser = DB::statement($sql);
                
                if ($rsAttUser && $rsAttEmpresa) {
                    $msg = "Cliente atualizado com sucesso.";
                } else {
                    $msg = "Erro ao atualizar cliente.";
                    $erro = true;
                }
            } catch (\Exception $e) {
                $msg = "Erro no cadastro.";
                $erro = true;
            }
        }
    
        if ($erro) {
            DB::rollBack();
            return response()->json(["success" => false, "msg" => $msg]);
        } else {
            DB::commit();
            return response()->json(["success" => true, "msg" => $msg, "id" => $id]);
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
