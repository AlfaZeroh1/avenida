<?php 
require_once("EmployeearrearsDBO.php");
class Employeearrears
{				
	var $id;			
	var $arrearid;			
	var $employeeid;			
	var $month;			
	var $year;
	var $amount;
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeearrearsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->arrearid))
			$obj->arrearid='NULL';
		$this->arrearid=$obj->arrearid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->amount=str_replace("'","\'",$obj->amount);
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

	//get arrearid
	function getArrearid(){
		return $this->arrearid;
	}
	//set arrearid
	function setArrearid($arrearid){
		$this->arrearid=$arrearid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
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
		$employeearrearsDBO = new EmployeearrearsDBO();
		if($employeearrearsDBO->persist($obj)){
			$this->id=$employeearrearsDBO->id;
			$this->sql=$employeearrearsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeearrearsDBO = new EmployeearrearsDBO();
		if($employeearrearsDBO->update($obj,$where)){
			$this->sql=$employeearrearsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeearrearsDBO = new EmployeearrearsDBO();
		if($employeearrearsDBO->delete($obj,$where=""))		
			$this->sql=$employeearrearsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeearrearsDBO = new EmployeearrearsDBO();
		$this->table=$employeearrearsDBO->table;
		$employeearrearsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeearrearsDBO->sql;
		$this->result=$employeearrearsDBO->result;
		$this->fetchObject=$employeearrearsDBO->fetchObject;
		$this->affectedRows=$employeearrearsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->arrearid)){
			$error="Arrears should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->month)){
			$error="Month should be provided";
		}
		else if(empty($obj->year)){
			$error="Year should be provided";
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
			$error="Month should be provided";
		}
		else if(empty($obj->year)){
			$error="Year should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
