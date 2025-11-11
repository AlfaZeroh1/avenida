<?php 
require_once("SchedulersDBO.php");
class Schedulers
{				
	var $id;			
	var $employeeid;			
	var $assignmentid;			
	var $scheduledate;			
	var $remarks;			
	var $createby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $schedulersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->assignmentid=str_replace("'","\'",$obj->assignmentid);
		$this->scheduledate=str_replace("'","\'",$obj->scheduledate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->createby=str_replace("'","\'",$obj->createby);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get assignmentid
	function getAssignmentid(){
		return $this->assignmentid;
	}
	//set assignmentid
	function setAssignmentid($assignmentid){
		$this->assignmentid=$assignmentid;
	}

	//get scheduledate
	function getScheduledate(){
		return $this->scheduledate;
	}
	//set scheduledate
	function setScheduledate($scheduledate){
		$this->scheduledate=$scheduledate;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get createby
	function getCreateby(){
		return $this->createby;
	}
	//set createby
	function setCreateby($createby){
		$this->createby=$createby;
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
		$schedulersDBO = new SchedulersDBO();
		if($schedulersDBO->persist($obj)){
			$this->id=$schedulersDBO->id;
			$this->sql=$schedulersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$schedulersDBO = new SchedulersDBO();
		if($schedulersDBO->update($obj,$where)){
			$this->sql=$schedulersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$schedulersDBO = new SchedulersDBO();
		if($schedulersDBO->delete($obj,$where=""))		
			$this->sql=$schedulersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$schedulersDBO = new SchedulersDBO();
		$this->table=$schedulersDBO->table;
		$schedulersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$schedulersDBO->sql;
		$this->result=$schedulersDBO->result;
		$this->fetchObject=$schedulersDBO->fetchObject;
		$this->affectedRows=$schedulersDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
