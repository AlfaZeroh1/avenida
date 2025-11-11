<?php 
require_once("LoantypesDBO.php");
class Loantypes
{				
	var $id;			
	var $name;			
	var $loantypesDBO;
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
		$loantypesDBO = new LoantypesDBO();
		if($loantypesDBO->persist($obj)){
			$this->id=$loantypesDBO->id;
			$this->sql=$loantypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$loantypesDBO = new LoantypesDBO();
		if($loantypesDBO->update($obj,$where)){
			$this->sql=$loantypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$loantypesDBO = new LoantypesDBO();
		if($loantypesDBO->delete($obj,$where=""))		
			$this->sql=$loantypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$loantypesDBO = new LoantypesDBO();
		$this->table=$loantypesDBO->table;
		$loantypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$loantypesDBO->sql;
		$this->result=$loantypesDBO->result;
		$this->fetchObject=$loantypesDBO->fetchObject;
		$this->affectedRows=$loantypesDBO->affectedRows;
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
