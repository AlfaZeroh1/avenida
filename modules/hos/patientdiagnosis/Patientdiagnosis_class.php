<?php 
require_once("PatientdiagnosisDBO.php");
class Patientdiagnosis
{				
	var $id;			
	var $documentno;			
	var $patientid;			
	var $patienttreatmentid;			
	var $diagnosiid;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $patientdiagnosisDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->patientid))
			$obj->patientid='NULL';
		$this->patientid=$obj->patientid;
		if(empty($obj->patienttreatmentid))
			$obj->patienttreatmentid='NULL';
		$this->patienttreatmentid=$obj->patienttreatmentid;
		if(empty($obj->diagnosiid))
			$obj->diagnosiid='NULL';
		$this->diagnosiid=$obj->diagnosiid;
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
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

	//get diagnosiid
	function getDiagnosiid(){
		return $this->diagnosiid;
	}
	//set diagnosiid
	function setDiagnosiid($diagnosiid){
		$this->diagnosiid=$diagnosiid;
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
		$patientdiagnosisDBO = new PatientdiagnosisDBO();
		if($patientdiagnosisDBO->persist($obj)){
			$this->id=$patientdiagnosisDBO->id;
			$this->sql=$patientdiagnosisDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$patientdiagnosisDBO = new PatientdiagnosisDBO();
		if($patientdiagnosisDBO->update($obj,$where)){
			$this->sql=$patientdiagnosisDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$patientdiagnosisDBO = new PatientdiagnosisDBO();
		if($patientdiagnosisDBO->delete($obj,$where=""))		
			$this->sql=$patientdiagnosisDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientdiagnosisDBO = new PatientdiagnosisDBO();
		$this->table=$patientdiagnosisDBO->table;
		$patientdiagnosisDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patientdiagnosisDBO->sql;
		$this->result=$patientdiagnosisDBO->result;
		$this->fetchObject=$patientdiagnosisDBO->fetchObject;
		$this->affectedRows=$patientdiagnosisDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Service No should be provided";
		}
		else if(empty($obj->patientid)){
			$error=" should be provided";
		}
		else if(empty($obj->patienttreatmentid)){
			$error=" should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Service No should be provided";
		}
		else if(empty($obj->patientid)){
			$error=" should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
