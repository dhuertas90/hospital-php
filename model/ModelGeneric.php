<?php
	
/**
 * Description of ModelGeneric
 *
 * Utilizacion de PDO
 *
 * @author huertas-sosa
 */


abstract class ModelGeneric {
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
        $result=[];
        $result =$stmt->fetch(PDO::FETCH_ASSOC);
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

    public function cantItems($sql, $args){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetchColumn();

    }
    public function add($sql, $args){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        foreach ($args as $key => $value) {
            $stmt-> bindValue($key, $value);
        } 
        $stmt->execute();
    }
    
    public function listar($sql, $args){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        foreach ($args as $key => $value) {
            $stmt-> bindValue($key, $value);
        } 
        $stmt->execute();
        $list = array();
        while($element = $stmt->fetch(PDO::FETCH_ASSOC)){
            $list[] = $element;
        }
        return $list;
    }
    
}
