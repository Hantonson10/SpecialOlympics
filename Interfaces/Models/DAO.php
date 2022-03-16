<?php

define('HOST', '127.0.0.1'); //como es local dejamos esa IP.
define('USER', 'root');
define('PASS', '');
define('DB', 'bbddspecialolympics');


class DAO{
    private $conexion;

    public function __construct(){ //__construct() es la otra opcion constructor
        $this -> conexion = new mysqli(HOST, USER, PASS, DB);
        if($this ->conexion->connect_errno){
            die('Error de conexion a DB: ' .$this->conexion->connect_error);
        }
    }

    public function consultar($SQL){
        $res=$this->conexion->query($SQL, MYSQLI_USE_RESULT);
        $filas=array();
        if($this->conexion->connect_errno){
            die('Error de consulta' .$SQL);
        }else{
            while($reg=$res->fetch_assoc()){//coger las filas con el nombre de los campos (fetch_assoc)
                $filas[]=$reg;
            } 
            
        }
        return $filas;
    }

    public function insertar($SQL)
    {
        $res = $this->conexion->query($SQL, MYSQLI_USE_RESULT);
        if ($this->conexion->connect_errno) {
            die('Error consulat a BD: ' . $SQL);
            return '';
        } else {
            return $this->conexion->insert_id;
        }
    }

    public function actualizar($SQL)
    {
        $res = $this->conexion->query($SQL, MYSQLI_USE_RESULT);
        if ($this->conexion->connect_errno) {
            die('Error consulat a BD: ' . $SQL);
            return '';
        } else {
            return $this->conexion->affected_rows;
        }
    }

    public function editar($SQL){
        $res=$this->conexion->query($SQL, MYSQLI_USE_RESULT);
        $edicion=array();
        if($this->conexion->connect_errno){
            die('Error de consulta' .$SQL);
        }else{
            while($reg=$res->fetch_assoc()){//coger las filas con el nombre de los campos (fetch_assoc)
                $edicion[]=$reg;
            } 
            
        }
        return $edicion;
    }
    public function getRowsNumber()
    {
        $sql = "SELECT COUNT(*) FROM productos";
        $stmt = $this->conexion->query($sql);
        $count = $stmt->fetchColumn;
        print $count;
    }
}


?>
