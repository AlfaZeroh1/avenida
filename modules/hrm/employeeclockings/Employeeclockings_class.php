<?php 
require_once("EmployeeclockingsDBO.php");
class Employeeclockings
{				
	var $id;			
	var $employeeid;			
	var $starttime;			
	var $endtime;			
	var $today;	
	var $amount;
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeeclockingsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->starttime=str_replace("'","\'",$obj->starttime);
		$this->endtime=str_replace("'","\'",$obj->endtime);
		$this->today=str_replace("'","\'",$obj->today);
		$this->amount=str_replace("'","\'",$obj->amount);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get starttime
	function getStarttime(){
		return $this->starttime;
	}
	//set starttime
	function setStarttime($starttime){
		$this->starttime=$starttime;
	}

	//get endtime
	function getEndtime(){
		return $this->endtime;
	}
	//set endtime
	function setEndtime($endtime){
		$this->endtime=$endtime;
	}

	//get today
	function getToday(){
		return $this->today;
	}
	//set today
	function setToday($today){
		$this->today=$today;
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
		$employeeclockingsDBO = new EmployeeclockingsDBO();
		if($employeeclockingsDBO->persist($obj)){
			$this->id=$employeeclockingsDBO->id;
			$this->sql=$employeeclockingsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeeclockingsDBO = new EmployeeclockingsDBO();
		if($employeeclockingsDBO->update($obj,$where)){
			$this->sql=$employeeclockingsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeeclockingsDBO = new EmployeeclockingsDBO();
		if($employeeclockingsDBO->delete($obj,$where=""))		
			$this->sql=$employeeclockingsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeeclockingsDBO = new EmployeeclockingsDBO();
		$this->table=$employeeclockingsDBO->table;
		$employeeclockingsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeeclockingsDBO->sql;
		$this->result=$employeeclockingsDBO->result;
		$this->fetchObject=$employeeclockingsDBO->fetchObject;
		$this->affectedRows=$employeeclockingsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
