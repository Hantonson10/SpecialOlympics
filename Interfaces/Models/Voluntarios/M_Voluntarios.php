<?php

require_once 'Models/DAO.php';

class M_Voluntarios
{

    private $DAO;

    public function __construct()
    {
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

    public function login($email, $password)
    {
        $SQL = "SELECT LOGIN('$email') AS LOGIN";
        $res = $this->DAO->consultar($SQL);
        print_r($res);
        return $res;
    }

    public function getId($email)
    {
        $SQL = "SELECT voluntario_id as id FROM voluntario WHERE voluntario_mail = '$email'";
        return $this->DAO->consultar($SQL)[0];
    }

    public function getPicAndName($id)
    {
        $SQL = "SELECT voluntario_foto as pic, voluntario_nombre as name FROM voluntario WHERE voluntario_id = $id";
        return $this->DAO->consultar($SQL)[0];
    }

    public function getDatosPerfil($id)
    {
        $SQL = "SELECT * from voluntario where voluntario_id = $id";
        return $this->DAO->consultar($SQL)[0];
    }

    public function getCategorias()
    {
        $SQL = "SELECT id_ProductoCategoria, productoCategoria FROM `Voluntarioscategorias`";
        $res = $this->DAO->consultar($SQL);
        return $res;
    }

    public function buscar($filtros = array())
    {
        $voluntario_id = '';
        $nombre = '';
        $apellido = '';
        $DNI = '';
        $email = '';
        $direccion = '';
        $DNI = '';
        $cod_postal = '';
        $rangoFechaAlta = '';

        extract($filtros);

        $SQL = "SELECT * FROM voluntario WHERE 1=1 "; //poniendo el 1=1 hacemos que la primera condicion sea nula, y la siguiente tenga que empezar por and u OR

        /*if($texto!=''){
            //$SQL.= " AND producto LIKE '%$texto%'"; //cualquiera de las dos me sirve
            $SQL.= " AND producto LIKE '%".$texto."%'";
        }*/


        /* BUSCAMOS POR EL NOMBRE DEL VOLUNTARIO */
        if ($nombre != '') {
            $lista = explode(' ', $nombre);
            $SQL .= " AND( 1=2 ";
            foreach ($lista as $palabra) {
                $SQL .= " OR voluntario_nombre like '%" . $palabra . "%'";
            }
            $SQL .= " ) ";
        }
        /* BUSCAMOS POR EL APELLIDO DEL VOLUNTARIO */
        if ($apellido != '') {
            $lista = explode(' ', $apellido);
            $SQL .= " AND( 1=2 ";
            foreach ($lista as $palabra) {
                $SQL .= " OR voluntario_apellidos like '%" . $palabra . "%'";
            }
            $SQL .= " ) ";
        }
        /* BUSCAMOS POR EL DNI DEL VOLUNTARIO */
        if ($DNI != '') {
            $lista = explode(' ', $DNI);
            $SQL .= " AND( 1=2 ";
            foreach ($lista as $palabra) {
                $SQL .= " OR voluntario_dni like '%" . $palabra . "%'";
            }
            $SQL .= " ) ";
        }

        /* BUSCAMOS POR EL EMAIL DEL VOLUNTARIO */
        if ($email != '') {
            $lista = explode(' ', $email);
            $SQL .= " AND( 1=2 ";
            foreach ($lista as $palabra) {
                $SQL .= " OR voluntario_mail like '%" . $palabra . "%'";
            }
            $SQL .= " ) ";
        }

        /* BUSCAMOS POR EL DIRECCION DEL VOLUNTARIO */
        if ($direccion != '') {
            $lista = explode(' ', $direccion);
            $SQL .= " AND( 1=2 ";
            foreach ($lista as $palabra) {
                $SQL .= " OR voluntario_direccion like '%" . $palabra . "%'";
            }
            $SQL .= " ) ";
        }

        /* BUSCAMOS POR EL CODIGO POSTAL DEL VOLUNTARIO */
        if ($cod_postal != '') {
            $lista = explode(' ', $cod_postal);
            $SQL .= " AND( 1=2 ";
            foreach ($lista as $palabra) {
                $SQL .= " OR voluntario_cpostal like '%" . $palabra . "%'";
            }
            $SQL .= " ) ";
        }


        if ($voluntario_id != '') {
            $SQL .= " AND voluntario_id = '$voluntario_id' )"; //filtramos por id
        }


        $res = $this->DAO->consultar($SQL);
        return $res;
    }


    public function insertar($registro = array())
    {
        /*declaramos variables vacias de SQL y las insertamos*/
        $producto = '';
        $descripcion = '';
        $factivo = '';
        $stock = '';
        $stock_Minimo = '';
        $stock_Vendido = '';
        $precio_Compra = '';
        $precio_Venta = '';
        $categoria = '';
        extract($registro);

        $CHECK = "SELECT id_Producto from Voluntarios WHERE producto= '$producto' ";
        $resultadoConsulta = $this->DAO->consultar($CHECK);
        if (!empty($resultadoConsulta)) {
            return "error1";
        }

        $SQL = "INSERT INTO Voluntarios (producto, descripcion, activo, stock, stock_Minimo, Stock_Vendido, precio_Compra, precio_Venta, id_categoria)
        VALUES ('$producto', '$descripcion','$factivo','$stock','$stock_Minimo','$stock_Vendido','$precio_Compra','$precio_Venta','$categoria')";
        $res = $this->DAO->insertar($SQL);

        //$SQL="INSERT INTO Voluntarios (producto, descripcion, id_Categoria, stock, precio_Compra, precio_Venta,stock_Vendido,stock_Minimo,activo) ";
        return $res;
        echo $res;
    }



    public function guardar($registro = array())
    {
        /*declaramos variables vacias de SQL y las insertamos*/
        $nombre = '';
        $apellido = '';
        $telefono = '';
        $dni = '';
        $email = '';
        $talla = '';
        $direccion = '';
        $codPostal = '';
        $fotoPerfil = '';
        extract($registro);


        $SQL = "UPDATE voluntario SET voluntario_id = " . $_SESSION['id'];
        if ($nombre != '') {
            $SQL .= ", voluntario_nombre='$nombre'";
        }
        if ($apellido != '') {
            $SQL .= ", voluntario_apellidos='$apellido'";
        }
        if ($telefono != '') {
            $SQL .= ", voluntario_tel1=$telefono";
        }
        if ($dni != '') {
            $SQL .= ", voluntario_dni='$dni'";
        }
        if ($email != '') {
            $SQL .= ", voluntario_mail='$email'";
        }
        if ($talla != '') {
            $SQL .= ", voluntario_tall_camiseta='$talla'";
        }
        if ($direccion != '') {
            $SQL .= ", voluntario_direccion='$direccion'";
        }
        if ($codPostal != '') {
            $SQL .= ", voluntario_cpostal=$codPostal";
        }
        if ($fotoPerfil != '') {
            $SQL .= ", voluntario_foto='$fotoPerfil'";
        }

        $SQL .= " WHERE voluntario_id = " . $_SESSION['id'];
        $res = $this->DAO->actualizar($SQL);
        if ($res == -1) {
            return 'error';
        } else {
            return 'Registro Actualizado';
        }
    }

    public function cambiarContraseña($registro = array())
    {
        /*declaramos variables vacias de SQL y las insertamos*/
        $inputFirstPassword = '';
        $inputConfirmPassword = '';
        extract($registro);


        if ($inputFirstPassword != '' && $inputFirstPassword == $inputConfirmPassword) {



            $SQL = "UPDATE usuario SET usuario_voluntario = " . $_SESSION['id'];
            if ($inputFirstPassword != '') {
                $SQL .= ", usuario_password='".md5($inputFirstPassword)."'";
            }

            $SQL .= " WHERE usuario_voluntario = " . $_SESSION['id'];
            $res = $this->DAO->actualizar($SQL);
            if ($res == -1) {
                return 'error';
            } else {
                return 'Contraseña Modificada';
            }
        } else {
            return 'Las contraseñas NO coinciden o estan vacias';
        }
    }
}
