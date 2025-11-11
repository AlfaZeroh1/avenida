<?php 
require_once("EmployeeinsurancesDBO.php");
class Employeeinsurances
{				
	var $id;			
	var $employeeid;			
	var $insuranceid;			
	var $insurancetype;			
	var $premium;			
	var $relief;			
	var $startdate;			
	var $expectedenddate;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $employeeinsurancesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		if(empty($obj->insuranceid))
			$obj->insuranceid='NULL';
		$this->insuranceid=$obj->insuranceid;
		$this->insurancetype=str_replace("'","\'",$obj->insurancetype);
		$this->premium=str_replace("'","\'",$obj->premium);
		$this->relief=str_replace("'","\'",$obj->relief);
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->expectedenddate=str_replace("'","\'",$obj->expectedenddate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get insuranceid
	function getInsuranceid(){
		return $this->insuranceid;
	}
	//set insuranceid
	function setInsuranceid($insuranceid){
		$this->insuranceid=$insuranceid;
	}

	//get insurancetype
	function getInsurancetype(){
		return $this->insurancetype;
	}
	//set insurancetype
	function setInsurancetype($insurancetype){
		$this->insurancetype=$insurancetype;
	}

	//get premium
	function getPremium(){
		return $this->premium;
	}
	//set premium
	function setPremium($premium){
		$this->premium=$premium;
	}

	//get relief
	function getRelief(){
		return $this->relief;
	}
	//set relief
	function setRelief($relief){
		$this->relief=$relief;
	}

	//get startdate
	function getStartdate(){
		return $this->startdate;
	}
	//set startdate
	function setStartdate($startdate){
		$this->startdate=$startdate;
	}

	//get expectedenddate
	function getExpectedenddate(){
		return $this->expectedenddate;
	}
	//set expectedenddate
	function setExpectedenddate($expectedenddate){
		$this->expectedenddate=$expectedenddate;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$employeeinsurancesDBO = new EmployeeinsurancesDBO();
		if($employeeinsurancesDBO->persist($obj)){
			$this->id=$employeeinsurancesDBO->id;
			$this->sql=$employeeinsurancesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeeinsurancesDBO = new EmployeeinsurancesDBO();
		if($employeeinsurancesDBO->update($obj,$where)){
			$this->sql=$employeeinsurancesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeeinsurancesDBO = new EmployeeinsurancesDBO();
		if($employeeinsurancesDBO->delete($obj,$where=""))		
			$this->sql=$employeeinsurancesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeeinsurancesDBO = new EmployeeinsurancesDBO();
		$this->table=$employeeinsurancesDBO->table;
		$employeeinsurancesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeeinsurancesDBO->sql;
		$this->result=$employeeinsurancesDBO->result;
		$this->fetchObject=$employeeinsurancesDBO->fetchObject;
		$this->affectedRows=$employeeinsurancesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->insuranceid)){
			$error="Insurance should be provided";
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
