<?php
require_once 'Models/DAO.php';

class M_Menus{
    private $DAO;
    
    public function __construct(){
        $this->DAO=new DAO();
    }

    public function getDatosMenuTabla($filtros=array()){
        $soloPublicas='N';
        extract($filtros);

        $menu=array();
        $SQL="SELECT * FROM menus
                WHERE activo='S' ";
        if($soloPublicas=='S'){
            $SQL.=" AND publica='S' ";
        }

        $SQL.=" ORDER BY id_Padre, orden ";

        $res=$this->DAO->consultar($SQL);
        
        if(!empty($res)){
            foreach ($res as $opcion){
                $id_opcion=$opcion['id_Opcion'];
                if($opcion['id_Padre']==0){
                    $menu[$id_opcion]=$opcion;
                }else{
                    $id_Padre=$opcion['id_Padre'];
                    if(isset($menu[$id_Padre])){ //solo si existe el padre.
                            $menu[$id_Padre]['subOpciones'][$id_opcion]=$opcion;
                    }
                }
            }
        }
        return $menu;
    }

    // *********************************
    public function getTodosLosRoles($datos){
        $id_Usuario='';
        extract($datos);
        
        $SQL="SELECT roles.* ";
        if($id_Usuario!=''){
            $SQL.=", (SELECT rolesusuario.id_Usuario FROM rolesusuario WHERE id_Usuario='$id_Usuario' AND id_Rol=roles.id_Rol limit 1) as id_Usuario ";
        }
        
        $SQL.="FROM roles
        ORDER BY roles.rol";
        $res=$this->DAO->Consultar($SQL);
        return $res;
    }
    
    public function getPermisosMenu(){
		$permisos=array();
		$SQL="SELECT * FROM permisos
				ORDER BY id_Opcion, num_Permiso";
		$res=$this->DAO->Consultar($SQL);
		
		if(!empty($res)){
			foreach ($res as $fila){
				$permisos[$fila['id_Opcion']][$fila['num_Permiso']]=$fila;
			}
		}
		return $permisos;
	}
    
    /* Obtener permisos del usuario + permisos por sus roles
	* @param  datos['id_Usuario']	del usuario de que se desean los permisos
	* 		   datos['porRoles']	true/(false), indica si se distiguen los roles por el que se obtiene el permiso	
	* @return array [id_Opcion][num_Permiso]=true				Si porRoles=false
	* @return array [id_Opcion][num_Permiso][id_Rol]=true		Si porRoles=true
	*/
	public function getPermisosUsuario($datos){
		$id_Usuario='';
		$porRoles=false;
		extract($datos);
		
		$SQL ="SELECT DISTINCT permisos.id_Opcion, permisos.num_Permiso, '0' as id_Rol FROM permisos
						INNER JOIN permisosusuario ON permisos.id_Permiso=permisosusuario.id_Permiso
					WHERE permisosusuario.id_Usuario='".$id_Usuario."'  
			UNION			
				SELECT DISTINCT permisos.id_Opcion, permisos.num_Permiso, permisosrol.id_Rol FROM permisos
						INNER JOIN permisosrol ON permisos.id_Permiso=permisosrol.id_Permiso
						INNER JOIN roles ON roles.id_rol=permisosrol.id_rol
						INNER JOIN rolesusuario ON rolesusuario.id_rol=roles.id_rol
					WHERE rolesusuario.id_Usuario='".$id_Usuario."' 
							
			ORDER BY id_Opcion, num_Permiso ";
		$res=$this->DAO->Consultar($SQL);
		$permisos=array();
		if(!empty($res)){
			foreach ($res as $reg){
				if($porRoles){
					//Se indica el rol por el que se tiene el permiso (0 para permisos directos del usuario)
					$permisos[$reg['id_Opcion']][$reg['num_Permiso']][$reg['id_Rol']]=true;
				}else{
					//No se indica el rol por el que se tiene el permiso
					$permisos[$reg['id_Opcion']][$reg['num_Permiso']]=true;
				}
			}
		}
		return $permisos;
	}

	public function getRolesUsuario($datos){
		$id_Usuario=$datos['id_Usuario'];
		$SQL="SELECT roles.* FROM roles
				INNER JOIN rolesusuario ON roles.id_Rol=rolesusuario.id_Rol
				WHERE rolesusuario.id_Usuario='".$id_Usuario."' 
				ORDER BY roles.rol";
		$res=$this->DAO->Consultar($SQL);
		$roles=array();
		if(!empty($res)){
			foreach ($res as $fila){
				$roles[$fila['id_Rol']]=$fila['rol'];
			}
		}
		return $roles;
	}

    /* Obtener permisos del rol
	* @param  datos['id_Rol']	del usuario de que se desean los permisos
	* @return array [id_Opcion][num_Permiso]=true				Si porRoles=false
	*/
	public function getPermisosRol($datos){
		$id_Rol=$datos['id_Rol'];
		
		$SQL ="SELECT DISTINCT permisos.id_Opcion, permisos.num_Permiso FROM permisos
						INNER JOIN permisosrol ON permisos.id_Permiso=permisosrol.id_Permiso
					WHERE permisosrol.id_Rol='".$id_Rol."' 
			ORDER BY id_Opcion, num_Permiso ";
		$res=$this->DAO->Consultar($SQL);
		$permisos=array();
		if(!empty($res)){
			foreach ($res as $reg){
				$permisos[$reg['id_Opcion']][$reg['num_Permiso']]=true;
			}
		}
		return $permisos;
	}

	public function getDatosOpcion($datos){
		$id_Opcion=0;
		extract($datos);
		$SQL="SELECT * FROM menus
				WHERE id_Opcion='".$id_Opcion."' ";
		$res=$this->DAO->Consultar($SQL);
		return $res[0];
	}

	public function incrementarOrdenPosteriores($datos){
        $id_Padre='0';
        $orden=1;
        extract($datos);
        $SQL="UPDATE menus SET orden=orden+1 
                WHERE id_Padre='$id_Padre' AND orden>='$orden' ";
        $this->DAO->actualizar($SQL);
    }

	public function buscarOrdenUltimaOpcion($filtros){
        $id_Padre=0;
        extract($filtros);
        $SQL="SELECT MAX(orden) as maximo FROM menus
				WHERE id_Padre='$id_Padre' ";
        $res=$this->DAO->actualizar($SQL);
        return $res[0]['maximo'];
    }

    public function insertarOpcion($datos){
        $id_Padre='0';
        $orden=1;
        $texto='';
        $accion='';
        $activo='N';
        extract($datos);
        $accion=addslashes($accion);
        $SQL="INSERT INTO menus 
                SET texto='$texto',
					accion='$accion',
                    id_Padre='$id_Padre',
                    orden='$orden',
                    activo='$activo' ";
        $id=$this->DAO->insertar($SQL);
        
        return $id;
    }

    public function modificarOpcionPorId($datos){
        $id_Opcion='';
        $id_Padre='0';
        $orden=1;
        $texto='';
        $accion='';
        $activo='N';
		extract($datos);
		$accion=addslashes($accion);
        $SQL="UPDATE menus 
                    SET texto='$texto',
                        accion='$accion',
                        id_Padre='$id_Padre',                        
                        orden='$orden',
                        activo='$activo'
				WHERE id_Opcion='$id_Opcion' ";
			
        return $this->DAO->actualizar($SQL);
	}
	
	public function borrarOpcion($datos){
		$id_Opcion=0;
		extract($datos);
		if($id_Opcion!=0){ //por seguridad
			//buscar permisos
			$SQL="SELECT * FROM permisos WHERE id_Opcion='".$id_Opcion."' ";
			$resper=$this->DAO->consultar($SQL);
			if(!empty($resper)){
				foreach ($resper as $permiso){
					$this->borrarPermiso(array('id_Permiso'=>$permiso['id_Permiso']));
				}
			}
			//borrar opcion
			$SQL="DELETE FROM menus
				WHERE id_Opcion='".$id_Opcion."' ";
			$res=$this->DAO->borrar($SQL);
		}
		return true; //asumimos que no puede haber problemas.
	}

	public function borrarPermiso($datos){
		$id_Permiso=0;
		extract($datos);
		
		if($id_Permiso!=0){ //por seguridad
			//borrar permisosrol
			$SQL="DELETE FROM permisosrol
				WHERE id_Permiso='".$id_Permiso."' ";
			$res=$this->DAO->borrar($SQL);
			
			//borrar permiso usuarios
			$SQL="DELETE FROM permisosusuario
				WHERE id_Permiso='".$id_Permiso."' ";
			$res=$this->DAO->borrar($SQL);
			
			//borrar permiso
			$SQL="DELETE FROM permisos
				WHERE id_Permiso='".$id_Permiso."' ";
			$res=$this->DAO->borrar($SQL);
		}
		
		return true; //asumimos que no puede haber problemas.
	}

	public function getDatosPermiso($datos){
		$SQL="SELECT * FROM permisos
				WHERE id_Permiso='".$datos['id_Permiso']."' ";
		$res=$this->DAO->consultar($SQL);
		
		$datosPermiso=array();
		if(!empty($res)){
			$datosPermiso=$res[0];
		}else{
			$datosPermiso=array();
		}
		return $datosPermiso;
	}

	public function insertarPermiso($datos){
		$id_Opcion=0;
		$num_Permiso=0;
		$permiso='';
		extract($datos);
		
		$SQL="INSERT INTO permisos
				SET id_Opcion='$id_Opcion',
					num_Permiso='$num_Permiso',
					permiso='$permiso' ";
		$res=$this->DAO->insertar($SQL);
		return $res;
	}
	
	public function modificarPermiso($datos){
		$id_Permiso='';
		$id_Opcion=0;
		$num_Permiso=0;
		$permiso='';
		extract($datos);
	
		$SQL="UPDATE permisos
				SET num_Permiso='$num_Permiso',
					permiso='$permiso'  
				WHERE id_Permiso='$id_Permiso' AND id_Opcion='$id_Opcion' ";
		$res=$this->DAO->actualizar($SQL);
		return $res;
	}

	public function ponerPermisoRol($parametros){
		$id_Rol='';
		$id_Opcion='';
		$num_Permiso='';
		extract($parametros);
		$SQL="SELECT * FROM permisos WHERE id_Opcion='$id_Opcion' AND  num_Permiso='$num_Permiso' ";
		$res=$this->DAO->consultar($SQL);
		$id_Permiso=$res[0]['id_Permiso'];
		
		$SQL="INSERT IGNORE INTO permisosrol SET id_Permiso='$id_Permiso', id_Rol='$id_Rol' ";
		$id=$this->DAO->insertar($SQL);
	}
	public function ponerPermisoUsuario($parametros){
		$id_Usuario='';
		$id_Opcion='';
		$num_Permiso='';
		extract($parametros);
		$SQL="SELECT * FROM permisos WHERE id_Opcion='$id_Opcion' AND  num_Permiso='$num_Permiso' ";
		$res=$this->DAO->consultar($SQL);
		$id_Permiso=$res[0]['id_Permiso'];
		
		$SQL="INSERT IGNORE INTO permisosUsuario SET id_Permiso='$id_Permiso', id_Usuario='$id_Usuario' ";
		$id=$this->DAO->insertar($SQL);
	}
	
	public function quitarPermisoRol($parametros){
		$id_Rol='';
		$id_Opcion='';
		$num_Permiso='';
		extract($parametros);
		$SQL="SELECT * FROM permisos 
					WHERE id_Opcion='$id_Opcion' AND  num_Permiso='$num_Permiso' ";
		$res=$this->DAO->consultar($SQL);
		$id_Permiso=$res[0]['id_Permiso'];
		
		$SQL="DELETE FROM permisosrol WHERE id_Permiso='$id_Permiso' AND id_Rol='$id_Rol' ";
		$id=$this->DAO->borrar($SQL);
	}
	public function quitarPermisoUsuario($parametros){
		$id_Usuario='';
		$id_Opcion='';
		$num_Permiso='';
		extract($parametros);
		$SQL="SELECT * FROM permisos 
					WHERE id_Opcion='$id_Opcion' AND  num_Permiso='$num_Permiso' ";
		$res=$this->DAO->consultar($SQL);
		$id_Permiso=$res[0]['id_Permiso'];
		
		$SQL="DELETE FROM permisosusuario WHERE id_Permiso='$id_Permiso' AND id_Usuario='$id_Usuario' ";
		$id=$this->DAO->borrar($SQL);
	}

	public function getDatosRol($datos){
		$id_Rol='';
		extract($datos);
	
		$SQL="SELECT * FROM roles
				WHERE id_Rol='$id_Rol' ";
		$res=$this->DAO->consultar($SQL);
		return $res;
	}
	
	public function insertarRol($datos){
        $rol='';
        extract($datos);
    
		$SQL="INSERT INTO roles 
                SET rol='$rol' ";
        $id=$this->DAO->insertar($SQL);
        
        return $id;
    }

	public function borrarRol($datos){
		$id_Rol=0;
		extract($datos);

		if($id_Rol!=0){ //por seguridad
			//borrar permisos asociados al rol
			$SQL="DELETE FROM permisosrol WHERE id_Rol='".$id_Rol."' ";
			$res=$this->DAO->borrar($SQL);
			
			//borrar rol
			$SQL="DELETE FROM roles
				WHERE id_Rol='".$id_Rol."' ";
			$res=$this->DAO->borrar($SQL);
		}
		return 'SI'; //asumimos que no puede haber problemas.
	}

	public function modificarRol($datos){
		$id_Rol='';
		$rol='';
		extract($datos);
	
		$SQL="UPDATE roles
				SET rol='$rol'  
				WHERE id_Rol='$id_Rol' ";
		$res=$this->DAO->actualizar($SQL);
		return $res;
	}
	public function signarRolUsuario($datos){
		$id_Rol='';
		$id_Usuario='';
		extract($datos);
	
		$SQL="INSERT IGNORE rolesusuario
				SET id_Rol='$id_Rol',
					id_Usuario='$id_Usuario' ";
		$res=$this->DAO->insertar($SQL);
		return $res;
	}
	public function designarRolUsuario($datos){
		$id_Rol='';
		$id_Usuario='';
		extract($datos);
	
		$SQL="DELETE FROM rolesusuario
				WHERE id_Rol='$id_Rol' AND id_Usuario='$id_Usuario' ";
		$res=$this->DAO->borrar($SQL);
		return $res;
	}

	public function getUsuariosRol($datos){
		$id_Rol='';
		extract($datos);
		
		$SQL="SELECT usuarios.*, rolesusuario.id_Rol
				FROM usuarios
				LEFT JOIN rolesusuario ON rolesusuario.id_Usuario=usuarios.id_Usuario AND rolesusuario.id_Rol='$id_Rol' 
				ORDER BY apellido_1, apellido_2, nombre ";
		$res=$this->DAO->consultar($SQL);
		return $res;
	}

}