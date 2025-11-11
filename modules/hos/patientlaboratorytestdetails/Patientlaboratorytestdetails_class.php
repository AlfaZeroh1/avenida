<?php 
require_once("PatientlaboratorytestdetailsDBO.php");
class Patientlaboratorytestdetails
{				
	var $id;			
	var $patientlaboratorytestid;			
	var $laboratorytestdetailid;			
	var $results;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $patientlaboratorytestdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->patientlaboratorytestid))
			$obj->patientlaboratorytestid='NULL';
		$this->patientlaboratorytestid=$obj->patientlaboratorytestid;
		if(empty($obj->laboratorytestdetailid))
			$obj->laboratorytestdetailid='NULL';
		$this->laboratorytestdetailid=$obj->laboratorytestdetailid;
		$this->result=str_replace("'","\'",$obj->result);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get patientlaboratorytestid
	function getPatientlaboratorytestid(){
		return $this->patientlaboratorytestid;
	}
	//set patientlaboratorytestid
	function setPatientlaboratorytestid($patientlaboratorytestid){
		$this->patientlaboratorytestid=$patientlaboratorytestid;
	}

	//get laboratorytestdetailid
	function getLaboratorytestdetailid(){
		return $this->laboratorytestdetailid;
	}
	//set laboratorytestdetailid
	function setLaboratorytestdetailid($laboratorytestdetailid){
		$this->laboratorytestdetailid=$laboratorytestdetailid;
	}

	//get result
	function getResult(){
		return $this->result;
	}
	//set result
	function setResult($result){
		$this->result=$result;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
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
		$patientlaboratorytestdetailsDBO = new PatientlaboratorytestdetailsDBO();
		if($patientlaboratorytestdetailsDBO->persist($obj)){
			$this->id=$patientlaboratorytestdetailsDBO->id;
			$this->sql=$patientlaboratorytestdetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$patientlaboratorytestdetailsDBO = new PatientlaboratorytestdetailsDBO();
		if($patientlaboratorytestdetailsDBO->update($obj,$where)){
			$this->sql=$patientlaboratorytestdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$patientlaboratorytestdetailsDBO = new PatientlaboratorytestdetailsDBO();
		if($patientlaboratorytestdetailsDBO->delete($obj,$where=""))		
			$this->sql=$patientlaboratorytestdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientlaboratorytestdetailsDBO = new PatientlaboratorytestdetailsDBO();
		$this->table=$patientlaboratorytestdetailsDBO->table;
		$patientlaboratorytestdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patientlaboratorytestdetailsDBO->sql;
		$this->results=$patientlaboratorytestdetailsDBO->result;
		$this->fetchObject=$patientlaboratorytestdetailsDBO->fetchObject;
		$this->affectedRows=$patientlaboratorytestdetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->patientlaboratorytestid)){
			$error="Patient Lab Test should be provided";
		}
		else if(empty($obj->laboratorytestdetailid)){
			$error="Laboratory Test Detail should be provided";
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
