<?php 
require_once("EmployeepaidallowancesDBO.php");
class Employeepaidallowances
{				
	var $id;			
	var $employeepaymentid;			
	var $allowanceid;			
	var $employeeid;
	var $overtimeid;
	var $hours;
	var $amount;			
	var $month;			
	var $year;			
	var $paidon;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $employeepaidallowancesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->employeepaymentid))
			$obj->employeepaymentid='NULL';
		$this->employeepaymentid=$obj->employeepaymentid;
		if(empty($obj->allowanceid))
			$obj->allowanceid='NULL';
		$this->allowanceid=$obj->allowanceid;
		
		if(empty($obj->overtimeid))
			$obj->overtimeid='NULL';
		$this->overtimeid=$obj->overtimeid;
		$this->hours=str_replace("'","\'",$obj->hours);
		
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->paidon=str_replace("'","\'",$obj->paidon);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get employeepaymentid
	function getEmployeepaymentid(){
		return $this->employeepaymentid;
	}
	//set employeepaymentid
	function setEmployeepaymentid($employeepaymentid){
		$this->employeepaymentid=$employeepaymentid;
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

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get month
	function getMonth(){
		return $this->month;
	}
	//set month
	function setMonth($month){
		$this->month=$month;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get paidon
	function getPaidon(){
		return $this->paidon;
	}
	//set paidon
	function setPaidon($paidon){
		$this->paidon=$paidon;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$employeepaidallowancesDBO = new EmployeepaidallowancesDBO();
		if($obj->amount>0){
		  if($employeepaidallowancesDBO->persist($obj)){
			  $this->id=$employeepaidallowancesDBO->id;
			  $this->sql=$employeepaidallowancesDBO->sql;
			  return true;	
		  }
		}
	}			
	function edit($obj,$where=""){
		$employeepaidallowancesDBO = new EmployeepaidallowancesDBO();
		if($employeepaidallowancesDBO->update($obj,$where)){
			$this->sql=$employeepaidallowancesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeepaidallowancesDBO = new EmployeepaidallowancesDBO();
		if($employeepaidallowancesDBO->delete($obj,$where=""))		
			$this->sql=$employeepaidallowancesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeepaidallowancesDBO = new EmployeepaidallowancesDBO();
		$this->table=$employeepaidallowancesDBO->table;
		$employeepaidallowancesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeepaidallowancesDBO->sql;
		$this->result=$employeepaidallowancesDBO->result;
		$this->fetchObject=$employeepaidallowancesDBO->fetchObject;
		$this->affectedRows=$employeepaidallowancesDBO->affectedRows;
	}			
	function validate($obj){
// 		if(empty($obj->employeepaymentid)){
// 			$error="Payment should be provided";
// 		}
	
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
