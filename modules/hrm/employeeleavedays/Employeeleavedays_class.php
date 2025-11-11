<?php 
require_once("EmployeeleavedaysDBO.php");
class Employeeleavedays
{				
	var $id;			
	var $employeeid;			
	var $leavetypeid;			
	var $year;			
	var $days;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeeleavedaysDBO;
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
		if(empty($obj->leavetypeid))
			$obj->leavetypeid='NULL';
		$this->leavetypeid=$obj->leavetypeid;
		$this->year=str_replace("'","\'",$obj->year);
		$this->days=str_replace("'","\'",$obj->days);
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

	//get leavetypeid
	function getLeavetypeid(){
		return $this->leavetypeid;
	}
	//set leavetypeid
	function setLeavetypeid($leavetypeid){
		$this->leavetypeid=$leavetypeid;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get days
	function getDays(){
		return $this->days;
	}
	//set days
	function setDays($days){
		$this->days=$days;
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
		$employeeleavedaysDBO = new EmployeeleavedaysDBO();
		if($employeeleavedaysDBO->persist($obj)){
			$this->id=$employeeleavedaysDBO->id;
			$this->sql=$employeeleavedaysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeeleavedaysDBO = new EmployeeleavedaysDBO();
		if($employeeleavedaysDBO->update($obj,$where)){
			$this->sql=$employeeleavedaysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeeleavedaysDBO = new EmployeeleavedaysDBO();
		if($employeeleavedaysDBO->delete($obj,$where=""))		
			$this->sql=$employeeleavedaysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeeleavedaysDBO = new EmployeeleavedaysDBO();
		$this->table=$employeeleavedaysDBO->table;
		$employeeleavedaysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeeleavedaysDBO->sql;
		$this->result=$employeeleavedaysDBO->result;
		$this->fetchObject=$employeeleavedaysDBO->fetchObject;
		$this->affectedRows=$employeeleavedaysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->leavetypeid)){
			$error="Leave Type should be provided";
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
