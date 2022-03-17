<?php

$tallas = array(
    0 => array('nombre' => 'XS'),
    1 => array('nombre' => 'S'),
    2 => array('nombre' => 'M'),
    3 => array('nombre' => 'L'),
    4 => array('nombre' => 'XL'),
    5 => array('nombre' => 'XXL')
);
$docs = $datos['docs'];
?>

<script src="./js/voluntarios.js"></script>
<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css">
<link rel="stylesheet" type="text/css" href="datatables/DataTables-1.11.3/css/datatables.bootstrap5.min.css">
<script type="text/javascript" charset="utf8" src="datatables/datatables.min.js"></script>
<link rel="stylesheet" href="./css/tablas.css">

<style>
    table.dataTable thead {
        background: linear-gradient(to right, #000000, #000000);
        color: white;
    }

    dataTable.oPaginate {
        color: black;
    }
</style>

<style>
    .image-upload>input {
        display: none;
    }

    .image-upload img {
        width: 30px;
        height: 30px;
        cursor: pointer;
    }
</style>


<div class="container-xl px-4 mt-4">
    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Foto de Perfil</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img width="300" height="300" class="rounded-circle" style="object-fit: cover;" src="<?php echo $datos['usuario']['voluntario_foto']; ?>" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">Copie la dirección de su foto de perfil</div>
                    <!-- Profile picture upload button-->
                    <div class="col-md-12" style="padding-bottom: 10px;">
                        <input class="form-control" id="inputFoto" type="text" placeholder="Dirección de la imagen" value="<?php echo $datos['usuario']['voluntario_foto']; ?>">
                    </div>
                    <button class="btn btn-primary" type="button" onclick="guardarFoto()">Subir Imagen</button>
                </div>
            </div>

            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Cambiar Contraseña</div>
                <div class="card-body">
                    <form id="formularioContrasena">
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstPassword">Nueva Contraseña</label>
                                <input class="form-control disable" id="inputFirstName" name="inputFirstPassword" type="password" placeholder="Escriba su nueva contraseña" value="">
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputConfirmPassword">Repetir Contraseña</label>
                                <input class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" type="password" placeholder="Repita su contraseña" value="">
                            </div>
                        </div>

                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="button" onclick="cambiarContraseña()">Cambiar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Detalles de Voluntario</div>
                <div class="card-body">
                    <form id="formularioPerfil">
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">Nombre</label>
                                <input class="form-control disable" id="inputFirstName" name="nombre" type="text" placeholder="Escriba su nombre" value="<?php echo $datos['usuario']['voluntario_nombre']; ?>" disabled>
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName">Apellidos</label>
                                <input class="form-control" id="inputLastName" name="apellido" type="text" placeholder="Escriba sus apellidos" value="<?php echo $datos['usuario']['voluntario_apellidos']; ?>" disabled>
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (telefono name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPhone">Telefono</label>
                                <input class="form-control" id="inputPhone" name="telefono" type="text" placeholder="Escriba su telefono movil" value="<?php echo $datos['usuario']['voluntario_tel1']; ?>">
                            </div>
                            <!-- Form Group (location)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputDni">DNI</label>
                                <input class="form-control" id="inputDni" name="dni" type="text" placeholder="Escriba su DNI" value="<?php echo $datos['usuario']['voluntario_dni']; ?>" disabled>
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="row gx-3 mb-3">
                            <div class="col-md-9">
                                <label class="small mb-1" for="inputEmailAddress">Dirección de correo</label>
                                <input class="form-control" id="inputEmailAddress" name="email" type="email" placeholder="Escriba su email" value="<?php echo $datos['usuario']['voluntario_mail']; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="small mb-1" for="inputSize">Talla</label>
                                <select class="form-control" id="inputSize" name="talla" type="text" placeholder="Escriba su talla" value="<?php echo $datos['usuario']['voluntario_tall_camiseta']; ?>">

                                    <?php
                                    foreach ($tallas as $ind => $talla) {
                                        $option = "<option value=\"" . $talla['nombre'] . "\" ";
                                        if ($talla['nombre'] == $datos['usuario']['voluntario_tall_camiseta'])
                                            $option .= "selected";
                                        $option .= ">" . $talla['nombre'] . "</option>";
                                        echo $option;
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (phone number)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputAdress">Dirección</label>
                                <input class="form-control" id="inputAdress" name="direccion" type="tel" placeholder="Enter your phone number" value="<?php echo $datos['usuario']['voluntario_direccion']; ?>">
                            </div>
                            <!-- Form Group (birthday)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPostal">Código Postal</label>
                                <input class="form-control" id="inputPostal" name="codPostal" type="text" name="Codigo Postal" placeholder="Escriba su codigo postal" value="<?php echo $datos['usuario']['voluntario_cpostal']; ?>">
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="button" onclick="guardar()">Guardar Cambios</button>
                    </form>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Lista de documentos</div>
                <div class="card-body text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="tablaVoluntarios" class="table-striped table-bordered" style="width:100%">
                                    <thead class="text-center">
                                        <!-- titulos tabla -->
                                        <th></th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($docs as $ind => $fila) {
                                        ?>
                                            <tr>
                                                <!-- datos que va a mostrar style=""-->
                                                <td id="<?php echo "icon-".$fila['documento_id']; ?>">
                                                    <?php if (empty($fila['documento_url'])) { ?>
                                                        <form action="upload.php">
                                                            <div class="image-upload">
                                                                <label for="<?php echo "file-input-".$fila['documento_id'];?>" id="<?php echo "i_file-input-".$fila['documento_id'];?>">
                                                                    <img src="./img/icons/add-file--v2.png" />
                                                                </label>

                                                                <input id="<?php echo "file-input-".$fila['documento_id'];?>" type="file" accept=".pdf" onchange="addDoc(<?php echo $fila['documento_id']; ?>);e.preventDefault();" />
                                                                <input type="submit">
                                                            </div>
                                                        </form>
                                                    <?php } else { ?>
                                                        <img src="./img/icons/check_green.png" alt="añadir" width="30" height="30">
                                                    <?php } ?>
                                                </td>
                                                <td><a id="<?php echo "doc-link-".$fila['documento_id'];?>" href="<?php if (!empty($fila['documento_url'])) echo $fila['documento_url'];
                                                                else echo "#"; ?>" style="color: black !important;"><?php echo $fila['documento_tipo_nombre'] ?></a></td>
                                                <td id="status-<?php echo $fila['documento_id'];?>"><?php if (empty($fila['documento_url'])) echo "No aportado";
                                                    else echo "Aportado"; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--    Datatables-->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>

<!-- configuración de la tabla con datatables, donde se configura tambien el paginador -->
<script>
    $(document).ready(function() {
        $('#tablaVoluntarios').DataTable({

            responsive: true,
            /*
            scrollX: true,
            scrollY: 700,
            scrollCollapse: true,
            columnDefs: [
                {
                    targets:[],
                    ordenable: true,
                    render: function (data, type, full) {
                        return '<a href="Interfaces/login.php">'
                    }
                }
            ],
            */
            language: {
                lengthMenu: "Mostrar _MENU_ registros",
                zeroRecords: "No se encontraron resultados.",
                info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                sSearch: "Buscar:",
                oPaginate: {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "sProcessing": "Procesando...",
            },
            ordering: false,
            lengthChange: false,
            bFilter: false,
            lengthMenu: [
                [5],
                [5]
            ],
            pageLength: 5

        });
    });
</script>