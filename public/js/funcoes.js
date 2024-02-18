function validarFormulario(idForm,validarClasse) {
    let camposValidados = true;
    let countFoco = 0;
    $("form[name='"+ idForm +"'] ."+ validarClasse).each(function () {
      if ($(this).val() == "") {
        if (!$(this).hasClass("arquivos")) {
          $(this).addClass("border-red-500");
          $(this).addClass("bg-red-50");
          $(this).removeClass("border-green-500");
          $(this).next("p").fadeIn(0);
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
          $(this).next("p").fadeOut(0);
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