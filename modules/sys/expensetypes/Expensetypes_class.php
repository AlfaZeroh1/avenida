<?php 
require_once("ExpensetypesDBO.php");
class Expensetypes
{				
	var $id;			
	var $name;			
	var $expensetypesDBO;
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
		$expensetypesDBO = new ExpensetypesDBO();
		if($expensetypesDBO->persist($obj)){
			$this->id=$expensetypesDBO->id;
			$this->sql=$expensetypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$expensetypesDBO = new ExpensetypesDBO();
		if($expensetypesDBO->update($obj,$where)){
			$this->sql=$expensetypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$expensetypesDBO = new ExpensetypesDBO();
		if($expensetypesDBO->delete($obj,$where=""))		
			$this->sql=$expensetypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$expensetypesDBO = new ExpensetypesDBO();
		$this->table=$expensetypesDBO->table;
		$expensetypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$expensetypesDBO->sql;
		$this->result=$expensetypesDBO->result;
		$this->fetchObject=$expensetypesDBO->fetchObject;
		$this->affectedRows=$expensetypesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
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
