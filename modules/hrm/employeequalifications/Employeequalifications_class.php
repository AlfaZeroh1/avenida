<?php 
require_once("EmployeequalificationsDBO.php");
class Employeequalifications
{				
	var $id;			
	var $employeeid;			
	var $qualificationid;			
	var $title;			
	var $institution;			
	var $gradingid;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeequalificationsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->qualificationid=str_replace("'","\'",$obj->qualificationid);
		$this->title=str_replace("'","\'",$obj->title);
		$this->institution=str_replace("'","\'",$obj->institution);
		$this->gradingid=str_replace("'","\'",$obj->gradingid);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get qualificationid
	function getQualificationid(){
		return $this->qualificationid;
	}
	//set qualificationid
	function setQualificationid($qualificationid){
		$this->qualificationid=$qualificationid;
	}

	//get title
	function getTitle(){
		return $this->title;
	}
	//set title
	function setTitle($title){
		$this->title=$title;
	}

	//get institution
	function getInstitution(){
		return $this->institution;
	}
	//set institution
	function setInstitution($institution){
		$this->institution=$institution;
	}

	//get gradingid
	function getGradingid(){
		return $this->gradingid;
	}
	//set gradingid
	function setGradingid($gradingid){
		$this->gradingid=$gradingid;
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
		$employeequalificationsDBO = new EmployeequalificationsDBO();
		if($employeequalificationsDBO->persist($obj)){
			$this->id=$employeequalificationsDBO->id;
			$this->sql=$employeequalificationsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeequalificationsDBO = new EmployeequalificationsDBO();
		if($employeequalificationsDBO->update($obj,$where)){
			$this->sql=$employeequalificationsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeequalificationsDBO = new EmployeequalificationsDBO();
		if($employeequalificationsDBO->delete($obj,$where=""))		
			$this->sql=$employeequalificationsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeequalificationsDBO = new EmployeequalificationsDBO();
		$this->table=$employeequalificationsDBO->table;
		$employeequalificationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeequalificationsDBO->sql;
		$this->result=$employeequalificationsDBO->result;
		$this->fetchObject=$employeequalificationsDBO->fetchObject;
		$this->affectedRows=$employeequalificationsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->qualificationid)){
			$error="Qualification should be provided";
		}
		else if(empty($obj->title)){
			$error="Title should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
