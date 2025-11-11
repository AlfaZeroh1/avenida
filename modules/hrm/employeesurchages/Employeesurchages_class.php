<?php 
require_once("EmployeesurchagesDBO.php");
class Employeesurchages
{				
	var $id;			
	var $surchageid;			
	var $employeeid;
	var $teamdetailid;
	var $surchagetypeid;			
	var $amount;	
	var $days;
	var $chargedon;			
	var $frommonth;			
	var $fromyear;			
	var $tomonth;			
	var $toyear;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeesurchagesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->surchageid=str_replace("'","\'",$obj->surchageid);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		if(empty($obj->surchagetypeid))
			$obj->surchagetypeid='NULL';
		$this->surchagetypeid=$obj->surchagetypeid;
		
		if(empty($obj->teamdetailid))
			$obj->teamdetailid='NULL';
		$this->teamdetailid=$obj->teamdetailid;
		
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->days=str_replace("'","\'",$obj->days);
		$this->chargedon=str_replace("'","\'",$obj->chargedon);
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

	//get surchageid
	function getSurchageid(){
		return $this->surchageid;
	}
	//set surchageid
	function setSurchageid($surchageid){
		$this->surchageid=$surchageid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get surchagetypeid
	function getSurchagetypeid(){
		return $this->surchagetypeid;
	}
	//set surchagetypeid
	function setSurchagetypeid($surchagetypeid){
		$this->surchagetypeid=$surchagetypeid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get chargedon
	function getChargedon(){
		return $this->chargedon;
	}
	//set chargedon
	function setChargedon($chargedon){
		$this->chargedon=$chargedon;
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
		$employeesurchagesDBO = new EmployeesurchagesDBO();
		if($employeesurchagesDBO->persist($obj)){
			$this->id=$employeesurchagesDBO->id;
			$this->sql=$employeesurchagesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeesurchagesDBO = new EmployeesurchagesDBO();
		if($employeesurchagesDBO->update($obj,$where)){
			$this->sql=$employeesurchagesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeesurchagesDBO = new EmployeesurchagesDBO();
		if($employeesurchagesDBO->delete($obj,$where=""))		
			$this->sql=$employeesurchagesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeesurchagesDBO = new EmployeesurchagesDBO();
		$this->table=$employeesurchagesDBO->table;
		$employeesurchagesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeesurchagesDBO->sql;
		$this->result=$employeesurchagesDBO->result;
		$this->fetchObject=$employeesurchagesDBO->fetchObject;
		$this->affectedRows=$employeesurchagesDBO->affectedRows;
	}			
	function validate($obj){
	
	
	if(empty($obj->surchageid)){
			$error="Surchage should be provided";
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
