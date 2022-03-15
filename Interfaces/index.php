<?php session_start();

?>

<!DOCTYPE HTML>

<head>

    <!--<link rel="manifest" href="manifest.json">-->
    <script src="./js/jquery-3.6.0.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/index.js"></script>
    <script src="./js/voluntarios.js"></script>
    <script src="./js/formacion.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
    
    <!-- en el style.css sobreescribimos algunos de los atributos de diseño como el color de la side navbar (cambiado al color
    de la navbar de la pagina de specialolympicsaragon , y las letras a blanco para que quede mejor el contraste.-->

</head>

<body>
    <div class="container-fluid">
        <div class="row flex-wrap">
            <div id="navbarColum" class="col-auto col-md-3 col-xl-2 px-sm-2 px-0">

            <?php
                
            require_once 'Controllers/C_Menus.php';
            $menu=new C_Menus();
            $menu->getMenu();
            
            /*
            include 'vistas/Menus/V_Menu_Html.php';*/
            ?>



                
            
            
            <div class="col py-3 flex-column" id="capaContenido"> <!-- capa derecha de la pantalla donde se muestran filtros y resultados -->
                <div class="shadow p-3 mb-5 bg-white rounded" id="capaFiltros"> <!-- filtros -->

                </div>
                <div class="shadow p-3 mb-5 bg-white rounded" id="capaResultado"></div> <!-- capa para mostrar tabla de resultados -->

                <div class="" id="footer">
                    <div class="row">
                        <img id="logoFooter" class="helper" src="./img/icons/logoSOwhite.png" width="100%" height="100%">
                    </div>


                </div>


            <!-- FOOTER -->
                
            </div>
            
        </div>
    </div>

</body>

</html>
