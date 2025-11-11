<?php 
require_once("VenueopensDBO.php");
class Venueopens
{				
	var $id;			
	var $name;			
	var $venueopensDBO;
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
		$venueopensDBO = new VenueopensDBO();
		if($venueopensDBO->persist($obj)){
			$this->id=$venueopensDBO->id;
			$this->sql=$venueopensDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$venueopensDBO = new VenueopensDBO();
		if($venueopensDBO->update($obj,$where)){
			$this->sql=$venueopensDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$venueopensDBO = new VenueopensDBO();
		if($venueopensDBO->delete($obj,$where=""))		
			$this->sql=$venueopensDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$venueopensDBO = new VenueopensDBO();
		$this->table=$venueopensDBO->table;
		$venueopensDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$venueopensDBO->sql;
		$this->result=$venueopensDBO->result;
		$this->fetchObject=$venueopensDBO->fetchObject;
		$this->affectedRows=$venueopensDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
