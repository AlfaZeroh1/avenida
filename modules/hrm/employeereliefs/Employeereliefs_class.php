<?php 
require_once("EmployeereliefsDBO.php");
class Employeereliefs
{				
	var $id;			
	var $reliefid;			
	var $employeeid;			
	var $percent;			
	var $premium;			
	var $amount;			
	var $month;			
	var $year;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeereliefsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->reliefid=str_replace("'","\'",$obj->reliefid);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->percent=str_replace("'","\'",$obj->percent);
		$this->premium=str_replace("'","\'",$obj->premium);
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

	//get reliefid
	function getReliefid(){
		return $this->reliefid;
	}
	//set reliefid
	function setReliefid($reliefid){
		$this->reliefid=$reliefid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get percent
	function getPercent(){
		return $this->percent;
	}
	//set percent
	function setPercent($percent){
		$this->percent=$percent;
	}

	//get premium
	function getPremium(){
		return $this->premium;
	}
	//set premium
	function setPremium($premium){
		$this->premium=$premium;
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
		$employeereliefsDBO = new EmployeereliefsDBO();
		if($employeereliefsDBO->persist($obj)){
			$this->id=$employeereliefsDBO->id;
			$this->sql=$employeereliefsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeereliefsDBO = new EmployeereliefsDBO();
		if($employeereliefsDBO->update($obj,$where)){
			$this->sql=$employeereliefsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeereliefsDBO = new EmployeereliefsDBO();
		if($employeereliefsDBO->delete($obj,$where=""))		
			$this->sql=$employeereliefsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeereliefsDBO = new EmployeereliefsDBO();
		$this->table=$employeereliefsDBO->table;
		$employeereliefsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeereliefsDBO->sql;
		$this->result=$employeereliefsDBO->result;
		$this->fetchObject=$employeereliefsDBO->fetchObject;
		$this->affectedRows=$employeereliefsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
