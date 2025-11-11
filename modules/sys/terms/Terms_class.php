<?php 
require_once("TermsDBO.php");
class Terms
{				
	var $id;			
	var $name;			
	var $termsDBO;
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
		$termsDBO = new TermsDBO();
		if($termsDBO->persist($obj)){
			$this->id=$termsDBO->id;
			$this->sql=$termsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$termsDBO = new TermsDBO();
		if($termsDBO->update($obj,$where)){
			$this->sql=$termsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$termsDBO = new TermsDBO();
		if($termsDBO->delete($obj,$where=""))		
			$this->sql=$termsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$termsDBO = new TermsDBO();
		$this->table=$termsDBO->table;
		$termsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$termsDBO->sql;
		$this->result=$termsDBO->result;
		$this->fetchObject=$termsDBO->fetchObject;
		$this->affectedRows=$termsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
