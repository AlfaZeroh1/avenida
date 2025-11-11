<?php 
require_once("PatientvitalsignsDBO.php");
class Patientvitalsigns
{				
	var $id;			
	var $observedon;			
	var $observedtime;			
	var $patientid;			
	var $patientappointmentid;			
	var $patienttreatmentid;			
	var $vitalsignid;			
	var $results;			
	var $remarks;			
	var $patientvitalsignsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->observedon=str_replace("'","\'",$obj->observedon);
		$this->observedtime=str_replace("'","\'",$obj->observedtime);
		if(empty($obj->patientid))
			$obj->patientid='NULL';
		$this->patientid=$obj->patientid;
		$this->patientappointmentid=str_replace("'","\'",$obj->patientappointmentid);
		$this->patienttreatmentid=str_replace("'","\'",$obj->patienttreatmentid);
		if(empty($obj->vitalsignid))
			$obj->vitalsignid='NULL';
		$this->vitalsignid=$obj->vitalsignid;
		$this->results=str_replace("'","\'",$obj->results);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get observedon
	function getObservedon(){
		return $this->observedon;
	}
	//set observedon
	function setObservedon($observedon){
		$this->observedon=$observedon;
	}

	//get observedtime
	function getObservedtime(){
		return $this->observedtime;
	}
	//set observedtime
	function setObservedtime($observedtime){
		$this->observedtime=$observedtime;
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

	//get patienttreatmentid
	function getPatienttreatmentid(){
		return $this->patienttreatmentid;
	}
	//set patienttreatmentid
	function setPatienttreatmentid($patienttreatmentid){
		$this->patienttreatmentid=$patienttreatmentid;
	}

	//get vitalsignid
	function getVitalsignid(){
		return $this->vitalsignid;
	}
	//set vitalsignid
	function setVitalsignid($vitalsignid){
		$this->vitalsignid=$vitalsignid;
	}

	//get results
	function getResults(){
		return $this->results;
	}
	//set results
	function setResults($results){
		$this->results=$results;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	function add($obj){
		$patientvitalsignsDBO = new PatientvitalsignsDBO();
		if($patientvitalsignsDBO->persist($obj)){
			$this->id=$patientvitalsignsDBO->id;
			$this->sql=$patientvitalsignsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$patientvitalsignsDBO = new PatientvitalsignsDBO();
		if($patientvitalsignsDBO->update($obj,$where)){
			$this->sql=$patientvitalsignsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$patientvitalsignsDBO = new PatientvitalsignsDBO();
		if($patientvitalsignsDBO->delete($obj,$where=""))		
			$this->sql=$patientvitalsignsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientvitalsignsDBO = new PatientvitalsignsDBO();
		$this->table=$patientvitalsignsDBO->table;
		$patientvitalsignsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patientvitalsignsDBO->sql;
		$this->result=$patientvitalsignsDBO->result;
		$this->fetchObject=$patientvitalsignsDBO->fetchObject;
		$this->affectedRows=$patientvitalsignsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->observedon)){
			$error="Observation Date should be provided";
		}
		else if(empty($obj->observedtime)){
			$error="Observation Time should be provided";
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
