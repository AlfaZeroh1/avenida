<?php 
require_once("EmployeeovertimesDBO.php");
class Employeeovertimes
{				
	var $id;			
	var $employeeid;			
	var $overtimeid;			
	var $hours;			
	var $fromdate;			
	var $todate;			
	var $month;			
	var $year;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeeovertimesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->overtimeid))
			$obj->overtimeid='NULL';
		$this->overtimeid=$obj->overtimeid;
		$this->hours=str_replace("'","\'",$obj->hours);
		$this->fromdate=str_replace("'","\'",$obj->fromdate);
		$this->todate=str_replace("'","\'",$obj->todate);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get overtimeid
	function getOvertimeid(){
		return $this->overtimeid;
	}
	//set overtimeid
	function setOvertimeid($overtimeid){
		$this->overtimeid=$overtimeid;
	}

	//get hours
	function getHours(){
		return $this->hours;
	}
	//set hours
	function setHours($hours){
		$this->hours=$hours;
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

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
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
		$employeeovertimesDBO = new EmployeeovertimesDBO();
		if($employeeovertimesDBO->persist($obj)){
			$this->id=$employeeovertimesDBO->id;
			$this->sql=$employeeovertimesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeeovertimesDBO = new EmployeeovertimesDBO();
		if($employeeovertimesDBO->update($obj,$where)){
			$this->sql=$employeeovertimesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeeovertimesDBO = new EmployeeovertimesDBO();
		if($employeeovertimesDBO->delete($obj,$where=""))		
			$this->sql=$employeeovertimesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeeovertimesDBO = new EmployeeovertimesDBO();
		$this->table=$employeeovertimesDBO->table;
		$employeeovertimesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeeovertimesDBO->sql;
		$this->result=$employeeovertimesDBO->result;
		$this->fetchObject=$employeeovertimesDBO->fetchObject;
		$this->affectedRows=$employeeovertimesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->overtimeid)){
			$error="Overtime Type should be provided";
		}
		else if(empty($obj->month)){
			$error="Month Payable should be provided";
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
		else if(empty($obj->month)){
			$error="Month Payable should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
