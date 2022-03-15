<?php session_start();

?>

<!DOCTYPE HTML>

<head>

    <!--<link rel="manifest" href="manifest.json">-->
    <script src="js/jquery-3.6.0.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/index.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
    
    <!-- en el style.css sobreescribimos algunos de los atributos de diseño como el color de la side navbar (cambiado al color
    de la navbar de la pagina de specialolympicsaragon , y las letras a blanco para que quede mejor el contraste.-->

</head>

<body>
    <div class="container-fluid">
        <div class="row flex-wrap">
            <div id="navbarColum" class="col-auto col-md-3 col-xl-2 px-sm-2 px-0">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="http://specialolympicsaragon.es/">
                        <img src="img/icons/logoSOwhite.png" class="mx-auto d-block d-flex align-items-center pb-3 mb-md-0 me-md-auto"
                        style="width:60%;height:60%;"> <!-- ajustamos el tamaño del logo, modificar ambos % a la vez.-->
                    </a>
                    
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
<!-- -------------------------------------------------------------------- -->
                        <li class="nav-item">
                            <a id="#navEventos" href="#" onclick="cargaFiltros()" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Eventos</span>
                            </a>
                        </li>

<!-- Con este fragmento de arriba podemos crear tantos items como queramos -->

                        <li>
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Campeonatos</span></a>
                            <ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">2016</span></a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">2017</span></a>
                                </li>
                            </ul>
                        </li>


<!-- Con este fragmento de arriba podemos crear item con desplegable -->
                        <li>
                            <a href="#" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Voluntarios</span></a>
                        </li>

                        <li>
                            <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                                <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Campus</span></a>
                            <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Rio Ebro</span></a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Huesca Libre</span></a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Sedes</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 1</a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 2</a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 3</a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 4</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Zona admin</span> </a>
                        </li>

                    </ul>
                    <hr>
                    <!-- zona de usuario donde le pasaremos su foto y nombre. -->
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1">loser</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            
            <div class="col py-3 flex-column" id="capaContenido"> <!-- capa derecha de la pantalla donde se muestran filtros y resultados -->
                <div class="shadow p-3 mb-5 bg-white rounded" id="capaFiltros"> <!-- filtros -->







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
                        <!-- <div class="form-group col-lg-4 col-md-6 col-xs-6">
                            <label for="texto">Categoria</label>
                            <input type="number" id="categoria" name="categoria" class="form-control" placeholder="Buscar" value="" />
                        </div> -->
                        
                    </div>

                    <button type="button" class="btn btn-primary" onclick="buscar(1, $('#cantProduc').val());" style="margin-top:20px;">Buscar</button>
                    <button type="button" class="btn btn-primary" onclick="limpiar();" style="margin-top:20px;">Limpiar filtros</button>
                    <button type="button" class="btn btn-primary" onclick="addVistaInsertar('Productos', 'getVistaInsertar');" style="margin-top:20px;">Nuevo</button>
                </div>

            </form>


                </div>
                <div class="shadow p-3 mb-5 bg-white rounded" id="capaResultado">jiji</div> <!-- capa para mostrar tabla de resultados -->
                    <div class="container-fluid" id="resultContent">
                        
                    
                    </div>
                <footer class="container-fluid" id="footer">jiji</footer> <!-- pues el footer nose -->
                <!-- contenido a mostrar-->
            </div>
        </div>
    </div>

</body>

</html>

<script>
function cargaFiltros(){
    document.getElementById("capaFiltros").innerHTML='<object type="text/html" data="V_Eventos.php" ></object>';

}
</script>

<script>
    $(document).ready(function(){
        $('#tablaEventos').DataTable();
    });
</script>