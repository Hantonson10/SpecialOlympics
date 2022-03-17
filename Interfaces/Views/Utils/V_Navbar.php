<link rel="stylesheet" href="./css/nav.css">


<div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100" id="nav">
                    <a href="http://specialolympicsaragon.es/" class="nav-a">
                        <img src="img/icons/logoSOwhite.png" class="mx-auto d-block d-flex align-items-center pb-3 mb-md-0 me-md-auto"
                        style="width:60%;height:60%;"> <!-- ajustamos el tamaño del logo, modificar ambos % a la vez.-->
                    </a>
                    
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
<!-- -------------------------------------------------------------------- -->
                     <!--   <li class="nav-item">
                            <a id="#navEventos" onclick="getVistaFiltros()" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Eventos</span>
                            </a>
                        </li>-->

<!-- Con este fragmento de arriba podemos crear tantos items como queramos

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
-->


<!-- Con este fragmento de arriba podemos crear item con desplegable -->
                        <li>
                            <a href="#" class="nav-link px-0 align-middle" style="color: white !important;">
                                <i class="fa fa-users"></i> <span class="ms-1 d-none d-sm-inline" onclick="getVistaFiltros('Voluntarios', 'getVistaFiltros');">Voluntarios</span></a>
                        </li>

                        <li>
                            <a href="#" class="nav-link px-0 align-middle" style="color: white !important;">
                                <i class="fas fa-graduation-cap"></i> <span class="ms-1 d-none d-sm-inline" onclick="getVistaFiltros('Formacion', 'getVistaFiltros');">Formacion</span></a>
                        </li>

                        <li>
                            <a href="#" class="nav-link px-0 align-middle" style="color: white !important;">
                            <i class="fas fa-table-tennis"></i> <span class="ms-1 d-none d-sm-inline" onclick="getVistaFiltros('Material', 'getVistaFiltros');">Materiales</span></a>
                        </li>

                        <li>
                            <a href="#" class="nav-link px-0 align-middle" style="color: white !important;">
                            <i class="fas fa-running"></i> <span class="ms-1 d-none d-sm-inline" onclick="getVistaFiltros('Actividad', 'getVistaFiltros');">Actividades</span></a>
                        </li>
                    <!--
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
-->
                        

                    </ul>
                    <hr>
                    <!-- zona de usuario donde le pasaremos su foto y nombre.  https://github.com/mdo.png-->
                    <div class="dropdown pb-4">
                        <a href="#" style="color: white !important;" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo $datos['User']['pic'];?>" alt="hugenerd" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1"><?php echo $datos['User']['name'];?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" id="dropDrownNav">
                            <li class="profileDropdown"><a style="color: white !important;" class="dropdown-item" onclick="getVistaPerfil('Voluntarios', 'getVistaPerfil');">Perfil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="profileDropdown"><a style="color: white !important;" class="dropdown-item" href="logout.php">Cerrar Sesion</a></li>
                        </ul>
                    </div>
                </div>
            </div>