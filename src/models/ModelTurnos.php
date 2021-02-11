<?php


	
class ModelTurnos {
	/*
    const USERNAME = "root";
    const PASSWORD = "root";
	const HOST ="localhost";
	const DB = "grupo53";
	*/


	const USERNAME = "grupo53";
    const PASSWORD = "YjczYjk1YmMwMThl";
	const HOST ="localhost";
	const DB = "grupo53";

    

	private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {

    }

    private function getConnection(){
        $u=self::USERNAME;
        $p=self::PASSWORD;
        $db=self::DB;
        $host=self::HOST;
        $connection = new PDO("mysql:dbname=$db;host=$host", $u, $p);
        return $connection;
    }

    protected function aRecord($sql, $args){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($args);
        $result = [];
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    protected function queryList($sql, $args){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($args);
        $list = [];
        while($element = $stmt->fetch()){
            $list[] = $element;
        }
        return $list;
    }
	
	public function add($sql, $args){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        foreach ($args as $key => $value) {
            $stmt-> bindValue($key, $value);
        } 
        $stmt->execute();
    }

	
    public function reservarTurno($documento, $id_turno){
        $this->add("
					INSERT INTO turno_paciente (id_turno, documento_paciente) VALUES (:id_turno, :documento_paciente)", 
						array(
						':id_turno'=>$id_turno, 
						':documento_paciente'=>$documento)
				);
    }
    public function getIdTurno($datos){
        $id_turno = $this->aRecord("
									SELECT id FROM turno WHERE dia=? AND mes=? AND anio=? AND hora=? AND minutos=?", 
										array(
											$datos['dia'], 
											$datos['mes'], 
											$datos['año'], 
											$datos['hora'], 
											$datos['minutos'])
								);
        return $id_turno;
    }

    public function turnosExistentes(){ 
        $disponibles = $this->queryList("
										SELECT * FROM turno AS t WHERE NOT EXISTS (SELECT * FROM turno_paciente AS tp WHERE t.id = tp.id_turno)", 
										[] 
										);
        return $disponibles;
    }

}