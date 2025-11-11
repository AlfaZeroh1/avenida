<?php 
require_once("CountysDBO.php");
class Countys
{				
	var $id;			
	var $name;			
	var $countysDBO;
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
		$countysDBO = new CountysDBO();
		if($countysDBO->persist($obj)){
			$this->id=$countysDBO->id;
			$this->sql=$countysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$countysDBO = new CountysDBO();
		if($countysDBO->update($obj,$where)){
			$this->sql=$countysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$countysDBO = new CountysDBO();
		if($countysDBO->delete($obj,$where=""))		
			$this->sql=$countysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$countysDBO = new CountysDBO();
		$this->table=$countysDBO->table;
		$countysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$countysDBO->sql;
		$this->result=$countysDBO->result;
		$this->fetchObject=$countysDBO->fetchObject;
		$this->affectedRows=$countysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="County should be provided";
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
