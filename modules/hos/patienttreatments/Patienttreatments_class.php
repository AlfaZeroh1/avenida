<?php 
require_once("PatienttreatmentsDBO.php");
class Patienttreatments
{				
	var $id;			
	var $patientid;			
	var $patientappointmentid;			
	var $symptoms;			
	var $hpi;			
	var $obs;			
	var $findings;			
	var $investigation;			
	var $diagnosiid;				
	var $diagnosis;	
	var $treatment;
	var $admission;			
	var $treatedon;			
	var $patientstatusid;			
	var $payconsultancy;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $patienttreatmentsDBO;
	var $fetchObject;
	var $labtests;
	var $prescription;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->patientid))
			$obj->patientid='NULL';
		$this->patientid=$obj->patientid;
		$this->patientappointmentid=str_replace("'","\'",$obj->patientappointmentid);
		$this->symptoms=str_replace("'","\'",$obj->symptoms);
		$this->hpi=str_replace("'","\'",$obj->hpi);
		$this->obs=str_replace("'","\'",$obj->obs);
		$this->findings=str_replace("'","\'",$obj->findings);
		$this->investigation=str_replace("'","\'",$obj->investigation);
		if(empty($obj->diagnosiid))
			$obj->diagnosiid='NULL';
		$this->diagnosiid=$obj->diagnosiid;
		$this->diagnosis=str_replace("'","\'",$obj->diagnosis);
		$this->treatment=str_replace("'","\'",$obj->treatment);
		$this->prescription=str_replace("'","\'",$obj->prescription);
		$this->labtests=str_replace("'","\'",$obj->labtests);
		$this->admission=str_replace("'","\'",$obj->admission);
		$this->treatedon=str_replace("'","\'",$obj->treatedon);
		if(empty($obj->patientstatusid))
			$obj->patientstatusid='NULL';
		$this->patientstatusid=$obj->patientstatusid;
		$this->payconsultancy=str_replace("'","\'",$obj->payconsultancy);
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

	//get patientid
	function getPatientid(){
		return $this->patientid;
	}
	//set patientid
	function setPatientid($patientid){
		$this->patientid=$patientid;
	}

	//get patientappointmentid
	function getPatientappointmentid(){
		return $this->patientappointmentid;
	}
	//set patientappointmentid
	function setPatientappointmentid($patientappointmentid){
		$this->patientappointmentid=$patientappointmentid;
	}

	//get symptoms
	function getSymptoms(){
		return $this->symptoms;
	}
	//set symptoms
	function setSymptoms($symptoms){
		$this->symptoms=$symptoms;
	}

	//get hpi
	function getHpi(){
		return $this->hpi;
	}
	//set hpi
	function setHpi($hpi){
		$this->hpi=$hpi;
	}

	//get obs
	function getObs(){
		return $this->obs;
	}
	//set obs
	function setObs($obs){
		$this->obs=$obs;
	}

	//get findings
	function getFindings(){
		return $this->findings;
	}
	//set findings
	function setFindings($findings){
		$this->findings=$findings;
	}

	//get investigation
	function getInvestigation(){
		return $this->investigation;
	}
	//set investigation
	function setInvestigation($investigation){
		$this->investigation=$investigation;
	}

	//get diagnosis
	function getDiagnosis(){
		return $this->diagnosis;
	}
	//set diagnosis
	function setDiagnosis($diagnosis){
		$this->diagnosis=$diagnosis;
	}
	
	//get treatment
	function getTreatment(){
		return $this->treatment;
	}
	//set treatment
	function setTreatment($treatment){
		$this->treatment=$treatment;
	}

	//get admission
	function getAdmission(){
		return $this->admission;
	}
	//set admission
	function setAdmission($admission){
		$this->admission=$admission;
	}

	//get treatedon
	function getTreatedon(){
		return $this->treatedon;
	}
	//set treatedon
	function setTreatedon($treatedon){
		$this->treatedon=$treatedon;
	}

	//get patientstatusid
	function getPatientstatusid(){
		return $this->patientstatusid;
	}
	//set patientstatusid
	function setPatientstatusid($patientstatusid){
		$this->patientstatusid=$patientstatusid;
	}

	//get payconsultancy
	function getPayconsultancy(){
		return $this->payconsultancy;
	}
	//set payconsultancy
	function setPayconsultancy($payconsultancy){
		$this->payconsultancy=$payconsultancy;
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
		$patienttreatmentsDBO = new PatienttreatmentsDBO();
		if($patienttreatmentsDBO->persist($obj)){
			$this->id=$patienttreatmentsDBO->id;
			$this->sql=$patienttreatmentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$patienttreatmentsDBO = new PatienttreatmentsDBO();
		if($patienttreatmentsDBO->update($obj,$where)){
			$this->sql=$patienttreatmentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$patienttreatmentsDBO = new PatienttreatmentsDBO();
		if($patienttreatmentsDBO->delete($obj,$where=""))		
			$this->sql=$patienttreatmentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patienttreatmentsDBO = new PatienttreatmentsDBO();
		$this->table=$patienttreatmentsDBO->table;
		$patienttreatmentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patienttreatmentsDBO->sql;
		$this->result=$patienttreatmentsDBO->result;
		$this->fetchObject=$patienttreatmentsDBO->fetchObject;
		$this->affectedRows=$patienttreatmentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->patientid)){
			$error="Patient should be provided";
		}
		else if(empty($obj->patientappointmentid)){
			$error="Appointment should be provided";
		}
		else if(empty($obj->patientstatusid)){
			$error="Patient Status should be provided";
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
