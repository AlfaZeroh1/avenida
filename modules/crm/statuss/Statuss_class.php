<?php 
require_once("StatussDBO.php");
class Statuss
{				
	var $id;			
	var $name;			
	var $statussDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		return $this;
	
	}
	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	function add($obj){
		$statussDBO = new StatussDBO();
		if($statussDBO->persist($obj)){
			$this->id=$statussDBO->id;
			$this->sql=$statussDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$statussDBO = new StatussDBO();
		if($statussDBO->update($obj,$where)){
			$this->sql=$statussDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$statussDBO = new StatussDBO();
		if($statussDBO->delete($obj,$where=""))		
			$this->sql=$statussDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$statussDBO = new StatussDBO();
		$this->table=$statussDBO->table;
		$statussDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$statussDBO->sql;
		$this->result=$statussDBO->result;
		$this->fetchObject=$statussDBO->fetchObject;
		$this->affectedRows=$statussDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
