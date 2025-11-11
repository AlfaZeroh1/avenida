<?php 
require_once("PatientbedsDBO.php");
class Patientbeds
{				
	var $id;			
	var $bedid;			
	var $patientid;			
	var $treatmentid;			
	var $allocatedon;			
	var $lefton;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $patientbedsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->bedid=str_replace("'","\'",$obj->bedid);
		$this->patientid=str_replace("'","\'",$obj->patientid);
		$this->treatmentid=str_replace("'","\'",$obj->treatmentid);
		$this->allocatedon=str_replace("'","\'",$obj->allocatedon);
		$this->lefton=str_replace("'","\'",$obj->lefton);
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

	//get bedid
	function getBedid(){
		return $this->bedid;
	}
	//set bedid
	function setBedid($bedid){
		$this->bedid=$bedid;
	}

	//get patientid
	function getPatientid(){
		return $this->patientid;
	}
	//set patientid
	function setPatientid($patientid){
		$this->patientid=$patientid;
	}

	//get treatmentid
	function getTreatmentid(){
		return $this->treatmentid;
	}
	//set treatmentid
	function setTreatmentid($treatmentid){
		$this->treatmentid=$treatmentid;
	}

	//get allocatedon
	function getAllocatedon(){
		return $this->allocatedon;
	}
	//set allocatedon
	function setAllocatedon($allocatedon){
		$this->allocatedon=$allocatedon;
	}

	//get lefton
	function getLefton(){
		return $this->lefton;
	}
	//set lefton
	function setLefton($lefton){
		$this->lefton=$lefton;
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
		$patientbedsDBO = new PatientbedsDBO();
		if($patientbedsDBO->persist($obj)){
			$this->id=$patientbedsDBO->id;
			$this->sql=$patientbedsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$patientbedsDBO = new PatientbedsDBO();
		if($patientbedsDBO->update($obj,$where)){
			$this->sql=$patientbedsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$patientbedsDBO = new PatientbedsDBO();
		if($patientbedsDBO->delete($obj,$where=""))		
			$this->sql=$patientbedsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientbedsDBO = new PatientbedsDBO();
		$this->table=$patientbedsDBO->table;
		$patientbedsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patientbedsDBO->sql;
		$this->result=$patientbedsDBO->result;
		$this->fetchObject=$patientbedsDBO->fetchObject;
		$this->affectedRows=$patientbedsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
