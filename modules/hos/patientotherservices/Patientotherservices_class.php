<?php 
require_once("PatientotherservicesDBO.php");
class Patientotherservices
{				
	var $id;			
	var $documentno;			
	var $patientid;			
	var $patienttreatmentid;			
	var $otherserviceid;			
	var $charge;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $patientotherservicesDBO;
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
		$this->patienttreatmentid=str_replace("'","\'",$obj->patienttreatmentid);
		if(empty($obj->otherserviceid))
			$obj->otherserviceid='NULL';
		$this->otherserviceid=$obj->otherserviceid;
		$this->charge=str_replace("'","\'",$obj->charge);
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

	//get otherserviceid
	function getOtherserviceid(){
		return $this->otherserviceid;
	}
	//set otherserviceid
	function setOtherserviceid($otherserviceid){
		$this->otherserviceid=$otherserviceid;
	}

	//get charge
	function getCharge(){
		return $this->charge;
	}
	//set charge
	function setCharge($charge){
		$this->charge=$charge;
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
		$patientotherservicesDBO = new PatientotherservicesDBO();
		if($patientotherservicesDBO->persist($obj)){
			$this->id=$patientotherservicesDBO->id;
			$this->sql=$patientotherservicesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$patientotherservicesDBO = new PatientotherservicesDBO();
		if($patientotherservicesDBO->update($obj,$where)){
			$this->sql=$patientotherservicesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$patientotherservicesDBO = new PatientotherservicesDBO();
		if($patientotherservicesDBO->delete($obj,$where=""))		
			$this->sql=$patientotherservicesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientotherservicesDBO = new PatientotherservicesDBO();
		$this->table=$patientotherservicesDBO->table;
		$patientotherservicesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patientotherservicesDBO->sql;
		$this->result=$patientotherservicesDBO->result;
		$this->fetchObject=$patientotherservicesDBO->fetchObject;
		$this->affectedRows=$patientotherservicesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Service No should be provided";
		}
		else if(empty($obj->patientid)){
			$error=" should be provided";
		}
		else if(empty($obj->otherserviceid)){
			$error="Service should be provided";
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
