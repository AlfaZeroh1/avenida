<?php 
require_once("AutocompleteDBO.php");
class Autocomplete
{				
	var $id;			
	var $name;			
	var $autocompleteDBO;
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
		$autocompleteDBO = new AutocompleteDBO();
		if($autocompleteDBO->persist($obj)){
			$this->id=$autocompleteDBO->id;
			$this->sql=$autocompleteDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$autocompleteDBO = new AutocompleteDBO();
		if($autocompleteDBO->update($obj,$where)){
			$this->sql=$autocompleteDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$autocompleteDBO = new AutocompleteDBO();
		if($autocompleteDBO->delete($obj,$where=""))		
			$this->sql=$autocompleteDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$autocompleteDBO = new AutocompleteDBO();
		$this->table=$autocompleteDBO->table;
		$autocompleteDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$autocompleteDBO->sql;
		$this->result=$autocompleteDBO->result;
		$this->fetchObject=$autocompleteDBO->fetchObject;
		$this->affectedRows=$autocompleteDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
