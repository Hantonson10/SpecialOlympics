<?php

require_once 'Models/DAO.php';

class M_Formacion{

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

        $SQL="SELECT id_Producto FROM `Formacion`";
        $res= $this->DAO->consultar($SQL);
        return $res;
    }
    */

    public function buscar($filtros=array()){
        $formacion_id='';
        $nombre='';
        $descripcion='';
        $horas='';
        $entidad='';

        extract($filtros);

        $SQL="SELECT * FROM formacion WHERE 1=1 "; //poniendo el 1=1 hacemos que la primera condicion sea nula, y la siguiente tenga que empezar por and u OR
        
        /*if($texto!=''){
            //$SQL.= " AND producto LIKE '%$texto%'"; //cualquiera de las dos me sirve
            $SQL.= " AND producto LIKE '%".$texto."%'";
        }*/


        /* BUSCAMOS POR EL NOMBRE DE LA FORMACION */
        if($nombre!=''){
            $lista=explode(' ',$nombre);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR formacion_nombre like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }
        /* BUSCAMOS POR LA DESCRIPCION DE LA FORMACION */
        if($descripcion!=''){
            $lista=explode(' ',$descripcion);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR formacion_descripcion like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }
        /* BUSCAMOS POR EL DNI DEL formacion */
        if($horas!=''){
            $lista=explode(' ',$horas);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR formacion_horas like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }

        /* BUSCAMOS POR EL EMAIL DEL formacion */
        if($entidad!=''){
            $lista=explode(' ',$entidad);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR formacion_entidad like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }

        


        if($formacion_id!=''){
            $SQL.=" AND formacion_id = '$formacion_id' )"; //filtramos por id
        }

        
        $res= $this->DAO->consultar($SQL);
        return $res;
    }

    
    public function insertar($registro=array()){
        /*declaramos variables vacias de SQL y las insertamos*/
        $formacion_id='';
        $nombre='';
        $descripcion='';
        $horas='';
        $entidad='';
        extract($registro);

        $CHECK= "SELECT formacion_id from formacion WHERE formacion_nombre= '$nombre' ";
        $resultadoConsulta = $this->DAO->consultar($CHECK);
        if (!empty($resultadoConsulta)){
            return "error1";
        }

        $SQL="INSERT INTO formacion (formacion_nombre, formacion_descripcion, formacion_horas, formacion_entidad)
        VALUES ('$nombre', '$descripcion','$horas','$entidad')";
        $res= $this->DAO->insertar($SQL);
        
        //$SQL="INSERT INTO Formacion (producto, descripcion, id_Categoria, stock, precio_Compra, precio_Venta,stock_Vendido,stock_Minimo,activo) ";
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
    //$SQL="INSERT INTO Formacion (producto, descripcion, id_Categoria, stock, precio_Compra, precio_Venta,stock_Vendido,stock_Minimo,activo) ";
    /*$SQL="UPDATE Formacion (producto, descripcion, activo, stock, stock_Minimo, Stock_Vendido, precio_Compra, precio_Venta, id_categoria)
    VALUES ('$producto', '$descripcion','$factivo','$stock','$stock_Minimo','$stock_Vendido','$precio_Compra','$precio_Venta','$categoria')
    WHERE (id_Producto = $id_Producto)";*/

    $CHECK= "SELECT id_Producto from Formacion WHERE producto= '$producto' ";
        $resultadoConsulta = $this->DAO->consultar($CHECK);
        if (!empty($resultadoConsulta) && $resultadoConsulta[0]['id_Producto'] != $id_Producto){
            return "error1";
        }

    $SQL="UPDATE `Formacion` SET `producto`='$producto',`descripcion`='$descripcion',`stock`='$stock',
    `precio_Compra`='$precio_Compra',`precio_Venta`='$precio_Venta',`stock_Vendido`='$stock_Vendido',
    `stock_Minimo`='$stock_Minimo',`activo`='$factivo' WHERE id_Producto = $id_Producto";
    echo $SQL;
    $res= $this->DAO->actualizar($SQL);
    return $res;
}

}

?>