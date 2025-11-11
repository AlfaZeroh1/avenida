<?php 
require_once("EmployeeoffsDBO.php");
class Employeeoffs
{				
	var $id;			
	var $employeeid;			
	var $day;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeeoffsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->day=str_replace("'","\'",$obj->day);
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

	//get day
	function getDay(){
		return $this->day;
	}
	//set day
	function setDay($day){
		$this->day=$day;
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
		$employeeoffsDBO = new EmployeeoffsDBO();
		if($employeeoffsDBO->persist($obj)){
			$this->id=$employeeoffsDBO->id;
			$this->sql=$employeeoffsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeeoffsDBO = new EmployeeoffsDBO();
		if($employeeoffsDBO->update($obj,$where)){
			$this->sql=$employeeoffsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeeoffsDBO = new EmployeeoffsDBO();
		if($employeeoffsDBO->delete($obj,$where=""))		
			$this->sql=$employeeoffsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeeoffsDBO = new EmployeeoffsDBO();
		$this->table=$employeeoffsDBO->table;
		$employeeoffsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeeoffsDBO->sql;
		$this->result=$employeeoffsDBO->result;
		$this->fetchObject=$employeeoffsDBO->fetchObject;
		$this->affectedRows=$employeeoffsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
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
