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

  function buscarInfo() {
    var parametros = "&controlador=Voluntarios";
    parametros += "&metodo=buscarInfo";
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
    var parametros = '&controlador=Voluntarios';
    parametros += '&metodo=insertar';
    parametros += '&' + $('#formularioInsertar').serialize(); /*le pasamos todos los parametros del form al controlador*/
    $.ajax({
        url: 'C_Ajax.php', //donde
        type: 'post',    //tipo
        data: parametros, //que va a seleccionar
        success: function (registros) { //donde tengo que sacar los resultados
            
            if(registros=="error1"){
                window.alert("voluntario ya existente. Por favor vuelve a rellenar los campos.")
            } else {
                window.alert ("Fila añadida");
                getVista('Voluntarios', 'getVistaFiltros');
            }
        }

    })
}
      
function addDoc($id) {
    //alert("Insertar nuevo documento");
    $('#i_file-input-'+$id).html('<i class="fas fa-sync fa-spin"></i>');
    var fd = new FormData();
    var files = $('#file-input-'+$id)[0].files[0];
    fd.append('file', files);

    var param = "&controlador=Voluntarios" +
        "&metodo=addDoc" +
        "&id=" + $id;

    $.ajax({
        url: 'upload.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function (location) {
            if (location != 0) {
                //alert('file uploaded');
                param += "&location="+location;
                $.ajax({
                    url: 'C_Ajax.php', //donde
                    type: 'post',    //tipo
                    data: param, //que va a seleccionar
                    success: function (response) { 
                        if(response != -1){ //Insertado
                            //Update No aportado a Aportado y la imagen al tick verde
                            alert("database modified");
                            $('#status-' + $id).html('Aportado');
                            $('#icon-'+$id).html('<img src="./img/icons/check_green.png" alt="añadir" width="30" height="30">');
                            $('#doc-link-'+$id).attr('href', location);
                        } else {
                            alert("Error");
                            $('#i_file-input-'+$id).html('<img src=\"./img/icons/add-file--v2.png\" />');
                        }
                    }

                })
            }
            else {
                alert('Error. Vuelva a intentarlo');
            }
        },
    });
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


function infoVoluntario(voluntario_id){
    var parametros = '&controlador=Voluntarios';
    parametros += '&metodo=getVistaFiltrosInfo';
    parametros += '&voluntario_id=' + voluntario_id; //pasamos id en parametros
    $.ajax({
        url: 'C_Ajax.php', //donde
        type: 'post',    //tipo
        data: parametros, //que va a seleccionar
        success: function (vista) { //donde tengo que sacar los resultados
            $('#capaFiltros').html(vista);
            //getVista('Voluntarios', 'getVistaFiltrosInfo');
            console.log(voluntario_id);
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