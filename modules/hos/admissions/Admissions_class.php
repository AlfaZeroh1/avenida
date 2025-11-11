<?php 
require_once("AdmissionsDBO.php");
class Admissions
{				
	var $id;			
	var $wardid;			
	var $patientid;
	var $treatmentid;			
	var $admissiondate;			
	var $remarks;			
	var $status;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $admissionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->bedid=str_replace("'","\'",$obj->bedid);
		$this->treatmentid=str_replace("'","\'",$obj->treatmentid);
		$this->patientid=str_replace("'","\'",$obj->patientid);
		$this->admissiondate=str_replace("'","\'",$obj->admissiondate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get wardid
	function getBedid(){
		return $this->bedid;
	}
	//set wardid
	function setBedid($bedid){
		$this->bedid=$bedid;
	}

	//get treatmentid
	function getTreatmentid(){
		return $this->treatmentid;
	}
	//set treatmentid
	function setTreatmentid($treatmentid){
		$this->treatmentid=$treatmentid;
	}
	//get patientid
	function getPatientid(){
		return $this->patientid;
	}
	//set pateintid
	function setPatientid($patientid){
		$this->patientid=$patientid;
	}


	//get admissiondate
	function getAdmissiondate(){
		return $this->admissiondate;
	}
	//set admissiondate
	function setAdmissiondate($admissiondate){
		$this->admissiondate=$admissiondate;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		$admissionsDBO = new AdmissionsDBO();
		if($admissionsDBO->persist($obj)){
			$this->id=$admissionsDBO->id;
			$this->sql=$admissionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$admissionsDBO = new AdmissionsDBO();
		if($admissionsDBO->update($obj,$where)){
			$this->sql=$admissionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$admissionsDBO = new AdmissionsDBO();
		if($admissionsDBO->delete($obj,$where=""))		
			$this->sql=$admissionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$admissionsDBO = new AdmissionsDBO();
		$this->table=$admissionsDBO->table;
		$admissionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$admissionsDBO->sql;
		$this->result=$admissionsDBO->result;
		$this->fetchObject=$admissionsDBO->fetchObject;
		$this->affectedRows=$admissionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->wardid)){
			$error="Ward should be provided";
		}
		else if(empty($obj->admissiondate)){
			$error="Date should be provided";
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
