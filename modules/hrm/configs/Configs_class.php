<?php 
require_once("ConfigsDBO.php");
class Configs
{				
	var $id;			
	var $name;			
	var $value;			
	var $configsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->value=str_replace("'","\'",$obj->value);
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

	//get value
	function getValue(){
		return $this->value;
	}
	//set value
	function setValue($value){
		$this->value=$value;
	}

	function add($obj){
		$configsDBO = new ConfigsDBO();
		if($configsDBO->persist($obj)){
			$this->id=$configsDBO->id;
			$this->sql=$configsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$configsDBO = new ConfigsDBO();
		if($configsDBO->update($obj,$where)){
			$this->sql=$configsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$configsDBO = new ConfigsDBO();
		if($configsDBO->delete($obj,$where=""))		
			$this->sql=$configsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$configsDBO = new ConfigsDBO();
		$this->table=$configsDBO->table;
		$configsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$configsDBO->sql;
		$this->result=$configsDBO->result;
		$this->fetchObject=$configsDBO->fetchObject;
		$this->affectedRows=$configsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
