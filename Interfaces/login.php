<?php session_start();
    require_once './Controllers/Voluntarios/C_Voluntarios.php';
    if(isset ($_SESSION['id'])){
        header('Location: index.php');
    }
    
    if(isset($_POST['email']) && isset($_POST['password'])){
        $C_volun = new C_Voluntarios();
        if ($C_volun->login($_POST)){
            //Set $_SESSION['id'] con el id del voluntario
            $_SESSION['id'] = $C_volun->getId($_POST['email']);
            //desseteamos $_POST
            header('Location: index.php');
        } 
    }
?>

<!DOCTYPE HTML>

<head>

    <!--<link rel="manifest" href="manifest.json">-->
    <script src="./js/jquery-3.6.0.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/login.css">
    <script src="./js/login.js"></script>
    
    <!-- en el style.css sobreescribimos algunos de los atributos de diseño como el color de la side navbar (cambiado al color
    de la navbar de la pagina de specialolympicsaragon , y las letras a blanco para que quede mejor el contraste.-->

</head>

<body>
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col g-0">
                <div class="leftSide d-flex justify-content-center align-items-center">

                <img id="img1" src="./img/slider/photo1.jpg" width="100%" height="100%">


                </div>
            </div>
            <div class="col g-0">
                <div class="rightSide">
                <img id="logoBackgroundLogin"src="./img/icons/logoSOrender.png" width="100%" height="100%">
                <div id="loginForm" class="container py-5 h-100">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div class="card text-white" style="border-radius: 1rem; background-color: rgb(46, 48, 63);">
                            <div class="card-body p-5 text-center">

                                <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Rellene el formulario con su email y contraseña</p>
                                <form id="formularioLogin" action="login.php" method="post">
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="typeEmailX">Email</label>
                                        <input type="email" name="email" id="typeEmailX" class="form-control form-control-lg" />
                                        
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="typePasswordX">Password</label>
                                        <input type="password" name="password" id="typePasswordX" class="form-control form-control-lg" />
                                        
                                    </div>
                                </form>
                                

                                <button class="btn btn-outline-danger btn-lg px-5" type="submit" onclick="$('#formularioLogin').submit()">Login</button>


                                </div>



                            </div>
                            </div>
                        </div>
                        </div>
                </div>
                


                </div>
            </div>
        </div>
    </div>

</body>

</html>
