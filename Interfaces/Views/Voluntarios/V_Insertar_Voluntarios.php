<?php

$tallas = array(
    0=>array('nombre'=>'XS'), 
    1=>array('nombre'=>'S'), 
    2=>array('nombre'=>'M'), 
    3=>array('nombre'=>'L'), 
    4=>array('nombre'=>'XL'), 
    5=>array('nombre'=>'XXL')
);

?>


<div class="tituloFiltros">
    <h1 class="tituloFiltrosContent">Insertar - Voluntarios</h1>
</div>
<script src="./js/voluntarios.js"></script>
<form role="form" id="formularioInsertar" name="formularioInsertar">
    <div id="div-busqueda" class="container">
        <div class="row">
            <!-- buscamos por nombre -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" value="" required/>
            </div>
            <!-- buscamos por apellido -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellido" value="" required/>
            </div>
            <!-- buscamos por tel1 -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Telefono 1</label>
                <input type="text" id="tel1" name="tel1" class="form-control" placeholder="tel1" value="" required/>
            </div>
            <!-- buscamos por tel2 -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Telefono 2</label>
                <input type="text" id="tel2" name="tel2" class="form-control" placeholder="tel2" value="" />
            </div>

            <!-- buscamos por telefono emergencia -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Telefono Emergencia</label>
                <input type="text" id="telEmer" name="telEmer" class="form-control" placeholder="telEmer" value="" required/>
            </div>
            <!-- buscamos por fecha alta -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <!-- Date input -->
                <label class="control-label" for="date">Fecha Alta</label>
                <input class="form-control" id="date" name="fechaAlta" placeholder="MM/DD/YYY" type="date" required/>
            </div>
            <!-- buscamos por fecha nacimiento -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <!-- Date input -->
                <label class="control-label" for="date">Fecha Nacimiento</label>
                <input class="form-control" id="date" name="fechaNacimiento" placeholder="MM/DD/YYY" type="date" required/>
            </div>
            <!-- buscamos por DNI -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">DNI</label>
                <input type="text" id="DNI" name="DNI" class="form-control" placeholder="DNI" value="" required/>
            </div>
            <!-- buscamos por Email -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Email</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="" required/>
            </div>
            <!-- buscamos por Ocupacion -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Ocupacion</label>
                <input type="text" id="ocupacion" name="ocupacion" class="form-control" placeholder="ocupacion" value="" required/>
            </div>
            <!-- buscamos por Hobbies -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Hobbies</label>
                <input type="text" id="hobbies" name="hobbies" class="form-control" placeholder="hobbies" value="" />
            </div>
            <!-- buscamos por dirección -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Dirección</label>
                <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección" value="" required/>
            </div>
            <!-- buscamos por Codigo Postal -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Código Postal</label>
                <input type="text" id="cod_postal" name="cod_postal" class="form-control" placeholder="Código Postal" value="" required/>
            </div>

            <!-- buscamos por talla camiseta -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="inputSize">Talla</label>
                <select class="form-control" id="inputSize" name="talla" type="text" placeholder="Escriba su talla" value="<?php echo $datos['voluntario_tall_camiseta']; ?>" required>

                    <?php
                    foreach ($tallas as $ind => $talla) {
                        $option = "<option value=\"" . $talla['nombre'] . "\" ";
                        if ($talla['nombre'] == $datos['voluntario_tall_camiseta'])
                            $option .= "selected";
                        $option .= ">" . $talla['nombre'] . "</option>";
                        echo $option;
                    }
                    ?>
                </select>
            </div>

            <!-- buscamos por talla pie -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Talla Pie</label>
                <input type="text" id="tallaPie" name="tallaPie" class="form-control" placeholder="talla Pie" value="" required/>
            </div>
            <!-- buscamos por talla pantalon -->
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Talla Pantalon</label>
                <input type="text" id="tallaPantalon" name="tallaPantalon" class="form-control" placeholder="talla Pantalon" value="" required/>
            </div>
        </div>
        <!-- Boton para buscar -->
        <button type="button" class="btn btn-primary" onclick="checkearInsert();" style="margin-top:20px;">Crear</button>
        <!-- Boton para limpiar filtros -->
        <button type="button" class="btn btn-primary" onclick="limpiar();" style="margin-top:20px;">Limpiar filtros</button>

        <button type="button" class="btn btn-primary" onclick="getVista('Material', 'getVistaFiltros');" style="margin-top:20px;">Filtros</button>
    </div>

</form>

<script type="text/javascript">
    var onLoadPage = (function() {
        var executed = false;
        return function() {
            if (!executed) {
                executed = true;
                buscar();
            }
        };
    })();

    onLoadPage();
    onLoadPage();
</script>