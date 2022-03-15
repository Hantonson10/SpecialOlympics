<?php

require_once 'Views/Vista.php';
require_once 'Models/Formacion/M_Formacion.php';
Class C_Formacion{

    private $modelo;
    public function __construct(){
        $this->modelo = new M_Formacion();
    }
    /* Mostramos la vista de filtros */
    public function getVistaFiltros(){
        Vista::render('Views/Formacion/V_Filtros_Formacion.php');
    }
    /* Mostramos la vista de insertar */
    public function getVistaInsertar(){
        /*$categorias = $this->modelo->getCategorias();*/
        Vista::render('Views/Formacion/V_Insertar_Formacion.php');
    }
    /* Mostramos la vista de editar */
    public function getVistaEditar(){
        //$filas = $this->modelo->getCategorias();
    Vista::render('Views/Formacion/V_Formacion_Editar.php'/*,$filas*/);
    }
    /* Mostramos la vista del listado pasando los datos de los filtros */
    public function buscar($filtros){
        $filas = $this->modelo->buscar($filtros);
        Vista::render('Views/Formacion/V_Listado_Formacion.php', $filas);
    }


    /*  NO SE USA EN ESTE MODULO */
    
    public function insertar($registro){ //le damos un valor a cada variable y vamos al modelo
        $nombre =  $registro['nombre'];
        $descripcion = $registro['descripcion'];
        $horas =  $registro['horas'];
        $entidad = $registro['entidad'];
        

        $registros = $this->modelo->insertar($registro);

        echo $registros;
    }
    /*
    public function Editar($edicion){ //le damos un valor a cada variable y vamos al modelo
        $id_Producto =  $edicion['id_Producto']; //en $edicion recibimos el unico valor del array que seria el ID
        //le pasamos el id de producto
        

        $filas = $this->modelo->buscar($edicion); //usamos la funcion de buscar pasandole el ID y lo almacenamos en filas
        Vista::render('Views/Formacion/V_Formacion_Editar.php', $filas);
        //echo json_encode($respuesta);
    }



    public function guardar($registro){ //le damos un valor a cada variable y vamos al modelo
        $id_Producto =  $registro['id_Producto'];
        $producto =  $registro['producto'];
        $descripcion = $registro['descripcion'];
        $factivo =  $registro['factivo'];
        $stock = $registro['stock'];
        $stock_Minimo = $registro['stock_Minimo'];
        $stock_Vendido = $registro['stock_Vendido'];
        $precio_Compra = $registro['precio_Compra'];
        $precio_Venta = $registro['precio_Venta'];
        $categoria = $registro['categoria'];
        

        $filas = $this->modelo->guardar($registro);

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