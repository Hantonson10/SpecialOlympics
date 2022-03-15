function buscar(pagact, propag) {
    var parametros = "&controlador=Eventos";
    parametros += "&metodo=buscar";
    parametros += "&pagact="+pagact;
    parametros += "&propag="+propag;
    parametros += "&" + $("#formularioBuscar").serialize();
    $.ajax({
      url: "C_Ajax.php",
      type: "post",
      data: parametros,
      success: function (vista) {
        $("#capaResultado").html(vista);
      },
    });
  }

function limpiar() {
    $('#formularioBuscar')[0].reset();
    buscar(pagact, propag);
}

function volver(){
    getVista('Eventos', 'getVistaFiltros');
    buscar();
}