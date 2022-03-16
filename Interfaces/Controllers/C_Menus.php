<?php
require_once 'Views/Vista.php';
require_once 'Models/M_Menus.php';
class C_Menus{
    private $modelo;

    public function __construct(){
		$this->modelo=new M_Menus();
	}
    public function getMenu($datos = array()){
        //echo 'Esto es el menú';
        //echo ($datos['User']['pic']);
        Vista::render('Views/Utils/V_Navbar.php',$datos);   
    }

    //Carga el menu en la aplicacion:
    public function getMenuBD(){  //CON NIVELES Y BD
        $filtros=array();
        if(!isset($_SESSION['usuario']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']=='')){
            //mostrar solo las opciones publicas
            $filtros['soloPublicas']='S';
        }
        $menu=$this->modelo->getDatosMenuTabla($filtros);


        $vista=new Vista();
        $vista->render('Views/Menus/V_Menu_BD.php', $menu);
    }
// *********************************************
    public function getSelectRoles($datos){
        $datos['roles']=$this->modelo->getTodosLosRoles($datos);
        $vista=new Vista();
        $vista->render('Views/Menus/Mtto/V_RolesSelect.php', $datos);
    }

	public function getVistaMenusPermisos($filtros=array()){
		$datos=array();
		//obtener todas las opciones del menu
        $datos['menu']=$this->modelo->getDatosMenuTabla();
		$datos['permisosMenu']=$this->modelo->getPermisosMenu();

        $datos['ver']='menu';
		if($filtros['id_Usuario']>0) {
			$filtros['porRoles']=true;
			$datos['permisos']=$this->modelo->getPermisosUsuario($filtros);
			$datos['rolesUsuario']=$this->modelo->getRolesUsuario($filtros);
			$datos['ver']='usuario'; //la vista se hace por permisos del usuario
		}
		if($filtros['id_Rol']>0) {
			$filtros['porRoles']=false;
			$datos['permisos']=$this->modelo->getPermisosRol($filtros);
			$datos['ver']='rol'; //la vista se hace por permisos del usuario
		}
		Vista::render('Views/Menus/Mtto/V_Menu_Mtto.php', $datos);
	}


    public function getPermisosUsuario($parametros){
		//obtener permisos del usuario personales y de rol
		$permisos=$this->modelo->getPermisosUsuario($parametros);
		return $permisos;
	}


    /*
    *   METODOS PARA EL MTTO. DEL MENU:
    */

    public function getVistaFiltrosMtto($datos){
        $menu=$this->modelo->getDatosMenuTabla();

        require_once 'Controllers/Usuarios/C_Usuarios.php';
	    $objUsu=new C_Usuarios();
	    $usuarios=$objUsu->buscarUsuario(array('todos'=>'S'));

        $vista=new Vista();
        $vista->render('Views/Menus/Mtto/V_Menu_Inicio.php', 
                            array('menu'=>$menu,
                                  'usuarios'=>$usuarios  ));
    }

	public function getVistaEdicionOpcion($datos){
		if($datos['id_Opcion']>=1){
			$datos=$this->modelo->getDatosOpcion($datos);
		}
		$vista=new Vista();
		$vista->render('Views/Menus/Mtto/V_Menu_Mtto_EdicionOpcion.php', $datos);
    }

     
    public function guardarOpcion($datos){
        $id_Opcion='';
        $id_Padre='0';
        $orden=1;
        $texto='';
        $accion='';
        $activo='N';
        extract($datos);
        
        $respuesta['correcto']='S';
        $respuesta['msj']='';
        $respuesta['id_Opcion']=$id_Opcion;
        $respuesta['operacion']='';
        
        if($id_Opcion==''){ //nueva opcion
            $this->modelo->incrementarOrdenPosteriores(array('id_Padre'=>$id_Padre, 'orden'=>$orden));
            //guardo la nueva opcion
            $respuesta['id_Opcion']=$this->modelo->insertarOpcion($datos);
            $respuesta['operacion']='NUEVA';

            //crear permisos basicos y asignarselos al administrador
            $id=$this->modelo->insertarPermiso(array('id_Opcion'=>$respuesta['id_Opcion'],
                                                    'num_Permiso'=>'1',
                                                    'permiso'=>'Consultar'));
            $this->modelo->ponerPermisoRol(array('id_Opcion'=>$respuesta['id_Opcion'],
                                                'id_Rol'=>'1',
                                                'num_Permiso'=>'1'));                
            $id=$this->modelo->insertarPermiso(array('id_Opcion'=>$respuesta['id_Opcion'],
                                                    'num_Permiso'=>'2',
                                                    'permiso'=>'Crear/Editar'));
            $this->modelo->ponerPermisoRol(array('id_Opcion'=>$respuesta['id_Opcion'],
                                                    'id_Rol'=>'1',
                                                    'num_Permiso'=>'2'));
            $id=$this->modelo->insertarPermiso(array('id_Opcion'=>$respuesta['id_Opcion'],
                                                    'num_Permiso'=>'3',
                                                    'permiso'=>'Borrar'));
            $this->modelo->ponerPermisoRol(array('id_Opcion'=>$respuesta['id_Opcion'],
                                                    'id_Rol'=>'1',
                                                    'num_Permiso'=>'3'));



        }else{ //modificando opcion
            $this->modelo->modificarOpcionPorId($datos);
            $respuesta['operacion']='MODIFICADA';
        }
        echo json_encode($respuesta);
    }

    public function borrarOpcion($datos){
		$resul=$this->modelo->borrarOpcion($datos);
		return $resul;
    }
    
    public function getVistaEdicionPermiso($datos){
		if($datos['id_Permiso']!=''){
            $datos=$this->modelo->getDatosPermiso($datos);
        }	
		$vista=new Vista();
		$vista->render('Views/Menus/Mtto/V_EdicionPermiso.php', $datos);
	}
    public function getVistaEdicionRol($datos){
        $vista=new Vista();
		if($datos['id_Rol']!=''){ //modificar
            $roles=$this->modelo->getDatosRol($datos);
            $vista->render('Views/Menus/Mtto/V_EdicionRol.php', $roles[0]);
        }else{ //nuevo
            $vista->render('Views/Menus/Mtto/V_EdicionRol.php');
        }
	}
    
    public function guardarPermiso($datos){
		if($datos['id_Permiso']==0){
			$resul=$this->modelo->insertarPermiso($datos);
		}else{
			$resul=$this->modelo->modificarPermiso($datos);
		}
		if(is_numeric($resul)){
			$respuesta['OK']='S';
		}else{
			$respuesta['OK']='N';
			$respuesta['msj']=$resul;
		}
        echo json_encode($respuesta);
    }

    public function guardarRol($datos){
		if($datos['id_Rol']==0){
			$resul=$this->modelo->insertarRol($datos);
            $respuesta['id_Rol']=$resul;
		}else{
			$resul=$this->modelo->modificarRol($datos);
            $respuesta['id_Rol']=$datos['id_Rol'];
		}
		if(is_numeric($resul)){
			$respuesta['OK']='S';
		}else{
			$respuesta['OK']='N';
			$respuesta['msj']=$resul;
		}
        echo json_encode($respuesta);
    }

    public function borrarRol($datos){
		$resul=$this->modelo->borrarRol($datos);
		echo json_encode(array('OK'=>'S')); //damos por hecho que no dara problema
    }
    
	public function cambiarPermisoRol($parametros){
		if($parametros['accion']=='poner'){
			$this->modelo->ponerPermisoRol($parametros);
		}
		if($parametros['accion']=='quitar'){
			$this->modelo->quitarPermisoRol($parametros);
		}
	}
	public function cambiarPermisoUsuario($parametros){
		if($parametros['accion']=='poner'){
			$this->modelo->ponerPermisoUsuario($parametros);
		}
		if($parametros['accion']=='quitar'){
			$this->modelo->quitarPermisoUsuario($parametros);
		}
	}

    public function borrarPermiso($datos){
        $resul=$this->modelo->borrarPermiso($datos);
        if($resul){
            echo 'S';
        }else{
            echo 'N';
        }
    }
    public function asignarRol($datos){
        $resul=$this->modelo->signarRolUsuario($datos);
        if($resul>0){
            echo 'S';
        }else{
            echo 'N';
        }
    }
    public function desasignarRol($datos){
        $resul=$this->modelo->designarRolUsuario($datos);
        if($resul==1){
            echo 'S';
        }else{
            echo 'N';
        }
    }


    public function getVistaUsuariosRol($datos){
		if($datos['id_Rol']!=0 && $datos['id_Rol']!=''){
			$datos['usuarios']=$this->modelo->getUsuariosRol($datos);
		}
		$vista=new Vista();
		$vista->render('Views/Menus/Mtto/V_usuariosRol.php', $datos);
    }

}