<?php 
require_once("SalemodesDBO.php");
class Salemodes
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $salemodesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	function add($obj){
		$salemodesDBO = new SalemodesDBO();
		if($salemodesDBO->persist($obj)){
			$this->id=$salemodesDBO->id;
			$this->sql=$salemodesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$salemodesDBO = new SalemodesDBO();
		if($salemodesDBO->update($obj,$where)){
			$this->sql=$salemodesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$salemodesDBO = new SalemodesDBO();
		if($salemodesDBO->delete($obj,$where=""))		
			$this->sql=$salemodesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$salemodesDBO = new SalemodesDBO();
		$this->table=$salemodesDBO->table;
		$salemodesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$salemodesDBO->sql;
		$this->result=$salemodesDBO->result;
		$this->fetchObject=$salemodesDBO->fetchObject;
		$this->affectedRows=$salemodesDBO->affectedRows;
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
