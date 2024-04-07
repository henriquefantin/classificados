$(document).ready(function() {
  $("#divSanduicheNavbar").click(function() {
    if ($("#navbarConteudo").is(":hidden")) {
      $("#navbarConteudo").fadeIn(200);
    } else {
      $("#navbarConteudo").fadeOut(200);
    }
  });
});

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
          $("#"+componente.id).next("p").fadeOut(0);
        } else {
          $("#"+componente.id).next("p").fadeIn(0);
          $("#"+componente.id).val("");
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

var teste;
function buscarCep(valor) {
  let cep = valor.replace(/\D/g, '');
  let validacep = /^[0-9]{8}$/;

  if (validacep.test(cep)) {
    $.ajax({
      url: "https://viacep.com.br/ws/"+cep+"/json/",
      type: "GET",
      cache: false,
      dataType: "json",
      success: function(dados) {
        $("#estado").val(dados.uf);
        $("#cidade").val(dados.localidade);
        $("#bairro").val(dados.bairro);
        $("#rua").val(dados.logradouro);
      }
    });
  }
}