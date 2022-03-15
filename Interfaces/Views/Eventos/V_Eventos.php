<script src="js/Eventos.js"></script>
<script type="text/javascript" src="js/Eventos.js"></script>
<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css">
<link rel="stylesheet" type="text/css" href="datatables/DataTables-1.11.3/css/datatables.bootstrap5.min.css">
<script type="text/javascript" charset="utf8" src="datatables/datatables.min.js"></script>

<!doctype html>
<html lang="en">
  <head>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
<title></title>
<style>
    table.dataTable thead {
        background: linear-gradient(to right, #000000, #000000);
        color:white;
    }
</style>  

</head>
<body>

<div class="container">
       <div class="row">
           <div class="col-lg-12">
            <table id="tablaEventos" class="table-striped table-bordered" style="width:100%">
                <thead class="text-center"> <!-- titulos tabla -->
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Estado</th>
                </thead>
                <tbody>
                    <?php
                        foreach($datos as $ind =>$fila){
                    ?>
                    <tr>
                        <td><?php echo $fila['producto']?></td>
                        <td><?php echo $fila['descripcion']?></td>
                        <td><?php echo $fila['stock']?></td>
                        <td><?php echo $fila['activo']?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
           </div>
       </div> 
    </div>
   
    

      
<!--    Datatables-->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  
      
      
<script>
$(document).ready(function() {
    $('#tablaEventos').DataTable({
     
        responsive: true,
        "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados.",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
                 },
                 "sProcessing":"Procesando...",
            },
        "ordering": false,
        "bFilter": false,
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "Todos"]
        ],
        "pageLength": 10
    });
});
</script>
      

</body>
</html>



<!--
<form role="form" id="formularioBuscar" name="formularioBuscar">
    <div id="div-busqueda"class="container">
        <div class="row">
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Producto/descripcion</label>
                <input type="text" id="texto" name="texto" class="form-control" placeholder="Buscar" value="" />
            </div>
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Activos</label>
                <select type="text" id="factivo" name="factivo" class="form-control" placeholder="Seleccionar">
                    <option value="">TODOS</option>
                    <option value="S">Activo</option>
                    <option value="N">No activo</option>
                </select>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-xs-3">
                <label for="texto">Stock Minimo</label>
                <input type="number" id="stock_Minimo" name="stock_Minimo" class="form-control" placeholder="Buscar" value="" />     
            </div>
            <div class="form-group col-lg-4 col-md-6 col-xs-6">
                <label for="texto">Categoria</label>
                <input type="number" id="categoria" name="categoria" class="form-control" placeholder="Buscar" value="" />
            </div>
            
        </div>

        <button type="button" class="btn btn-primary" onclick="buscar(1, $('#cantProduc').val());" style="margin-top:20px;">Buscar</button>
        <button type="button" class="btn btn-primary" onclick="limpiar();" style="margin-top:20px;">Limpiar filtros</button>
        <button type="button" class="btn btn-primary" onclick="addVistaInsertar('Productos', 'getVistaInsertar');" style="margin-top:20px;">Nuevo</button>
    </div>

</form>

-->

