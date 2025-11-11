<?php 
require_once("EmployeepaidsurchagesDBO.php");
class Employeepaidsurchages
{				
	var $id;			
	var $empsurchageid;			
	var $employeeid;			
	var $amount;			
	var $month;			
	var $year;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeepaidsurchagesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->empsurchageid=str_replace("'","\'",$obj->empsurchageid);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
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

	//get empsurchageid
	function getEmpsurchageid(){
		return $this->empsurchageid;
	}
	//set empsurchageid
	function setEmpsurchageid($empsurchageid){
		$this->empsurchageid=$empsurchageid;
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
		$employeepaidsurchagesDBO = new EmployeepaidsurchagesDBO();
		if($employeepaidsurchagesDBO->persist($obj)){
			$this->id=$employeepaidsurchagesDBO->id;
			$this->sql=$employeepaidsurchagesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeepaidsurchagesDBO = new EmployeepaidsurchagesDBO();
		if($employeepaidsurchagesDBO->update($obj,$where)){
			$this->sql=$employeepaidsurchagesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeepaidsurchagesDBO = new EmployeepaidsurchagesDBO();
		if($employeepaidsurchagesDBO->delete($obj,$where=""))		
			$this->sql=$employeepaidsurchagesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeepaidsurchagesDBO = new EmployeepaidsurchagesDBO();
		$this->table=$employeepaidsurchagesDBO->table;
		$employeepaidsurchagesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeepaidsurchagesDBO->sql;
		$this->result=$employeepaidsurchagesDBO->result;
		$this->fetchObject=$employeepaidsurchagesDBO->fetchObject;
		$this->affectedRows=$employeepaidsurchagesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
