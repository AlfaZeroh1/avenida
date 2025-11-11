<?php 
require_once("EmployeeleavesDBO.php");
class Employeeleaves
{				
	var $id;			
	var $employeeid;			
	var $leaveid;			
	var $startdate;			
	var $duration;			
	var $status;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $employeeleavesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->leaveid=str_replace("'","\'",$obj->leaveid);
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->duration=str_replace("'","\'",$obj->duration);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get leaveid
	function getLeaveid(){
		return $this->leaveid;
	}
	//set leaveid
	function setLeaveid($leaveid){
		$this->leaveid=$leaveid;
	}

	//get startdate
	function getStartdate(){
		return $this->startdate;
	}
	//set startdate
	function setStartdate($startdate){
		$this->startdate=$startdate;
	}

	//get duration
	function getDuration(){
		return $this->duration;
	}
	//set duration
	function setDuration($duration){
		$this->duration=$duration;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		$employeeleavesDBO = new EmployeeleavesDBO();
		if($employeeleavesDBO->persist($obj)){
			$this->id=$employeeleavesDBO->id;
			$this->sql=$employeeleavesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeeleavesDBO = new EmployeeleavesDBO();
		if($employeeleavesDBO->update($obj,$where)){
			$this->sql=$employeeleavesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeeleavesDBO = new EmployeeleavesDBO();
		if($employeeleavesDBO->delete($obj,$where=""))		
			$this->sql=$employeeleavesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeeleavesDBO = new EmployeeleavesDBO();
		$this->table=$employeeleavesDBO->table;
		$employeeleavesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeeleavesDBO->sql;
		$this->result=$employeeleavesDBO->result;
		$this->fetchObject=$employeeleavesDBO->fetchObject;
		$this->affectedRows=$employeeleavesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->leaveid)){
			$error="Leave should be provided";
		}
		else if(empty($obj->startdate)){
			$error="Start date be provided";
		}
		else if(empty($obj->duration)){
			$error="Duration should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
