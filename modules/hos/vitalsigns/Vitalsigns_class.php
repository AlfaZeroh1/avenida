<?php 
require_once("VitalsignsDBO.php");
class Vitalsigns
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $vitalsignsDBO;
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
		$vitalsignsDBO = new VitalsignsDBO();
		if($vitalsignsDBO->persist($obj)){
			$this->id=$vitalsignsDBO->id;
			$this->sql=$vitalsignsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$vitalsignsDBO = new VitalsignsDBO();
		if($vitalsignsDBO->update($obj,$where)){
			$this->sql=$vitalsignsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$vitalsignsDBO = new VitalsignsDBO();
		if($vitalsignsDBO->delete($obj,$where=""))		
			$this->sql=$vitalsignsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$vitalsignsDBO = new VitalsignsDBO();
		$this->table=$vitalsignsDBO->table;
		$vitalsignsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$vitalsignsDBO->sql;
		$this->result=$vitalsignsDBO->result;
		$this->fetchObject=$vitalsignsDBO->fetchObject;
		$this->affectedRows=$vitalsignsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
