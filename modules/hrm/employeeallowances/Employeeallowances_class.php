<?php 
require_once("EmployeeallowancesDBO.php");
class Employeeallowances
{				
	var $id;			
	var $allowanceid;			
	var $employeeid;			
	var $allowancetypeid;			
	var $amount;			
	var $frommonth;			
	var $fromyear;			
	var $tomonth;			
	var $toyear;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeeallowancesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->allowanceid=str_replace("'","\'",$obj->allowanceid);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->allowancetypeid=str_replace("'","\'",$obj->allowancetypeid);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->frommonth=str_replace("'","\'",$obj->frommonth);
		$this->fromyear=str_replace("'","\'",$obj->fromyear);
		$this->tomonth=str_replace("'","\'",$obj->tomonth);
		$this->toyear=str_replace("'","\'",$obj->toyear);
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

	//get allowanceid
	function getAllowanceid(){
		return $this->allowanceid;
	}
	//set allowanceid
	function setAllowanceid($allowanceid){
		$this->allowanceid=$allowanceid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get allowancetypeid
	function getAllowancetypeid(){
		return $this->allowancetypeid;
	}
	//set allowancetypeid
	function setAllowancetypeid($allowancetypeid){
		$this->allowancetypeid=$allowancetypeid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get frommonth
	function getFrommonth(){
		return $this->frommonth;
	}
	//set frommonth
	function setFrommonth($frommonth){
		$this->frommonth=$frommonth;
	}

	//get fromyear
	function getFromyear(){
		return $this->fromyear;
	}
	//set fromyear
	function setFromyear($fromyear){
		$this->fromyear=$fromyear;
	}

	//get tomonth
	function getTomonth(){
		return $this->tomonth;
	}
	//set tomonth
	function setTomonth($tomonth){
		$this->tomonth=$tomonth;
	}

	//get toyear
	function getToyear(){
		return $this->toyear;
	}
	//set toyear
	function setToyear($toyear){
		$this->toyear=$toyear;
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
		$employeeallowancesDBO = new EmployeeallowancesDBO();
		if($employeeallowancesDBO->persist($obj)){
			$this->id=$employeeallowancesDBO->id;
			$this->sql=$employeeallowancesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeeallowancesDBO = new EmployeeallowancesDBO();
		if($employeeallowancesDBO->update($obj,$where)){
			$this->sql=$employeeallowancesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeeallowancesDBO = new EmployeeallowancesDBO();
		if($employeeallowancesDBO->delete($obj,$where=""))		
			$this->sql=$employeeallowancesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeeallowancesDBO = new EmployeeallowancesDBO();
		$this->table=$employeeallowancesDBO->table;
		$employeeallowancesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeeallowancesDBO->sql;
		$this->result=$employeeallowancesDBO->result;
		$this->fetchObject=$employeeallowancesDBO->fetchObject;
		$this->affectedRows=$employeeallowancesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->allowancetypeid)){
			$error="Allowance Type should be provided";
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
