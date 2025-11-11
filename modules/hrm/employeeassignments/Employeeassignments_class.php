<?php 
require_once("EmployeeassignmentsDBO.php");
class Employeeassignments
{				
	var $id;			
	var $employeeid;			
	var $assignmentid;			
	var $fromdate;			
	var $todate;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeeassignmentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->assignmentid=str_replace("'","\'",$obj->assignmentid);
		$this->fromdate=str_replace("'","\'",$obj->fromdate);
		$this->todate=str_replace("'","\'",$obj->todate);
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

	//get fromdate
	function getFromdate(){
		return $this->fromdate;
	}
	//set fromdate
	function setFromdate($fromdate){
		$this->fromdate=$fromdate;
	}

	//get todate
	function getTodate(){
		return $this->todate;
	}
	//set todate
	function setTodate($todate){
		$this->todate=$todate;
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
		$employeeassignmentsDBO = new EmployeeassignmentsDBO();
		if($employeeassignmentsDBO->persist($obj)){
			$this->id=$employeeassignmentsDBO->id;
			$this->sql=$employeeassignmentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeeassignmentsDBO = new EmployeeassignmentsDBO();
		if($employeeassignmentsDBO->update($obj,$where)){
			$this->sql=$employeeassignmentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeeassignmentsDBO = new EmployeeassignmentsDBO();
		if($employeeassignmentsDBO->delete($obj,$where=""))		
			$this->sql=$employeeassignmentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeeassignmentsDBO = new EmployeeassignmentsDBO();
		$this->table=$employeeassignmentsDBO->table;
		$employeeassignmentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeeassignmentsDBO->sql;
		$this->result=$employeeassignmentsDBO->result;
		$this->fetchObject=$employeeassignmentsDBO->fetchObject;
		$this->affectedRows=$employeeassignmentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->assignmentid)){
			$error="Assignment should be provided";
		}
		else if(empty($obj->fromdate)){
			$error="Date Assigned should be provided";
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
