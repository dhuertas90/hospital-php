<?php

require_once('model/ModelGeneric.php');

class Model extends ModelGeneric {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {

    }

//METODOS DE CONFIGURACION
    public function iniciarDatos(){
        session_start();
        $info_config=$this->aRecord("SELECT * FROM configuracion", []);
        return $info_config;
    }
    public function datosConfiguracion(){
        $info_config=$this->aRecord("SELECT * FROM configuracion", []);
        return $info_config;
    }
    public function modificarConfiguracion($datos){
        $this->add("UPDATE configuracion SET descripcion_hospital = :descripcion , titulo= :titulo, mail= :mail, cantidad_pagina= :cantidad_pagina, habilitado= :habilitado, mensaje= :mensaje", array( ':descripcion'=>$datos["descripcion"], ':titulo'=> $datos["titulo"], ':mail'=>$_POST["email"], ':cantidad_pagina'=>$datos["cantidad_pagina"], ':habilitado'=> $datos["habilitado"], ':mensaje'=>$datos["mensaje"] ));
    }
//FIN CONFIGURACION.

//METODOS EXCLUSIVOS SOBRE USUARIOS

    public function agregarUsuario($datos){
        $this->add( "INSERT INTO usuario (firstname, lastname, active, email, username, password, updatedAt, createdAt) VALUES (:nombre, :apellido, :active, :email, :usuario, :clave, :updated_at, :created_at)", array(':nombre'=> $datos["nombre"], ':apellido'=> $datos["apellido"], ':active'=>$datos["habilitado"], ':email'=> $datos["email"], ':usuario' => $datos["usuario"], ':clave'=> $datos["clave"], ':updated_at'=>$datos["updated_at"], ':created_at'=>$datos["created_at"]) );
        
    }
    public function getUsuarioWithId($id){
        $usuario=$this->aRecord("SELECT * FROM usuario WHERE id = ?", array($id));
        return $usuario;
    }
    public function listadoUsuarios($pag, $cantidadPaginas){
        $sqlCantidad= "SELECT COUNT(*) FROM usuario";
        $condition=" ";
        $datos=$this->listado($sqlCantidad, [0], $condition, 'usuario' ,$cantidadPaginas, $pag);
        return $datos;
    }
    public function modificarUsuario($datos){
        $this->add( "UPDATE usuario SET firstname=:nombre, lastname= :apellido, active= :habilitado, email= :email, username =:usuario, password= :clave, updatedAt= :updated_at, createdAt= :created_at WHERE id =:id", array( ':nombre'=>$datos["nombre"], ':apellido'=>$datos["apellido"], ':habilitado'=>$datos["habilitado"], ':email'=>$datos["email"], ':usuario'=> $datos["usuario"], ':clave'=>$datos["clave"], ':updated_at'=>$datos["updated_at"], ':created_at'=>$datos["created_at"], ':id'=>$datos["id"] ) );
    }
    public function eliminarUsuarioWithId($id){
        $this->add("DELETE FROM usuario WHERE id = :id", array(':id'=>$id));
    }

    public function existeNombreUsuario($nombre_usuario){
        $cant= $this->cantItems("SELECT COUNT(*) FROM usuario WHERE username=?", array($nombre_usuario));
        if ($cant>0){
            return true;
        }else{
            return false;
        }
    }
    public function existePassword($username, $password){
        $cant=$this->cantItems("SELECT COUNT(*) FROM usuario WHERE username=? and password=?", array($username, $password));
        if ($cant>0){
            return true;
        }else{
            return false;
        }
    }
    public function getUserLogin($username, $password){
        $user=$this->aRecord( "SELECT * FROM usuario WHERE username=? and password=?", array($username, $password) );
        return $user;
    }
    public function idUsuarioUltimo($datos){
        $id_ultimo_usuario=$this->aRecord("SELECT id FROM usuario WHERE firstname=? and lastname=? and active=? and email=? and username=? and password=? and updatedAt=? and createdAt=?", 
        array($datos["nombre"], $datos["apellido"], $datos["habilitado"], $datos["email"], $datos["usuario"], $datos["clave"], $datos["updated_at"], $datos["created_at"]));
        return $id_ultimo_usuario["id"];
    }
    public function getUsuarioWithName($nombre_usuario){
        $usuario=$this->aRecord("SELECT * FROM usuario WHERE username = ?", array($nombre_usuario));
        return $usuario;
    }
    
    public function getRoles(){
        $roles = $this->queryList("SELECT * FROM rol", []);
        return $roles;
    }

    public function getRolesUserWithId($id){
	//Obtengo id de los roles de un usuario, y a partir de ellos, los nombres de cada uno
		$id_roles = $this->queryList("SELECT rol_id FROM usuario_tiene_rol WHERE usuario_id=?", array($id));
        $roles=[];
        foreach ($id_roles as $registro_rol) {
            $rol_id=$registro_rol["rol_id"];
            $nombre_rol=$this->aRecord("SELECT nombre FROM rol WHERE id=?", array($rol_id));
            $roles[]=$nombre_rol["nombre"];
        }
        return $roles;
    }
    public function asignarRolesUsuario($id_usuario, $id_roles){
        $this->eliminarRolesUsuarioWithId($id_usuario);
        $this->eliminarPermisosUsuarioWithId($id_usuario);
        foreach ($id_roles as $id) {
            $this->add( "INSERT INTO usuario_tiene_rol (usuario_id, rol_id) VALUES (:usuario_id, :rol_id)", array(':usuario_id'=> $id_usuario, ':rol_id'=>$id) );
        }
        $this->generarPermisosUsuario($id_usuario, $id_roles);
    }
    public function eliminarRolesUsuarioWithId($id){
        $this->add("DELETE FROM usuario_tiene_rol WHERE usuario_id = :id", array(':id'=>$id));
    }

    public function getPermisos(){
        $roles = $this->queryList("SELECT * FROM permisos", []);
        return $roles;
    }
    public function getPermisosUserWithId($id){	
	//Obtengo id de los permisos de un usuario, y a partir de ellos, los nombres de cada uno
        $id_permisos = $this->queryList("SELECT permiso_id FROM usuario_tiene_permiso WHERE usuario_id=?", array($id));
        $permisos=[];
        foreach ($id_permisos as $registro_permiso) {
            $permiso_id		=	$registro_permiso["permiso_id"];
            $nombre_permiso	=	$this->aRecord("SELECT nombre FROM permiso WHERE id=?", array($permiso_id));
            $permisos[]		=	$nombre_permiso["nombre"];
        }
        return $permisos;
    }
    public function generarPermisosUsuario($id_usuario, $id_roles){
        if ( in_array(1, $id_roles) ){ //administrador
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>3) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>6) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>7) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>8) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>9) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>10) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>12) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>18) );
        }
        if( in_array(2, $id_roles) || in_array(3, $id_roles) ){  //pediatra o recepcionista
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>1) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>2) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>4) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>5) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>11) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>13) );
            $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>14) );
            if( in_array(2, $id_roles) ){ //pediatra
                 $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>15) );
                 $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>16) ); 
                 $this->add( "INSERT INTO usuario_tiene_permiso (usuario_id, permiso_id) VALUES (:usuario_id, :permiso_id)", array(':usuario_id'=> $id_usuario, ':permiso_id'=>17) );   
            }
        }
    }
    public function eliminarPermisosUsuarioWithId($id){
        $this->add("DELETE FROM usuario_tiene_permiso WHERE usuario_id = :id", array(':id'=>$id));
    }
 
    public function listadoUsuariosByUsername($usuario, $pag, $cantidadPaginas){
        $sqlCantidad	= 	"SELECT COUNT(*) FROM usuario WHERE username Like '%{$usuario}%'";
        $condition		=	" WHERE username Like '%{$usuario}%'";
        $datos			=	$this->listado($sqlCantidad, [0], $condition, 'usuario' ,$cantidadPaginas, $pag);
        return $datos;
    }
     
    public function listadoUsuariosByEstado($estado, $pag, $cantidadPaginas){
        $sqlCantidad	=	"SELECT COUNT(*) FROM usuario WHERE active = ".$estado;
        $condition		=	" WHERE active = ".$estado;
        $datos			=	$this->listado($sqlCantidad, [0], $condition, 'usuario' ,$cantidadPaginas, $pag);
        return $datos;
    }
//FIN USUARIO

//METODO COMUN PARA PAGINAR
    public function listado($sqlCantidad, $argsCantidad, $condition, $item, $tamaño_pagina, $pag){
        $cantidadListado= $this->cantItems($sqlCantidad, $argsCantidad);
        $items;
        $pagina;
        if ($cantidadListado > 0){
            $inicio;
            if ($pag == ""){
                $inicio=0;
                $pagina=1;
            }
            else{
                $pagina = $pag;
                $inicio = ($pagina - 1) * $tamaño_pagina;
            }
            $queryItems;
            $queryItems="SELECT * FROM ".$item." ".$condition." LIMIT $inicio,$tamaño_pagina";
            $items=$this->queryList($queryItems, []);
            $total_paginas= ceil($cantidadListado / $tamaño_pagina);
            return array('items'=>$items, 'totalPaginas'=>$total_paginas, 'paginaActual'=>$pagina);
        }
        return array();
    }
//FIN PAGINAR.

//METODOS EXCLUSIVOS SOBRE PACIENTES
    public function agregarPaciente($datos){
        $this->add( "INSERT INTO paciente (apellido, nombre, fecha_nac, genero, tipo_doc, numero_doc, domicilio, telcel, obra_social, id_demografico) VALUES (:apellido, :nombre, :fecha_nac, :genero, :tipo_doc, :numero_doc, :domicilio, :telcel, :obra_social, :id_demografico)", 
            array(':apellido'=> $datos["apellido"], ':nombre'=> $datos["nombre"], ':fecha_nac'=>$datos["fecha_nac"], ':genero'=> $datos["genero"], ':tipo_doc' => $datos["tipo_doc"], ':numero_doc'=> $datos["numero_doc"], ':domicilio'=>$datos["domicilio"], ':telcel'=>$datos["telcel"], ':obra_social'=>$datos["obra_social"], ':id_demografico'=>$datos["id_demografico"]) );
    }

    public function listadoPacientes($pag, $cantidadPaginas){
        $sqlCantidad	=	"SELECT COUNT(*) FROM paciente";
        $condition		=	" ";
        $datos			=	$this->listado($sqlCantidad, [], $condition, 'paciente',$cantidadPaginas, $pag);
        return $datos;
    }
    
    public function idPacienteUltimo($datos){
        $id_paciente_reciente = $this->aRecord("SELECT id FROM paciente WHERE nombre=? AND apellido=? AND tipo_doc=? AND numero_doc=?", array($datos["nombre"], $datos["apellido"], $datos["tipo_doc"], $datos["numero_doc"]) );
        return $id_paciente_reciente["id"];
    }

     public function eliminarPacienteWithId($id){
        $this->add("DELETE FROM paciente WHERE id = :id", array(':id'=>$id));
    }

    public function existePaciente($nombre, $apellido, $tipo_doc, $numero_doc){
        $cantNyA	= $this->listar("SELECT COUNT(*) FROM paciente WHERE nombre=:nombre AND apellido=:apellido", array('nombre'=>$nombre, 'apellido'=>$apellido) );
        $cantTyN	= $this->listar("SELECT COUNT(*) FROM paciente WHERE tipo_doc=:tipo_doc AND numero_doc=:numero_doc", array('tipo_doc'=>$tipo_doc, 'numero_doc'=>$numero_doc));
        return ($cantNyA+$cantTyN);
    }

    public function getPacienteWithId($id){
        $paciente = $this->aRecord("SELECT * FROM paciente WHERE id = ?", array($id));
        return $paciente;
    }

    public function getNombreWithId($id){
        $nombre = $this->aRecord("SELECT nombre FROM paciente WHERE id = ?", array($id));
        return $nombre;
    }

    public function getFechaNacimiento($id){
        $fecha = $this->aRecord("SELECT fecha_nac FROM paciente WHERE id = ?", array($id));
        return $fecha;   
    }

    public function modificarPaciente($datos){
        $this->add( "UPDATE paciente SET apellido=:apellido, nombre= :nombre, fecha_nac=:fecha_nac, genero=:genero, tipo_doc=:tipo_doc, numero_doc=:numero_doc, domicilio=:domicilio, telcel= :telcel, obra_social=:obra_social WHERE id =:id", array( ':apellido'=> $datos["apellido"], ':nombre'=> $datos["nombre"], ':fecha_nac'=>$datos["fecha_nac"], ':genero'=> $datos["genero"], ':tipo_doc' => $datos["tipo_doc"], ':numero_doc'=> $datos["numero_doc"], ':domicilio'=>$datos["domicilio"], ':telcel'=>$datos["telcel"], ':obra_social'=>$datos["obra_social"], ':id'=>$datos["id"] ) );
    }

    public function listadoPacientesByNyA($nombre, $apellido, $pag, $cantidadPaginas){
        $sqlCantidad 	=	"SELECT COUNT(*) FROM paciente WHERE nombre Like '%{$nombre}%' AND apellido Like '%{$apellido}%'";
        $condition 		=	" WHERE nombre Like '%{$nombre}%' AND apellido Like '%{$apellido}%'";
        $datos			=	$this->listado($sqlCantidad, [0], $condition, 'paciente' ,$cantidadPaginas, $pag);
        return $datos;
    }

    public function listadoPacientesByTyN($tipo_doc, $numero_doc, $pag, $cantidadPaginas){
        $sqlCantidad	=	"SELECT COUNT(*) FROM paciente WHERE tipo_doc = '{$tipo_doc}' AND numero_doc = '{$numero_doc}'";
        $condition		=	" WHERE tipo_doc = '{$tipo_doc}' AND numero_doc = '{$numero_doc}'";
        $datos			=	$this->listado($sqlCantidad, [0], $condition, 'paciente' ,$cantidadPaginas, $pag);
        return $datos;
    }

//METODOS SOBRE DATOS DEMOGRAFICOS
    public function agregarDatosDemograficos($datos, $id_paciente){
        $this->add( "INSERT INTO demografico (id, heladera, electricidad, mascota, tipo_vivienda, tipo_calefaccion, tipo_agua, id_paciente) VALUES (:id, :heladera, :electricidad, :mascota, :tipo_vivienda, :tipo_calefaccion, :tipo_agua, :id_paciente)", 
            array(':id'=>$datos["id_demografico"], ':heladera'=> $datos["heladera"], ':electricidad'=>$datos["electricidad"], ':mascota'=>$datos["mascota"], ':tipo_vivienda'=>$datos["tipo_vivienda"], ':tipo_calefaccion'=>$datos["tipo_calefaccion"], ':tipo_agua'=>$datos["tipo_agua"],':id_paciente'=>$id_paciente) );
    }

    public function generarDatosDemograficos($datos, $id_paciente){
        $this->add( "INSERT INTO demografico (heladera, electricidad, mascota, tipo_vivienda, tipo_calefaccion, tipo_agua, id_paciente) VALUES (:heladera, :electricidad, :mascota, :tipo_vivienda, :tipo_calefaccion, :tipo_agua, :id_paciente)", 
            array(':heladera'=> $datos["heladera"], ':electricidad'=>$datos["electricidad"], ':mascota'=>$datos["mascota"], ':tipo_vivienda'=>$datos["tipo_vivienda"], ':tipo_calefaccion'=>$datos["tipo_calefaccion"], ':tipo_agua'=>$datos["tipo_agua"],':id_paciente'=>$id_paciente) );
    }

    public function getDatosDemograficosPaciente($id_paciente){
        $datos = $this->aRecord("SELECT * FROM demografico WHERE id_paciente = ?", array($id_paciente));
        return $datos;
    }

    public function modificarDemografico($datos){
        $this->add( "UPDATE demografico SET heladera=:heladera, electricidad=:electricidad, mascota=:mascota, tipo_vivienda=:tipo_vivienda, tipo_calefaccion=:tipo_calefaccion, tipo_agua=:tipo_agua  WHERE id_paciente =:id_paciente", array( ':heladera'=> $datos["heladera"], ':electricidad'=>$datos["electricidad"], ':mascota'=>$datos["mascota"], ':tipo_vivienda'=>$datos["tipo_vivienda"], ':tipo_calefaccion'=>$datos["tipo_calefaccion"], ':tipo_agua'=>$datos["tipo_agua"], ':id_paciente'=>$datos["id_paciente"]) ); 
    }

    public function eliminarDemograficoWithId($id){
        $this->add("DELETE FROM demografico WHERE id = :id", array(':id'=>$id));
    }
    
    public function eliminarDemograficoWithPaciente($id_paciente){
        $this->add("DELETE FROM demografico WHERE id_paciente = :id_paciente", array(':id_paciente' => $id_paciente) );
    }

    public function eliminarDemograficoInPaciente($id_paciente){//d
        $this->add("UPDATE paciente SET id_demografico=:id_demografico WHERE id_paciente = :id_paciente", array(':id_paciente'=>$id_paciente, ':id_demografico'=>null));
    }

    public function getIdDemograficosWithPaciente($id_paciente){
        $datos = $this->aRecord("SELECT id FROM demografico WHERE id_paciente=?", array($id_paciente) );
        return $datos["id"]; 
    }

    public function agregarIdDemografico($id_paciente, $id_demografico){
         $this->add( "UPDATE paciente SET id_demografico=:id_demografico WHERE id =:id_paciente", array( ':id_demografico'=> $id_demografico, 'id_paciente'=>$id_paciente) );
    }

//METODOS SOBRE HISTORIA CLINICA
    public function listadoHistoria($id_paciente, $pag, $cantidadPaginas){
        $sqlCantidad = "SELECT COUNT(*) FROM historia WHERE id_paciente = '{$id_paciente}'";
        $condition= " WHERE id_paciente = '{$id_paciente}' ";
        $datos=$this->listado($sqlCantidad, [], $condition, 'historia',$cantidadPaginas, $pag);
        return $datos;
    }

    public function getHistorias($id_paciente){
        $lista = $this->queryList("SELECT * FROM historia WHERE id_paciente =?", array($id_paciente) );
        return $lista;
    }

    public function getHistoriaWithId($id){
        $historia = $this->aRecord("SELECT * FROM historia WHERE id = ?", array($id));
        return $historia;
    }

    public function agregarHistoria($datos){
        $this->add( "INSERT INTO historia (fecha, peso, vacunas, vacunas_obs, maduracion, maduracion_obs, examen_f, examen_f_obs, pc, ppc, talla, alimentacion, obs_grales, id_usuario, id_paciente) VALUES (:fecha, :peso, :vacunas, :vacunas_obs, :maduracion, :maduracion_obs, :examen_f, :examen_f_obs, :pc, :ppc, :talla, :alimentacion, :obs_grales, :id_usuario, :id_paciente)",
                array(':fecha'=>$datos["fecha"], ':peso'=>$datos["peso"], ':vacunas'=>$datos["vacunas"], ':vacunas_obs'=>$datos["vacunas_obs"], ':maduracion'=>$datos["maduracion"], ':maduracion_obs'=>$datos["maduracion_obs"], ':examen_f'=>$datos["examen_f"], ':examen_f_obs'=>$datos["examen_f_obs"], ':pc'=>$datos["pc"], ':ppc'=>$datos["ppc"], ':talla'=>$datos["talla"], ':alimentacion'=>$datos["alimentacion"], ':obs_grales'=>$datos["obs_grales"], ':id_usuario'=>$datos["id_usuario"], ':id_paciente'=>$datos["id_paciente"]) );
    }

    public function modificarHistoria($datos){
        $this->add("UPDATE historia SET fecha=:fecha, peso=:peso, vacunas=:vacunas, vacunas_obs=:vacunas_obs, maduracion=:maduracion, maduracion_obs=:maduracion_obs, examen_f=:examen_f, examen_f_obs=:examen_f_obs, pc=:pc, ppc=:ppc, talla=:talla, alimentacion=:alimentacion, obs_grales=:obs_grales, id_usuario=:id_usuario, id_paciente=:id_paciente 
            WHERE id = :id", array(':fecha'=>$datos['fecha'], ':peso'=>$datos["peso"], ':vacunas'=>$datos["vacunas"], ':vacunas_obs'=>$datos["vacunas_obs"], ':maduracion'=>$datos["maduracion"], ':maduracion_obs'=>$datos["maduracion_obs"], ':examen_f'=>$datos["examen_f"], ':examen_f_obs'=>$datos["examen_f_obs"], ':pc'=>$datos["pc"], ':ppc'=>$datos["ppc"], ':talla'=>$datos["talla"], ':alimentacion'=>$datos["alimentacion"], ':obs_grales'=>$datos["obs_grales"], ':id_usuario'=>$datos["id_usuario"], ':id_paciente'=>$datos["id_paciente"], ':id'=>$datos["id"]) );
    }

    public function eliminarHistoriaWithId($id){
        $this->add("DELETE FROM historia WHERE id = :id", array(':id' => $id) );
    }
}
