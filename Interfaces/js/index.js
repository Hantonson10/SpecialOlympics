function getVistaFiltros(controlador, metodo){
    //el ajax sirve para hacer una peticion al servidor sin salirme de la pagina
    var parametros='&controlador='+controlador; //se usa el & para separar variables
    parametros+='&metodo='+metodo;
    $.ajax({
        url:'C_Ajax.php', //donde
        type:'post',    //tipo
        data: parametros, //que va a seleccionar
        success: function(vista){ //donde tengo que sacar los resultados
            $('#capaFiltros').html(vista);
        }

    })
}
function getVista(controlador, metodo){
    //el ajax sirve para hacer una peticion al servidor sin salirme de la pagina
    var parametros='&controlador='+controlador; //se usa el & para separar variables
    parametros+='&metodo='+metodo;
    $.ajax({
        url:'C_Ajax.php', //donde
        type:'post',    //tipo
        data: parametros, //que va a seleccionar
        success: function(vista){ //donde tengo que sacar los resultados
            $('#capaFiltros').html(vista);
        }

    })
}