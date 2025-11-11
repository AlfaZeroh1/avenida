<?php 
require_once("PatientclassesDBO.php");
class Patientclasses
{				
	var $id;			
	var $name;			
	var $fee;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $patientclassesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->fee=str_replace("'","\'",$obj->fee);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
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

	//get fee
	function getFee(){
		return $this->fee;
	}
	//set fee
	function setFee($fee){
		$this->fee=$fee;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get createdby
	function getCreatedby(){
		return $this->createdby;
	}
	//set createdby
	function setCreatedby($createdby){
		$this->createdby=$createdby;
	}

	//get createdon
	function getCreatedon(){
		return $this->createdon;
	}
	//set createdon
	function setCreatedon($createdon){
		$this->createdon=$createdon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	function add($obj){
		$patientclassesDBO = new PatientclassesDBO();
		if($patientclassesDBO->persist($obj)){
			$this->id=$patientclassesDBO->id;
			$this->sql=$patientclassesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$patientclassesDBO = new PatientclassesDBO();
		if($patientclassesDBO->update($obj,$where)){
			$this->sql=$patientclassesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$patientclassesDBO = new PatientclassesDBO();
		if($patientclassesDBO->delete($obj,$where=""))		
			$this->sql=$patientclassesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientclassesDBO = new PatientclassesDBO();
		$this->table=$patientclassesDBO->table;
		$patientclassesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patientclassesDBO->sql;
		$this->result=$patientclassesDBO->result;
		$this->fetchObject=$patientclassesDBO->fetchObject;
		$this->affectedRows=$patientclassesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Patient class should be provided";
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
