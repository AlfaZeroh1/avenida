<?php 
require_once("LaboratorytestsDBO.php");
class Laboratorytests
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $charge;			
	var $laboratorytestsDBO;
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

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get charge
	function getCharge(){
		return $this->charge;
	}
	//set charge
	function setCharge($charge){
		$this->charge=$charge;
	}

	function add($obj){			
		$laboratorytestsDBO = new LaboratorytestsDBO();
		if($laboratorytestsDBO->persist($obj))		
			return true;	
	}			
	function edit($obj){			
		$laboratorytestsDBO = new LaboratorytestsDBO();
		if($laboratorytestsDBO->update($obj))		
			return true;	
	}			
	function delete($obj){			
		$laboratorytestsDBO = new LaboratorytestsDBO();
		if($laboratorytestsDBO->delete($obj))		
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$laboratorytestsDBO = new LaboratorytestsDBO();
		$this->table=$laboratorytestsDBO->table;
		$laboratorytestsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->result=$laboratorytestsDBO->result;
		$this->fetchObject=$laboratorytestsDBO->fetchObject;
		$this->affectedRows=$laboratorytestsDBO->affectedRows;
	}			
}				
?>
