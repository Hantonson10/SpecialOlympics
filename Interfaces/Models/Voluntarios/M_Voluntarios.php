<?php

require_once 'Models/DAO.php';

class M_Voluntarios{

    private $DAO;

    public function __construct(){
        $this->DAO = new DAO();

    }

    /*
    public function getProducto(){

        $texto='';
        $factivo='';
        $stock_Minimo='';
        $categoria='';
        extract($filtros);

        // igual que en buscar, le pedimos los datos por id y luego los visualizamos en la vista

        $SQL="SELECT id_Producto FROM `Voluntarios`";
        $res= $this->DAO->consultar($SQL);
        return $res;
    }
    */

    public function getCategorias(){
        $SQL="SELECT id_ProductoCategoria, productoCategoria FROM `Voluntarioscategorias`";
        $res= $this->DAO->consultar($SQL);
        return $res;
    }

    public function buscar($filtros=array()){
        $voluntario_id='';
        $nombre='';
        $apellido='';
        $DNI='';
        $email='';
        $direccion='';
        $DNI='';
        $cod_postal='';
        $rangoFechaAlta='';

        extract($filtros);

        $SQL="SELECT * FROM voluntario WHERE 1=1 "; //poniendo el 1=1 hacemos que la primera condicion sea nula, y la siguiente tenga que empezar por and u OR
        
        /*if($texto!=''){
            //$SQL.= " AND producto LIKE '%$texto%'"; //cualquiera de las dos me sirve
            $SQL.= " AND producto LIKE '%".$texto."%'";
        }*/


        /* BUSCAMOS POR EL NOMBRE DEL VOLUNTARIO */
        if($nombre!=''){
            $lista=explode(' ',$nombre);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR voluntario_nombre like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }
        /* BUSCAMOS POR EL APELLIDO DEL VOLUNTARIO */
        if($apellido!=''){
            $lista=explode(' ',$apellido);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR voluntario_apellidos like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }
        /* BUSCAMOS POR EL DNI DEL VOLUNTARIO */
        if($DNI!=''){
            $lista=explode(' ',$DNI);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR voluntario_dni like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }

        /* BUSCAMOS POR EL EMAIL DEL VOLUNTARIO */
        if($email!=''){
            $lista=explode(' ',$email);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR voluntario_mail like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }

        /* BUSCAMOS POR EL DIRECCION DEL VOLUNTARIO */
        if($direccion!=''){
            $lista=explode(' ',$direccion);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR voluntario_direccion like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }

        /* BUSCAMOS POR EL CODIGO POSTAL DEL VOLUNTARIO */
        if($cod_postal!=''){
            $lista=explode(' ',$cod_postal);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR voluntario_cpostal like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }


        if($voluntario_id!=''){
            $SQL.=" AND voluntario_id = '$voluntario_id' )"; //filtramos por id
        }

        
        $res= $this->DAO->consultar($SQL);
        return $res;
    }

    
    public function insertar($registro=array()){
        /*declaramos variables vacias de SQL y las insertamos*/
        $producto = '';
        $descripcion = '';
        $factivo = '';
        $stock ='';
        $stock_Minimo = '';
        $stock_Vendido = '';
        $precio_Compra ='';
        $precio_Venta = '';
        $categoria = '';
        extract($registro);

        $CHECK= "SELECT id_Producto from Voluntarios WHERE producto= '$producto' ";
        $resultadoConsulta = $this->DAO->consultar($CHECK);
        if (!empty($resultadoConsulta)){
            return "error1";
        }

        $SQL="INSERT INTO Voluntarios (producto, descripcion, activo, stock, stock_Minimo, Stock_Vendido, precio_Compra, precio_Venta, id_categoria)
        VALUES ('$producto', '$descripcion','$factivo','$stock','$stock_Minimo','$stock_Vendido','$precio_Compra','$precio_Venta','$categoria')";
        $res= $this->DAO->insertar($SQL);
        
        //$SQL="INSERT INTO Voluntarios (producto, descripcion, id_Categoria, stock, precio_Compra, precio_Venta,stock_Vendido,stock_Minimo,activo) ";
        return $res;
        echo $res;
    }



public function guardar($registro=array()){
    /*declaramos variables vacias de SQL y las insertamos*/
    $id_Producto = '';
    $producto = '';
    $descripcion = '';
    
    $factivo = '';
    $stock ='';
    $stock_Minimo = '';
    $stock_Vendido = '';
    $precio_Compra ='';
    $precio_Venta = '';
    $categoria = '';
    extract($registro);
    //$SQL="INSERT INTO Voluntarios (producto, descripcion, id_Categoria, stock, precio_Compra, precio_Venta,stock_Vendido,stock_Minimo,activo) ";
    /*$SQL="UPDATE Voluntarios (producto, descripcion, activo, stock, stock_Minimo, Stock_Vendido, precio_Compra, precio_Venta, id_categoria)
    VALUES ('$producto', '$descripcion','$factivo','$stock','$stock_Minimo','$stock_Vendido','$precio_Compra','$precio_Venta','$categoria')
    WHERE (id_Producto = $id_Producto)";*/

    $CHECK= "SELECT id_Producto from Voluntarios WHERE producto= '$producto' ";
        $resultadoConsulta = $this->DAO->consultar($CHECK);
        if (!empty($resultadoConsulta) && $resultadoConsulta[0]['id_Producto'] != $id_Producto){
            return "error1";
        }

    $SQL="UPDATE `Voluntarios` SET `producto`='$producto',`descripcion`='$descripcion',`stock`='$stock',
    `precio_Compra`='$precio_Compra',`precio_Venta`='$precio_Venta',`stock_Vendido`='$stock_Vendido',
    `stock_Minimo`='$stock_Minimo',`activo`='$factivo' WHERE id_Producto = $id_Producto";
    echo $SQL;
    $res= $this->DAO->actualizar($SQL);
    return $res;
}

}

?>