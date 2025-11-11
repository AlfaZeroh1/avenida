<?php 
require_once("EmployeecontractsDBO.php");
class Employeecontracts
{				
	var $id;			
	var $contracttypeid;			
	var $startdate;			
	var $confirmationdate;			
	var $probation;			
	var $contractperiod;			
	var $status;			
	var $remarks;			
	var $employeeid;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeecontractsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->contracttypeid=str_replace("'","\'",$obj->contracttypeid);
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->confirmationdate=str_replace("'","\'",$obj->confirmationdate);
		$this->probation=str_replace("'","\'",$obj->probation);
		$this->contractperiod=str_replace("'","\'",$obj->contractperiod);
		$this->status=str_replace("'","\'",$obj->status);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
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

	//get contracttypeid
	function getContracttypeid(){
		return $this->contracttypeid;
	}
	//set contracttypeid
	function setContracttypeid($contracttypeid){
		$this->contracttypeid=$contracttypeid;
	}

	//get startdate
	function getStartdate(){
		return $this->startdate;
	}
	//set startdate
	function setStartdate($startdate){
		$this->startdate=$startdate;
	}

	//get confirmationdate
	function getConfirmationdate(){
		return $this->confirmationdate;
	}
	//set confirmationdate
	function setConfirmationdate($confirmationdate){
		$this->confirmationdate=$confirmationdate;
	}

	//get probation
	function getProbation(){
		return $this->probation;
	}
	//set probation
	function setProbation($probation){
		$this->probation=$probation;
	}

	//get contractperiod
	function getContractperiod(){
		return $this->contractperiod;
	}
	//set contractperiod
	function setContractperiod($contractperiod){
		$this->contractperiod=$contractperiod;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
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
		$employeecontractsDBO = new EmployeecontractsDBO();
		if($employeecontractsDBO->persist($obj)){
			$this->id=$employeecontractsDBO->id;
			$this->sql=$employeecontractsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeecontractsDBO = new EmployeecontractsDBO();
		if($employeecontractsDBO->update($obj,$where)){
			$this->sql=$employeecontractsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeecontractsDBO = new EmployeecontractsDBO();
		if($employeecontractsDBO->delete($obj,$where=""))		
			$this->sql=$employeecontractsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeecontractsDBO = new EmployeecontractsDBO();
		$this->table=$employeecontractsDBO->table;
		$employeecontractsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeecontractsDBO->sql;
		$this->result=$employeecontractsDBO->result;
		$this->fetchObject=$employeecontractsDBO->fetchObject;
		$this->affectedRows=$employeecontractsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->contracttypeid)){
			$error="Contract Type should be provided";
		}
		else if(empty($obj->startdate)){
			$error="Start Date should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Employee should be provided";
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
