function buscar() {
    var parametros = "&controlador=Voluntarios";
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
    var parametros = '&controlador=Productos';
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
                getVista('Productos', 'getVistaFiltros');
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


function guardar() {
    var parametros = '&controlador=Voluntarios';
    parametros += '&metodo=guardar';
    parametros += '&' + $('#formularioPerfil').serialize(); /*le pasamos todos los parametros del form al controlador*/
    $.ajax({
        url: 'C_Ajax.php', //donde
        type: 'post',    //tipo
        data: parametros, //que va a seleccionar
        success: function (respuesta) { //donde tengo que sacar los resultados
            
            
            $('#capaContenido').append(respuesta)
            setTimeout(function(){
                location.reload();
            },1000);
        }
        
    })
}

function cambiarContraseña() {
    var parametros = '&controlador=Voluntarios';
    parametros += '&metodo=cambiarContraseña';
    parametros += '&' + $('#formularioContrasena').serialize(); /*le pasamos todos los parametros del form al controlador*/
    $.ajax({
        url: 'C_Ajax.php', //donde
        type: 'post',    //tipo
        data: parametros, //que va a seleccionar
        success: function (respuesta) { //donde tengo que sacar los resultados
            
            
            $('#capaContenido').append(respuesta)
            
        }
        
    })
}


function guardarFoto() {
    var parametros = '&controlador=Voluntarios';
    parametros += '&metodo=guardar';
    parametros += '&fotoPerfil=' + $('#inputFoto').val(); /*le pasamos todos los parametros del form al controlador*/
    $.ajax({
        url: 'C_Ajax.php', //donde
        type: 'post',    //tipo
        data: parametros, //que va a seleccionar
        success: function (respuesta) { //donde tengo que sacar los resultados
            
            
            getVistaPerfil('Voluntarios', 'getVistaPerfil');
            setTimeout(function(){
                location.reload();
            },1500);
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