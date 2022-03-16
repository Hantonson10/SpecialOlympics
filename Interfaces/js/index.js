function getVistaFiltros(controlador, metodo){
    loader();
    //el ajax sirve para hacer una peticion al servidor sin salirme de la pagina
    var parametros='&controlador='+controlador; //se usa el & para separar variables
    parametros+='&metodo='+metodo;
    $('#capaContenido').html('<div class="shadow p-3 mb-5 bg-white rounded" id="capaFiltros"></div><div class="shadow p-3 mb-5 bg-white rounded" id="capaResultado"></div><div class="" id="footer"><div class="row"><img id="logoFooter" class="helper" src="./img/icons/logoSOwhite.png" width="100%" height="100%"></div></div>');
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
    loader();
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

function getVistaPerfil(controlador, metodo){
    loader();
    //el ajax sirve para hacer una peticion al servidor sin salirme de la pagina
    var parametros='&controlador='+controlador; //se usa el & para separar variables
    parametros+='&metodo='+metodo;
    $.ajax({
        url:'C_Ajax.php', //donde
        type:'post',    //tipo
        data: parametros, //que va a seleccionar
        success: function(vista){ //donde tengo que sacar los resultados
            $('#capaContenido').html(vista);
        }

    })
}