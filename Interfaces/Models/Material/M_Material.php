<?php

require_once 'Models/DAO.php';

class M_Material{

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

        $SQL="SELECT id_Producto FROM `Material`";
        $res= $this->DAO->consultar($SQL);
        return $res;
    }
    */

    public function buscar($filtros=array()){
        $Material_id='';
        $nombre='';
        $descripcion='';
        $motivo='';
        $cantidad='';

        extract($filtros);

        $SQL="SELECT * FROM material WHERE 1=1 "; //poniendo el 1=1 hacemos que la primera condicion sea nula, y la siguiente tenga que empezar por and u OR
        
        /*if($texto!=''){
            //$SQL.= " AND producto LIKE '%$texto%'"; //cualquiera de las dos me sirve
            $SQL.= " AND producto LIKE '%".$texto."%'";
        }*/


        /* BUSCAMOS POR EL NOMBRE DE LA Material */
        if($nombre!=''){
            $lista=explode(' ',$nombre);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR material_nombre like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }
        /* BUSCAMOS POR LA DESCRIPCION DE LA Material */
        if($descripcion!=''){
            $lista=explode(' ',$descripcion);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR material_descripcion like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }
        /* BUSCAMOS POR EL DNI DEL Material */
        if($motivo!=''){
            $lista=explode(' ',$motivo);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR material_motivo like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }

        /* BUSCAMOS POR EL EMAIL DEL Material */
        if($cantidad!=''){
            $lista=explode(' ',$cantidad);
            $SQL.= " AND( 1=2 ";
            foreach($lista as $palabra){
                $SQL.=" OR material_cantidad like '%".$palabra."%'";
            }
            $SQL.=" ) ";
        }

        


        if($Material_id!=''){
            $SQL.=" AND material_id = '$material_id' )"; //filtramos por id
        }

        
        $res= $this->DAO->consultar($SQL);
        return $res;
    }

    
    public function insertar($registro=array()){
        /*declaramos variables vacias de SQL y las insertamos*/
        $material_id='';
        $nombre='';
        $descripcion='';
        $motivo='';
        $cantidad='';
        extract($registro);

        $CHECK= "SELECT material_id from material WHERE material_nombre= '$nombre' ";
        $resultadoConsulta = $this->DAO->consultar($CHECK);
        if (!empty($resultadoConsulta)){
            return "error1";
        }

        $SQL="INSERT INTO material (material_nombre, material_descripcion, material_motivo, material_cantidad)
        VALUES ('$nombre', '$descripcion','$motivo','$cantidad')";
        $res= $this->DAO->insertar($SQL);
        
        //$SQL="INSERT INTO Material (producto, descripcion, id_Categoria, stock, precio_Compra, precio_Venta,stock_Vendido,stock_Minimo,activo) ";
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
    //$SQL="INSERT INTO Material (producto, descripcion, id_Categoria, stock, precio_Compra, precio_Venta,stock_Vendido,stock_Minimo,activo) ";
    /*$SQL="UPDATE Material (producto, descripcion, activo, stock, stock_Minimo, Stock_Vendido, precio_Compra, precio_Venta, id_categoria)
    VALUES ('$producto', '$descripcion','$factivo','$stock','$stock_Minimo','$stock_Vendido','$precio_Compra','$precio_Venta','$categoria')
    WHERE (id_Producto = $id_Producto)";*/

    $CHECK= "SELECT id_Producto from Material WHERE producto= '$producto' ";
        $resultadoConsulta = $this->DAO->consultar($CHECK);
        if (!empty($resultadoConsulta) && $resultadoConsulta[0]['id_Producto'] != $id_Producto){
            return "error1";
        }

    $SQL="UPDATE `Material` SET `producto`='$producto',`descripcion`='$descripcion',`stock`='$stock',
    `precio_Compra`='$precio_Compra',`precio_Venta`='$precio_Venta',`stock_Vendido`='$stock_Vendido',
    `stock_Minimo`='$stock_Minimo',`activo`='$factivo' WHERE id_Producto = $id_Producto";
    echo $SQL;
    $res= $this->DAO->actualizar($SQL);
    return $res;
}

}

?>