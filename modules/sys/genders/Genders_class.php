<?php 
require_once("GendersDBO.php");
class Genders
{				
	var $id;			
	var $name;			
	var $gendersDBO;
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
		$gendersDBO = new GendersDBO();
		if($gendersDBO->persist($obj)){
			$this->id=$gendersDBO->id;
			$this->sql=$gendersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$gendersDBO = new GendersDBO();
		if($gendersDBO->update($obj,$where)){
			$this->sql=$gendersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$gendersDBO = new GendersDBO();
		if($gendersDBO->delete($obj,$where=""))		
			$this->sql=$gendersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$gendersDBO = new GendersDBO();
		$this->table=$gendersDBO->table;
		$gendersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$gendersDBO->sql;
		$this->result=$gendersDBO->result;
		$this->fetchObject=$gendersDBO->fetchObject;
		$this->affectedRows=$gendersDBO->affectedRows;
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
