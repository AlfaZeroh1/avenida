<?php 
require_once("FormsDBO.php");
class Forms
{				
	var $id;			
	var $name;			
	var $formsDBO;
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
		$formsDBO = new FormsDBO();
		if($formsDBO->persist($obj)){
			$this->id=$formsDBO->id;
			$this->sql=$formsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$formsDBO = new FormsDBO();
		if($formsDBO->update($obj,$where)){
			$this->sql=$formsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$formsDBO = new FormsDBO();
		if($formsDBO->delete($obj,$where=""))		
			$this->sql=$formsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$formsDBO = new FormsDBO();
		$this->table=$formsDBO->table;
		$formsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$formsDBO->sql;
		$this->result=$formsDBO->result;
		$this->fetchObject=$formsDBO->fetchObject;
		$this->affectedRows=$formsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
