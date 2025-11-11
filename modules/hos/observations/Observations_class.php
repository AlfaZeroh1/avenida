<?php 
require_once("ObservationsDBO.php");
class Observations
{				
	var $id;			
	var $patientid;			
	var $patienttreatmentid;			
	var $observation;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $observationsDBO;
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

	//get patientid
	function getPatientid(){
		return $this->patientid;
	}
	//set patientid
	function setPatientid($patientid){
		$this->patientid=$patientid;
	}

	//get patienttreatmentid
	function getPatienttreatmentid(){
		return $this->patienttreatmentid;
	}
	//set patienttreatmentid
	function setPatienttreatmentid($patienttreatmentid){
		$this->patienttreatmentid=$patienttreatmentid;
	}

	//get observation
	function getObservation(){
		return $this->observation;
	}
	//set observation
	function setObservation($observation){
		$this->observation=$observation;
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
		$observationsDBO = new ObservationsDBO();
		if($observationsDBO->persist($obj))		
			return true;	
	}			
	function edit($obj){			
		$observationsDBO = new ObservationsDBO();
		if($observationsDBO->update($obj))		
			return true;	
	}			
	function delete($obj){			
		$observationsDBO = new ObservationsDBO();
		if($observationsDBO->delete($obj))		
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$observationsDBO = new ObservationsDBO();
		$this->table=$observationsDBO->table;
		$observationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->result=$observationsDBO->result;
		$this->fetchObject=$observationsDBO->fetchObject;
		$this->affectedRows=$observationsDBO->affectedRows;
	}			
}				
?>
