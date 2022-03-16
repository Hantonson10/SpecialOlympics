<?php

require_once 'Models/DAO.php';

class M_Actividad{

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

        $SQL="SELECT id_Producto FROM `Actividad`";
        $res= $this->DAO->consultar($SQL);
        return $res;
    }
    */

    public function buscar($filtros=array()){
        $actividad_id='';
        $lugar='';
        $duracion='';
        $temporada='';
        $rangoFecha='';

        extract($filtros);

        $SQL="SELECT * FROM actividad WHERE 1=1 "; //poniendo el 1=1 hacemos que la primera condicion sea nula, y la siguiente tenga que empezar por and u OR
        
        /*if($texto!=''){
            //$SQL.= " AND producto LIKE '%$texto%'"; //cualquiera de las dos me sirve
            $SQL.= " AND producto LIKE '%".$texto."%'";
        }*/


        /* BUSCAMOS POR EL lugar DE LA Actividad */
        if($lugar!=''){
            $lista=explode(' ',$lugar);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR actividad_lugar like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }
        /* BUSCAMOS POR LA duracion DE LA Actividad */
        if($duracion!=''){
            $lista=explode(' ',$duracion);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR actividad_duracion like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }
        /* BUSCAMOS POR EL DNI DEL Actividad */
        if($temporada!=''){
            $lista=explode(' ',$temporada);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR actividad_temporada like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }



        if($actividad_id!=''){
            $SQL.=" AND actividad_id = '$actividad_id' )"; //filtramos por id
        }

        
        $res= $this->DAO->consultar($SQL);
        return $res;
    }

    
    public function insertar($registro=array()){
        /*declaramos variables vacias de SQL y las insertamos*/
        $Actividad_id='';
        $lugar='';
        $duracion='';
        $temporada='';
        $fecha='';
        extract($registro);

        $CHECK= "SELECT actividad_id from actividad WHERE actividad_lugar= '$lugar' ";
        $resultadoConsulta = $this->DAO->consultar($CHECK);
        if (!empty($resultadoConsulta)){
            return "error1";
        }

        $SQL="INSERT INTO actividad (actividad_lugar, actividad_duracion, actividad_temporada, actividad_fecha)
        VALUES ('$lugar', '$duracion','$temporada','$fecha')";
        $res= $this->DAO->insertar($SQL);
        
        //$SQL="INSERT INTO Actividad (producto, duracion, id_Categoria, stock, precio_Compra, precio_Venta,stock_Vendido,stock_Minimo,activo) ";
        return $res;
        echo $res;
    }



public function guardar($registro=array()){
    /*declaramos variables vacias de SQL y las insertamos*/
    $id_Producto = '';
    $producto = '';
    $duracion = '';
    
    $factivo = '';
    $stock ='';
    $stock_Minimo = '';
    $stock_Vendido = '';
    $precio_Compra ='';
    $precio_Venta = '';
    $categoria = '';
    extract($registro);
    //$SQL="INSERT INTO Actividad (producto, duracion, id_Categoria, stock, precio_Compra, precio_Venta,stock_Vendido,stock_Minimo,activo) ";
    /*$SQL="UPDATE Actividad (producto, duracion, activo, stock, stock_Minimo, Stock_Vendido, precio_Compra, precio_Venta, id_categoria)
    VALUES ('$producto', '$duracion','$factivo','$stock','$stock_Minimo','$stock_Vendido','$precio_Compra','$precio_Venta','$categoria')
    WHERE (id_Producto = $id_Producto)";*/

    $CHECK= "SELECT id_Producto from Actividad WHERE producto= '$producto' ";
        $resultadoConsulta = $this->DAO->consultar($CHECK);
        if (!empty($resultadoConsulta) && $resultadoConsulta[0]['id_Producto'] != $id_Producto){
            return "error1";
        }

    $SQL="UPDATE `Actividad` SET `producto`='$producto',`duracion`='$duracion',`stock`='$stock',
    `precio_Compra`='$precio_Compra',`precio_Venta`='$precio_Venta',`stock_Vendido`='$stock_Vendido',
    `stock_Minimo`='$stock_Minimo',`activo`='$factivo' WHERE id_Producto = $id_Producto";
    echo $SQL;
    $res= $this->DAO->actualizar($SQL);
    return $res;
}

}

?>