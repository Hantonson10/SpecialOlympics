<script src=".js/voluntarios.js"></script>
<script type="text/javascript" src="js/Voluntarios.js"></script>
<link rel="stylesheet" type="text/css" href="datatables/datatables.min.css">
<link rel="stylesheet" type="text/css" href="datatables/DataTables-1.11.3/css/datatables.bootstrap5.min.css">
<script type="text/javascript" charset="utf8" src="datatables/datatables.min.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<!doctype html>
<html lang="en">
  <head>
  <link rel="stylesheet" href="./css/tablas.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
<title></title>

</head>
<body>
<!-- Creamos la tabla con datatables -->
<div class="container">
       <div class="row">
           <div class="col-lg-12">
            <table id="tablaVoluntariosInfo" class="table-striped table-bordered display" style="width:100%">
                <thead class="text-center"> <!-- titulos tabla -->
                    <th>funcion</th>
                    <th>lugar</th>
                    <th>fecha</th>
        

                </thead>
                <tbody>
                    <?php
                        foreach($datos as $ind =>$fila){
                    ?>
                    <tr> <!-- datos que va a mostrar -->
                        <td><?php echo $fila['participar_funcion']?></td>
                        <td><?php echo $fila['actividad_lugar']?></td>
                        <td><?php echo $fila['actividad_fecha']?></td>
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
      
 <!-- configuración de la tabla con datatables, donde se configura tambien el paginador -->     
 <script>
$(document).ready(function() {
    $('#tablaVoluntariosInfo').DataTable({
     
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
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
                 },
                 "sProcessing":"Procesando...",
            },
        ordering: false,
        bFilter: false,
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "Todos"]
        ],
        pageLength: 10
        
    });
});
</script>
      

</body>
</html>