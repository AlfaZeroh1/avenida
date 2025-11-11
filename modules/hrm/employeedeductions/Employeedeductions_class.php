<?php 
require_once("EmployeedeductionsDBO.php");
class Employeedeductions
{				
	var $id;			
	var $deductionid;			
	var $amount;			
	var $deductiontypeid;			
	var $frommonth;			
	var $fromyear;			
	var $tomonth;			
	var $toyear;			
	var $remarks;			
	var $employeeid;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeedeductionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->deductionid=str_replace("'","\'",$obj->deductionid);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->deductiontypeid=str_replace("'","\'",$obj->deductiontypeid);
		$this->frommonth=str_replace("'","\'",$obj->frommonth);
		$this->fromyear=str_replace("'","\'",$obj->fromyear);
		$this->tomonth=str_replace("'","\'",$obj->tomonth);
		$this->toyear=str_replace("'","\'",$obj->toyear);
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

	//get deductionid
	function getDeductionid(){
		return $this->deductionid;
	}
	//set deductionid
	function setDeductionid($deductionid){
		$this->deductionid=$deductionid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get deductiontypeid
	function getDeductiontypeid(){
		return $this->deductiontypeid;
	}
	//set deductiontypeid
	function setDeductiontypeid($deductiontypeid){
		$this->deductiontypeid=$deductiontypeid;
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
		$employeedeductionsDBO = new EmployeedeductionsDBO();
		if($employeedeductionsDBO->persist($obj)){
			$this->id=$employeedeductionsDBO->id;
			$this->sql=$employeedeductionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeedeductionsDBO = new EmployeedeductionsDBO();
		if($employeedeductionsDBO->update($obj,$where)){
			$this->sql=$employeedeductionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeedeductionsDBO = new EmployeedeductionsDBO();
		if($employeedeductionsDBO->delete($obj,$where=""))		
			$this->sql=$employeedeductionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeedeductionsDBO = new EmployeedeductionsDBO();
		$this->table=$employeedeductionsDBO->table;
		$employeedeductionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeedeductionsDBO->sql;
		$this->result=$employeedeductionsDBO->result;
		$this->fetchObject=$employeedeductionsDBO->fetchObject;
		$this->affectedRows=$employeedeductionsDBO->affectedRows;
	}		
	
	function validate($obj){
		if(empty($obj->deductiontypeid)){
			$error="Deduction Type should be provided";
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
