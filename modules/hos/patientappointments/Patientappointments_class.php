<?php 
require_once("PatientappointmentsDBO.php");
class Patientappointments
{				
	var $id;			
	var $patientid;			
	var $appointmentdate;			
	var $employeeid;			
	var $departmentid;			
	var $bookedon;			
	var $remarks;			
	var $status;			
	var $payconsultancy;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $patientappointmentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $patientclasseid;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->patientid=str_replace("'","\'",$obj->patientid);
		$this->appointmentdate=str_replace("'","\'",$obj->appointmentdate);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->departmentid=str_replace("'","\'",$obj->departmentid);
		$this->bookedon=str_replace("'","\'",$obj->bookedon);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
		$this->patientclasseid=str_replace("'","\'",$obj->patientclasseid);
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

	//get appointmentdate
	function getAppointmentdate(){
		return $this->appointmentdate;
	}
	//set appointmentdate
	function setAppointmentdate($appointmentdate){
		$this->appointmentdate=$appointmentdate;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
	}

	//get bookedon
	function getBookedon(){
		return $this->bookedon;
	}
	//set bookedon
	function setBookedon($bookedon){
		$this->bookedon=$bookedon;
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
		$patientappointmentsDBO = new PatientappointmentsDBO();
		if($patientappointmentsDBO->persist($obj)){
			$this->id=$patientappointmentsDBO->id;
			$this->sql=$patientappointmentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$patientappointmentsDBO = new PatientappointmentsDBO();
		if($patientappointmentsDBO->update($obj,$where)){
			$this->sql=$patientappointmentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$patientappointmentsDBO = new PatientappointmentsDBO();
		if($patientappointmentsDBO->delete($obj,$where=""))		
			$this->sql=$patientappointmentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientappointmentsDBO = new PatientappointmentsDBO();
		$this->table=$patientappointmentsDBO->table;
		$patientappointmentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patientappointmentsDBO->sql;
		$this->result=$patientappointmentsDBO->result;
		$this->fetchObject=$patientappointmentsDBO->fetchObject;
		$this->affectedRows=$patientappointmentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->patientid)){
			$error="Patient should be provided";
		}
		else if(empty($obj->appointmentdate)){
			$error="Appointment Date should be provided";
		}
		else if(empty($obj->departmentid)){
			$error="Department should be provided";
		}
		else if(empty($obj->status)){
			$error="Status should be provided";
		}
		else if(empty($obj->patientclasseid)){
			$error="Patient Classes should be provided";
		}
		else if($obj->patientclasseid==1 and empty($obj->amount)){
		       $error="Consultancy Fee should be provided";
		}
		else if($obj->payconsultancy==1 and empty($obj->amount)){
		       $error="Consultancy Fee should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->patientid)){
			$error="Patient should be provided";
		}
		else if(empty($obj->departmentid)){
			$error="Department should be provided";
		}
		else if(empty($obj->patientclasseid)){
			$error="Patient Classes should be provided";
		}
		else if($obj->patientclasseid==1 and empty($obj->amount)){
		       $error="Consultancy Fee should be provided";
		}
		else if($obj->payconsultancy==1 and empty($obj->amount)){
		       $error="Consultancy Fee should be provided";
		}
		
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
