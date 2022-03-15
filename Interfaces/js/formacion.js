function buscar() {
    var parametros = "&controlador=Formacion";
    parametros += "&metodo=buscar";
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
    buscar();
}


function insertar() {
    var parametros = '&controlador=Formacion';
    parametros += '&metodo=insertar';
    parametros += '&' + $('#formularioInsertar').serialize(); /*le pasamos todos los parametros del form al controlador*/
    $.ajax({
        url: 'C_Ajax.php', //donde
        type: 'post',    //tipo
        data: parametros, //que va a seleccionar
        success: function (registros) { //donde tengo que sacar los resultados
            
            if(registros=="error1"){
                window.alert("Producto ya existente. Por favor vuelve a rellenar los campos.")
            } else {
                window.alert ("Fila añadida");
                getVista('Formacion', 'getVistaFiltros');
            }
        }

    })
    
    
}

function checkearInsert() {
    let allAreFilled = true;
    document.getElementById("formularioInsertar").querySelectorAll("[required]").forEach(function(i) {
       if (!allAreFilled) return;
       if (!i.value) allAreFilled = false;
       
    })
    if (!allAreFilled) {
       alert('Rellene todos los campos');
    } else if(allAreFilled) {
     
        insertar(); 
 
    }
    
}


function editar(id_Producto){
    var parametros = '&controlador=Productos';
    parametros += '&metodo=Editar';
    parametros += '&id_Producto=' + id_Producto; //pasamos id en parametros
    $.ajax({
        url: 'C_Ajax.php', //donde
        type: 'post',    //tipo
        data: parametros, //que va a seleccionar
        success: function (vista) { //donde tengo que sacar los resultados
            $('#capaEdicion').html(vista);
            
        }

    })
}

function mostrarEditar(){
    document.getElementById("capaEdicion").style.visibility = "visible";
    $(window).scrollTop(1050);
}

function guardar() {
    var parametros = '&controlador=Productos';
    parametros += '&metodo=guardar';
    parametros += '&' + $('#formularioEditar').serialize(); /*le pasamos todos los parametros del form al controlador*/
    $.ajax({
        url: 'C_Ajax.php', //donde
        type: 'post',    //tipo
        data: parametros, //que va a seleccionar
        dataType: 'json',
        success: function (respuesta) { //donde tengo que sacar los resultados
        
            if(registros=="error1"){
                window.alert("Producto ya existente. Por favor vuelve a rellenar los campos.")
            } else {
                window.alert ("Fila editada");
                getVista('Productos', 'getVistaFiltros');
            }
        }
        
    })
}

function checkearGuardar() {
    let allAreFilled = true;
    document.getElementById("formularioEditar").querySelectorAll("[required]").forEach(function(i) {
       if (!allAreFilled) return;
       if (!i.value) allAreFilled = false;
       
    })
    if (!allAreFilled) {
       alert('Rellene todos los campos');
    } else if(allAreFilled) {
     
        guardar(); 
 
    }
    
}

function volver(){
    getVista('Productos', 'getVistaFiltros');
    buscar();
}


function getRowsNumber(){
    var parametros = "&controlador=Productos";
    parametros += "&metodo=getRowsNumber";
    parametros += "&" + $("#formularioBuscar").serialize();
    $.ajax({
      url: "C_Ajax.php",
      type: "post",
      data: parametros,
      success: function (vista) {
        $("#capaResultadosBusqueda").html(vista);
      },
    });
  }













/*
⠐⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠂
⠄⠄⣰⣾⣿⣿⣿⠿⠿⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣷⣆⠄⠄
⠄⠄⣿⣿⣿⡿⠋⠄⡀⣿⣿⣿⣿⣿⣿⣿⣿⠿⠛⠋⣉⣉⣉⡉⠙⠻⣿⣿⠄⠄
⠄⠄⣿⣿⣿⣇⠔⠈⣿⣿⣿⣿⣿⡿⠛⢉⣤⣶⣾⣿⣿⣿⣿⣿⣿⣦⡀⠹⠄⠄
⠄⠄⣿⣿⠃⠄⢠⣾⣿⣿⣿⠟⢁⣠⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡄⠄⠄
⠄⠄⣿⣿⣿⣿⣿⣿⣿⠟⢁⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣷⠄⠄
⠄⠄⣿⣿⣿⣿⣿⡟⠁⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠄⠄
⠄⠄⣿⣿⣿⣿⠋⢠⣾⣿⣿⣿⣿⣿⣿⡿⠿⠿⠿⠿⣿⣿⣿⣿⣿⣿⣿⣿⠄⠄
⠄⠄⣿⣿⡿⠁⣰⣿⣿⣿⣿⣿⣿⣿⣿⠗⠄⠄⠄⠄⣿⣿⣿⣿⣿⣿⣿⡟⠄⠄
⠄⠄⣿⡿⠁⣼⣿⣿⣿⣿⣿⣿⡿⠋⠄⠄⠄⣠⣄⢰⣿⣿⣿⣿⣿⣿⣿⠃⠄⠄
⠄⠄⡿⠁⣼⣿⣿⣿⣿⣿⣿⣿⡇⠄⢀⡴⠚⢿⣿⣿⣿⣿⣿⣿⣿⣿⡏⢠⠄⠄
⠄⠄⠃⢰⣿⣿⣿⣿⣿⣿⡿⣿⣿⠴⠋⠄⠄⢸⣿⣿⣿⣿⣿⣿⣿⡟⢀⣾⠄⠄
⠄⠄⢀⣿⣿⣿⣿⣿⣿⣿⠃⠈⠁⠄⠄⢀⣴⣿⣿⣿⣿⣿⣿⣿⡟⢀⣾⣿⠄⠄
⠄⠄⢸⣿⣿⣿⣿⣿⣿⣿⠄⠄⠄⠄⢶⣿⣿⣿⣿⣿⣿⣿⣿⠏⢀⣾⣿⣿⠄⠄
⠄⠄⣿⣿⣿⣿⣿⣿⣿⣷⣶⣶⣶⣶⣶⣿⣿⣿⣿⣿⣿⣿⠋⣠⣿⣿⣿⣿⠄⠄
⠄⠄⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⢁⣼⣿⣿⣿⣿⣿⠄⠄
⠄⠄⢻⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⢁⣴⣿⣿⣿⣿⣿⣿⣿⠄⠄
⠄⠄⠈⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠟⢁⣴⣿⣿⣿⣿⠗⠄⠄⣿⣿⠄⠄
⠄⠄⣆⠈⠻⢿⣿⣿⣿⣿⣿⣿⠿⠛⣉⣤⣾⣿⣿⣿⣿⣿⣇⠠⠺⣷⣿⣿⠄⠄
⠄⠄⣿⣿⣦⣄⣈⣉⣉⣉⣡⣤⣶⣿⣿⣿⣿⣿⣿⣿⣿⠉⠁⣀⣼⣿⣿⣿⠄⠄
⠄⠄⠻⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣶⣶⣾⣿⣿⡿⠟⠄⠄
⠠⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄

*/