<?php 
require_once 'Models/DAO.php';

class M_Usuarios{
    private $DAO;
    
    public function _construct(){
        $this->DAO=new DAO();
    }
    
    public function buscar($filtros=array()){
        $texto='';
        $fSexo='';
        $id_Usuario='';
        $ids=array(); //para filtrar por varios id
        $login='';
        $pass=''; //recibirla en ya en md5
        $estado=''; //igual que activo pero en filtros de pantalla
        $activo='';
        $todos='S';
        
        //fin para el paginador      
        extract($filtros);
        
        $SQL="SELECT * ";
        $SQL.="FROM usuarios
                WHERE 1=1 ";
        if($texto!=''){
            $aTexto=explode(' ', $texto);
            $SQL.=" AND ( 1=2 ";
            foreach ($aTexto as $palabra) {
                $SQL.=" || nombre LIKE '%$palabra%'  
                        || apellido_1 LIKE '%$palabra%'  
                        || apellido_2 LIKE '%$palabra%'  
                        || mail LIKE '%$palabra%'  
                        || login LIKE '%$palabra%' ";
            }
            $SQL.=" ) ";

        }
        if($fSexo!=''){
            $SQL.=" AND sexo='$fSexo' ";
        }
        if($id_Usuario!=''){
            $SQL.=" AND id_Usuario='$id_Usuario' ";
        }
        if($login!=''){
            $SQL.=" AND login='$login' ";
        }
        if($pass!=''){
            $SQL.=" AND pass='$pass' ";
        }
        if($estado!=''){
            $SQL.=" AND activo='$estado' ";
        }
        if($activo!=''){
            $SQL.=" AND activo='$activo' ";
        }
        if(!empty($ids)){
            $SQL.=" AND id_Usuario IN (".implode(',',array_Keys($ids)).") ";
        }

        $SQL.=" ORDER BY apellido_1, apellido_2, nombre, login ";
        echo $SQL;
        $usuarios=$this->DAO->consultar($SQL);
        return $usuarios;
    }

    public function insertarUsuario( $datos){
        $nombre='';
        $apellido_1='';
        $apellido_2='';
        $sexo='H';
        $mail='';
        $movil='';
        $login='';
        $fecha_Alta=date('Y-m-d');
        $activo='S';
        $pass='';
        extract($datos);
        
        $SQL="INSERT INTO usuarios SET
                nombre='$nombre',
                apellido_1='$apellido_1',
                apellido_2='$apellido_2',
                sexo='$sexo',
                fecha_Alta='$fecha_Alta',
                mail='$mail',
                movil='$movil',
                login='$login',
                pass=MD5('$pass'),
                activo='$activo' ";
        return $id_Usuario=$this->DAO->insertar($SQL);
    }
    

    public function actualizarUsuarioPorId($datos){
        $id_Usuario='';
        $nombre='';
        $apellido_1='';
        $apellido_2='';
        $sexo='H';
        $mail='';
        $movil='';
        $login='';
        $fecha_Alta='';
        $activo='';
        $pass='';
        extract($datos);

        $nombre=addslashes($nombre); //para aceptar comillas
        $apellido_1=addslashes($apellido_1);
        $apellido_2=addslashes($apellido_2);

        $SQL="UPDATE usuarios SET ";
        if($pass!=''){
			$SQL.="	pass='".md5($pass)."', ";
        }
        if($activo=='S' || $activo=='N'){
			$SQL.="	activo='".$activo."', ";
        }
        $SQL.= "nombre='$nombre',
			    apellido_1='$apellido_1',
                apellido_2='$apellido_2',
                sexo='$sexo',
                mail='$mail',
                movil='$movil',
                login='$login',
                fecha_Alta='$fecha_Alta' ";
        
		$SQL.="	WHERE id_Usuario='$id_Usuario' ";

        return $numFilasActualizadas=$this->DAO->actualizar($SQL);
    }
    

    public function cambiarActivo($datos){
        $id_Usuario='';
        extract($datos);

        $SQL="UPDATE usuarios 
                SET activo = CASE WHEN activo='S' THEN 'N' ELSE 'S' END
                WHERE id_Usuario='$id_Usuario' ";
        $numFilasActualizadas=$this->DAO->actualizar($SQL);

        return $numFilasActualizadas;
    }

    public function borrarUsuario($datos){
        $id_Usuario='';
        extract($datos);

        $SQL="DELETE FROM usuarios WHERE 1=2 ";
        if( $id_Usuario!='' ){
            $SQL.= " OR id_Usuario='$id_Usuario' ";
        }

        return $numFilasEliminadas=$this->DAO->borrar($SQL);
    }

}



?>



