<?php

require_once 'vistas/Vista.php';
require_once 'Models/Eventos/M_Eventos';
Class C_Eventos{

    private $modelo;
    public function __construct(){
        $this->modelo = new M_Eventos();
    }
    
    public function getVistaFiltros(){
        $categorias = $this->modelo->getCategorias();
        Vista::render('vistas/Eventos/V_Eventos_Filtros.php',$categorias);
    }

    public function getVistaInsertar(){
        $categorias = $this->modelo->getCategorias();
        Vista::render('vistas/Eventos/V_Eventos_Insertar.php',$categorias);
    }

    public function getVistaEditar(){
        $filas = $this->modelo->getCategorias();
        Vista::render('vistas/Eventos/V_Eventos_Editar.php',$filas);
    }

    public function buscar($filtros){
        $count = $this->modelo->getRowsNumber($filtros);
        $num_total_filas = $count['count(*)'];
        $filas = $this->modelo->buscar($filtros);
        Vista::render('vistas/Eventos/V_Eventos_Listado.php', $filas);
        Vista::render('vistas/Eventos/V_Eventos_Paginador.php', array('filtros' => $filtros, 'numTotal' => $num_total_filas));
    }

    public function insertar($registro){ /*le damos un valor a cada variable y vamos al modelo*/
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

    public function Editar($edicion){ /*le damos un valor a cada variable y vamos al modelo*/
        $id_Producto =  $edicion['id_Producto']; //en $edicion recibimos el unico valor del array que seria el ID
        //le pasamos el id de producto
        

        $filas = $this->modelo->buscar($edicion); //usamos la funcion de buscar pasandole el ID y lo almacenamos en filas
        Vista::render('vistas/Eventos/V_Eventos_Editar.php', $filas);
        /*echo json_encode($respuesta);*/
    }



    public function guardar($registro){ /*le damos un valor a cada variable y vamos al modelo*/
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

        /*echo json_encode($respuesta);*/
    }

/*

    public function editar($registro){ //le damos un valor a cada variable y vamos al modelo

        $registros = $this->modelo->getProducto($registro);

    }
*/

}


?>