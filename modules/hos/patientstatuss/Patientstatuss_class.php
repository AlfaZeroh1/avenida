<?php 
require_once("PatientstatussDBO.php");
class Patientstatuss
{				
	var $id;			
	var $name;			
	var $patientstatussDBO;
	var $fetchObject;
	var $result;
	var $table;
	var $affectedRows;

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
		$patientstatussDBO = new PatientstatussDBO();
		if($patientstatussDBO->persist($obj))		
			return true;	
	}			
	function edit($obj){			
		$patientstatussDBO = new PatientstatussDBO();
		if($patientstatussDBO->update($obj))		
			return true;	
	}			
	function delete($obj){			
		$patientstatussDBO = new PatientstatussDBO();
		if($patientstatussDBO->delete($obj))		
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientstatussDBO = new PatientstatussDBO();
		$this->table=$patientstatussDBO->table;
		$patientstatussDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->result=$patientstatussDBO->result;
		$this->fetchObject=$patientstatussDBO->fetchObject;
		$this->affectedRows=$patientstatussDBO->affectedRows;
	}			
}				
?>
