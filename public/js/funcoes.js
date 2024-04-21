var urlRedirecionar = "{{ route('classificados') }}";
var valorEstado = "";
var valorCidade = "";
var tipoAnuncio = "";
$(document).ready(function () {
  $("#divSanduicheNavbar").click(function () {
    if ($("#navbarConteudo").is(":hidden")) {
      $("#navbarConteudo").fadeIn(200);
    } else {
      $("#navbarConteudo").fadeOut(200);
    }
  });
  $(".estadoBusca").change(function () {
    buscarCidadeEstado($(this).val());
  });
  $("#buscarAnuncioPC").click(function () {
    let cidade = "";
    if ($("#cidadeBuscaPC").val() != "") {
      cidade = $("#cidadeBuscaPC option:selected").text();
    }
    buscarAnuncioDetalhe($("#descBuscaPC").val(), $("#estadoBuscaPC").val(), cidade, tipoAnuncio);
  });
  $("#buscarAnuncioMobile").click(function () {
    let cidade = "";
    if ($("#cidadeBuscaMobile").val() != "") {
      cidade = $("#cidadeBuscaMobile option:selected").text();
    }
    buscarAnuncioDetalhe($("#descBuscaMobile").val(), $("#estadoBuscaMobile").val(), cidade, tipoAnuncio);
  });
  $(".buscarTipo").each(function () {
    $(this).removeClass("bg-primary-accent-200");
    if ($(this).attr("codigo") == tipoAnuncio) {
      $(this).addClass("bg-primary-accent-200");
    }
  });
  $(".buscarTipo").click(function () {
    let tipoAnuncioRedirecionar = $(this).attr("codigo");
    let url = window.location.href.split("tipo");
    let parametros = url[1].split("/");
    parametros[1] = tipoAnuncioRedirecionar;
    window.location.href = url[0] + "tipo" + parametros.join("/");
  });
  $(".cardProduto").click(function () {
    carregarProduto($(this).attr("codigo"));
  });
  atualizarBusca();
});

function atualizarBusca() {
  if ($("#dadoEstado").val() != "") {
    $(".estadoBusca").val(valorEstado).change();
  }
}

function buscarAnuncioDetalhe(descricao, estado, cidade, tipo) {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "/redirecionar",
    type: "POST",
    cache: false,
    data: {
      "descricao": descricao,
      "estado": estado,
      "cidade": cidade,
      "tipo": tipo,
      "random": Math.random()
    },
    success: function (response) {
      if (response && response.url) {
        window.location.href = response.url;
      }
    }
  });
}

function carregarProduto(codProduto) {
  let modal = document.getElementById('popupCarregando');
  modal.classList.remove('hidden');
  $("#btnProduto").click();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: "/detalheProduto",
    type: "POST",
    cache: false,
    data: {
      "codProduto": codProduto,
      "random": Math.random()
    },
    error: function () {
      modal.classList.add('hidden');
    },
    success: function (response) {
      modal.classList.add('hidden');
      if (response) {
        if (response.lista) {
          let dadosLista = response.lista[0];
          $("#tituloProduto").text(dadosLista.titulo);
          $("#descricaoProduto").text(dadosLista.descricao);
          $("#formaPagamento").text(dadosLista.pagamento);

          $("#nomeEmpresa").text(dadosLista.nomeEmpresa);
          if (dadosLista.email != "" && dadosLista.email != null) {
            $("#email").text(dadosLista.email).parent().fadeIn(0);
          } else {
            $("#email").text("").parent().fadeOut(0);
          }
          if (dadosLista.celular != "" && dadosLista.celular != null) {
            $("#celular").text(dadosLista.celular).parent().fadeIn(0);
          } else {
            $("#celular").text("").parent().fadeOut(0);
          }
          if (dadosLista.telefone != "" && dadosLista.telefone != null) {
            $("#telefone").text(dadosLista.telefone).parent().fadeIn(0);
          } else {
            $("#telefone").text("").parent().fadeOut(0);
          }

          let valor = "0.00";
          if (dadosLista.valor != "" && dadosLista.valor != null) {
            valor = dadosLista.valor;
          }
          $("#valorProduto").text(valor);
        }

        $("#conteudoImg").empty();
        $("#videoProduto").empty();
        if (response.imagens) {
          let dadosImgs = response.imagens;
          let conteudoImgs = "";
          for (let i = 0; i < dadosImgs.length; i++) {
            conteudoImgs += '<div class="flex w-1/2 flex-wrap abrirImagem">'
              + '<div class="w-full p-1 md:p-2 hover:scale-150">'
              + '<img alt="gallery" class="block h-full w-full rounded-lg object-cover object-center" src="' + dadosImgs[i] + '" />'
              + '</div>'
              + '</div>';
          }
          $("#conteudoImg").append(conteudoImgs);
          $(".abrirImagem").click(function () {
            // Obtém o URL da imagem clicada
            let imageUrl = $(this).children().children().attr("src");
            // Abre a imagem em uma nova guia
            window.open(imageUrl);
          });
        }

        if (response.video) {
          $("#videoProduto").append('<video class="block rounded-lg w-75 max-h-80" controls src="' + response.video + '"></video>');
        }
      }
    }
  });
}

function validarFormulario(idForm, validarClasse) {
  let camposValidados = true;
  let countFoco = 0;
  $("form[name='" + idForm + "'] ." + validarClasse).each(function () {
    if ($(this).val() == "") {
      if (!$(this).hasClass("arquivos")) {
        console.log("entrou");
        $(this).addClass("border-red-500");
        $(this).addClass("bg-red-50");
        $(this).removeClass("border-green-500");
        if (!$(this).hasClass("valores")) {
          $(this).next("p").fadeIn(0);
        } else {
          $(this).parent().next("p").fadeIn(0);
        }
      } else {
        $(this).parent().parent().parent().parent().addClass("border-red-500");
        $(this).parent().parent().parent().parent().removeClass("border-green-500");
        $(this).parent().parent().next("p").next("p").fadeIn(0);
      }

      if (countFoco == 0) {
        $(this).focus();
      }

      countFoco += 1;
      camposValidados = false;
    } else {
      if (!$(this).hasClass("arquivos")) {
        $(this).removeClass("border-red-500");
        $(this).removeClass("bg-red-50");
        $(this).addClass("border-green-500");
        if (!$(this).hasClass("valores")) {
          $(this).next("p").fadeOut(0);
        } else {
          $(this).parent().next("p").fadeOut(0);
        }
      } else {
        $(this).parent().parent().parent().parent().removeClass("border-red-500");
        $(this).parent().parent().parent().parent().addClass("border-green-500");
        $(this).parent().parent().next("p").next("p").fadeOut(0);
      }

      camposValidados = true;
    }
  });
  if (countFoco > 0) {
    camposValidados = false;
  }
  return camposValidados;
}

function mascara(componente, tipo) {
  var valor = componente.value;
  var formato = '';
  switch (tipo) {
    case 'cpf':
      formato = "xxx.xxx.xxx-xx";
      break;
    case 'data':
      formato = 'xx/xx/xxxx';
      break;
    case 'dataHora':
      formato = 'xx/xx/xxxx xx:xx';
      break;
    case 'hora':
      formato = 'xx:xx';
      break;
    case 'cnpj':
      formato = 'xx.xxx.xxx/xxxx-xx';
      break;
    case 'cep':
      formato = 'xxxxx-xxx';
      break;
    case 'fone':
      if (valor.length > 13) {
        valor = valor.replace("-", "");
        formato = '(xx)xxxxx-xxxx';
      } else {
        formato = '(xx)xxxx-xxxx';
      }
      break;
    case 'moeda':
      valor = componente.value.replace(/\D/g, ''); // Remove todos os caracteres que não são dígitos
      formato = 'xxx.xxx.xxx,xx';
      break;
  }
  if (valor != "") {
    if (tipo != "moeda") {
      var comprimento = valor.length;
      var caracter = '';
      for (cont = 0; cont < comprimento; cont++) {
        caracter = formato.substr(cont, 1);
        if (caracter != "x" && caracter != valor.substr(cont, 1)) {
          valor = valor.substr(0, cont) + caracter + valor.substr(cont);
        }
      }
      valor = valor.substr(0, formato.length);
    } else {
      var parteInteira = valor.substring(0, valor.length - 2); // Obtém a parte inteira do valor
      var parteDecimal = valor.substring(valor.length - 2); // Obtém a parte decimal do valor
      var parteInteiraFormatada = parteInteira.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'); // Formata a parte inteira com pontos
      var valorFormatado = parteInteiraFormatada + ',' + parteDecimal; // Une a parte inteira formatada com a parte decimal
      valor = valorFormatado;
    }
  }

  componente.value = valor;
  switch (tipo) {
    case "data":
      validarCampoData(componente);
      break;
    case "hora":
      validarCampoHora(componente);
      break;
    case "dataHora":
      validarCampoDataHora(componente);
      break;
    case "cpf":
      if (componente.value.length == 14) {
        validarCPF(componente);
      }
      break;
    case "cnpj":
      if (componente.value.length == 18) {
        if (validarCNPJ(componente.value)) {
          $("#" + componente.id).next("p").fadeOut(0);
        } else {
          $("#" + componente.id).next("p").fadeIn(0);
          $("#" + componente.id).val("");
        }
      }
      break;
    case "cep":
      if (componente.value.length == 9) {
        buscarCep(componente.value);
      }
      break;
  }
  return true;
}

function validarCNPJ(cnpj) {
  cnpj = cnpj.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos

  if (cnpj.length !== 14) {
    return false;
  }

  // Verifica se todos os dígitos são iguais, o que não é permitido
  if (/^(\d)\1+$/.test(cnpj)) {
    return false;
  }

  // Calcula os dígitos verificadores
  let tamanho = cnpj.length - 2;
  let numeros = cnpj.substring(0, tamanho);
  let digitos = cnpj.substring(tamanho);
  let soma = 0;
  let pos = tamanho - 7;

  for (let i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2) {
      pos = 9;
    }
  }

  let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if (resultado != digitos.charAt(0)) {
    return false;
  }

  tamanho = tamanho + 1;
  numeros = cnpj.substring(0, tamanho);
  soma = 0;
  pos = tamanho - 7;

  for (let i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2) {
      pos = 9;
    }
  }

  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if (resultado != digitos.charAt(1)) {
    return false;
  }

  return true;
}

function buscarCep(valor) {
  let cep = valor.replace(/\D/g, '');
  let validacep = /^[0-9]{8}$/;

  if (validacep.test(cep)) {
    $.ajax({
      url: "https://viacep.com.br/ws/" + cep + "/json/",
      type: "GET",
      cache: false,
      dataType: "json",
      success: function (dados) {
        $("#estado").val(dados.uf);
        $("#cidade").val(dados.localidade);
        $("#bairro").val(dados.bairro);
        $("#rua").val(dados.logradouro);
      }
    });
  }
}

function buscarCidadeEstado(uf) {
  //https://servicodados.ibge.gov.br/api/docs/localidades
  let option = '<option value="">Cidade</option>';
  if (uf != "") {
    $.ajax({
      url: "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" + uf + "/distritos?orderBy=nome",
      type: "GET",
      cache: false,
      dataType: "json",
      beforeSend: function () {
        $(".cidadeBusca").html('<option value="">Carregando...</option>');
      },
      success: function (dados) {
        let codCidade = "";
        if (dados.length > 0) {
          $.each(dados, function (i, item) {
            option += '<option value="' + item.id + '">' + item.nome + '</option>';
            if (valorCidade != "" && valorCidade == item.nome) {
              codCidade = item.id;
            }
          });
        }
        $(".cidadeBusca").html(option);
        if (codCidade != "") {
          $(".cidadeBusca").val(codCidade).change();
        }
      }
    });
  }
}