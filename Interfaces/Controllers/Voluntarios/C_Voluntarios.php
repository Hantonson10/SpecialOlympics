<?php

require_once 'Views/Vista.php';
require_once 'Models/Voluntarios/M_Voluntarios.php';
Class C_Voluntarios{

    private $modelo;
    public function __construct(){
        $this->modelo = new M_Voluntarios();
    }
    /* Mostramos la vista de filtros */
    public function getVistaFiltros(){
        Vista::render('Views/Voluntarios/V_Filtros_Voluntarios.php');
    }
    /* Mostramos la vista de insertar */
    public function getVistaInsertar(){
        /*$categorias = $this->modelo->getCategorias();*/
        Vista::render('Views/Voluntarios/V_Voluntarios_Insertar.php');
    }
    /* Mostramos la vista del perfil */
    public function getVistaPerfil(){
        $res = $this->modelo->getDatosPerfil($_SESSION['id']);
        Vista::render('Views/Voluntarios/V_Perfil_Voluntarios.php', $res);
    }
    /* Mostramos la vista de editar */
    public function getVistaEditar(){
        $filas = $this->modelo->getCategorias();
        Vista::render('Views/Voluntarios/V_Voluntarios_Editar.php',$filas);
    }
    /* Mostramos la vista del listado pasando los datos de los filtros */
    public function buscar($filtros){
        $filas = $this->modelo->buscar($filtros);
        Vista::render('Views/Voluntarios/V_Listado_Voluntarios.php', $filas);
    }

    public function login($filtros){
        $res = $this->modelo->login($filtros['email'],$filtros['password']);
        if(!empty($res)){
            $res = $res[0]['LOGIN'];
            echo $res; 
            $result = "[\"".md5($filtros['password'])."\", \"S\"]";
            echo $result;
            return (strcmp($res,$result)==0);
        } else {
            return false;
        }
    }

    public function getId($email){
        return $this->modelo->getId($email)['id'];
    }

    public function getNavData($id){
        return $this->modelo->getPicAndName($id);
    }

    public function guardar($registro){ //le damos un valor a cada variable y vamos al modelo
        

        $msg = $this->modelo->guardar($registro);
        Vista::render('Views/Voluntarios/V_ToastGuardar_Voluntarios.php',$msg);
        //echo json_encode($respuesta);
    }

    public function cambiarContraseña($registro){ //le damos un valor a cada variable y vamos al modelo
        

        $msg = $this->modelo->cambiarContraseña($registro);
        Vista::render('Views/Voluntarios/V_ToastGuardar_Voluntarios.php',$msg);
        //echo json_encode($respuesta);
    }


    /*  NO SE USA EN ESTE MODULO */
    /*
    public function insertar($registro){ //le damos un valor a cada variable y vamos al modelo
        $producto =  $registro['producto'];
        $descripcion = $registro['descripcion'];
        $factivo =  $registro['factivo'];
        $stock = $registro['stock'];
        $stock_Minimo = $registro['stock_Minimo'];
        $stock_Vendido = $registro['stock_Vendido'];
        $precio_Compra = $registro['precio_Compra'];
        $precio_Venta = $registro['precio_Venta'];
        $categoria = $registro['categoria'];
        

        $registros = $this->modelo->insertar($registro);

        echo $registros;
    }

    public function Editar($edicion){ //le damos un valor a cada variable y vamos al modelo
        $id_Producto =  $edicion['id_Producto']; //en $edicion recibimos el unico valor del array que seria el ID
        //le pasamos el id de producto
        

        $filas = $this->modelo->buscar($edicion); //usamos la funcion de buscar pasandole el ID y lo almacenamos en filas
        Vista::render('Views/Voluntarios/V_Voluntarios_Editar.php', $filas);
        //echo json_encode($respuesta);
    }



    
    */

/*

    public function editar($registro){ //le damos un valor a cada variable y vamos al modelo

        $registros = $this->modelo->getProducto($registro);

    }
*/

}


?>