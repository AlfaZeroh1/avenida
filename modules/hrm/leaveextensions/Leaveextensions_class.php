<?php 
require_once("LeaveextensionsDBO.php");
class Leaveextensions
{				
	var $id;			
	var $employeeleaveapplicationid;			
	var $days;			
	var $type;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $leaveextensionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->employeeleaveapplicationid))
			$obj->employeeleaveapplicationid='NULL';
		$this->employeeleaveapplicationid=$obj->employeeleaveapplicationid;
		$this->days=str_replace("'","\'",$obj->days);
		$this->type=str_replace("'","\'",$obj->type);
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

	//get employeeleaveapplicationid
	function getEmployeeleaveapplicationid(){
		return $this->employeeleaveapplicationid;
	}
	//set employeeleaveapplicationid
	function setEmployeeleaveapplicationid($employeeleaveapplicationid){
		$this->employeeleaveapplicationid=$employeeleaveapplicationid;
	}

	//get days
	function getDays(){
		return $this->days;
	}
	//set days
	function setDays($days){
		$this->days=$days;
	}

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
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
		$leaveextensionsDBO = new LeaveextensionsDBO();
		if($leaveextensionsDBO->persist($obj)){
			$this->id=$leaveextensionsDBO->id;
			$this->sql=$leaveextensionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$leaveextensionsDBO = new LeaveextensionsDBO();
		if($leaveextensionsDBO->update($obj,$where)){
			$this->sql=$leaveextensionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$leaveextensionsDBO = new LeaveextensionsDBO();
		if($leaveextensionsDBO->delete($obj,$where=""))		
			$this->sql=$leaveextensionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$leaveextensionsDBO = new LeaveextensionsDBO();
		$this->table=$leaveextensionsDBO->table;
		$leaveextensionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$leaveextensionsDBO->sql;
		$this->result=$leaveextensionsDBO->result;
		$this->fetchObject=$leaveextensionsDBO->fetchObject;
		$this->affectedRows=$leaveextensionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeleaveapplicationid)){
			$error="Employee Application should be provided";
		}
	
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
