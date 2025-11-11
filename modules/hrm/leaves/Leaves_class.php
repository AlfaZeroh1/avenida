<?php 
require_once("LeavesDBO.php");
class Leaves
{				
	var $id;			
	var $name;			
	var $days;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $allowanceid;			
	var $leavesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->days=str_replace("'","\'",$obj->days);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		if(empty($obj->allowanceid))
			$obj->allowanceid='NULL';
		$this->allowanceid=$obj->allowanceid;
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
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

	//get allowanceid
	function getAllowanceid(){
		return $this->allowanceid;
	}
	//set allowanceid
	function setAllowanceid($allowanceid){
		$this->allowanceid=$allowanceid;
	}

	function add($obj){
		$leavesDBO = new LeavesDBO();
		if($leavesDBO->persist($obj)){
			$this->id=$leavesDBO->id;
			$this->sql=$leavesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$leavesDBO = new LeavesDBO();
		if($leavesDBO->update($obj,$where)){
			$this->sql=$leavesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$leavesDBO = new LeavesDBO();
		if($leavesDBO->delete($obj,$where=""))		
			$this->sql=$leavesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$leavesDBO = new LeavesDBO();
		$this->table=$leavesDBO->table;
		$leavesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$leavesDBO->sql;
		$this->result=$leavesDBO->result;
		$this->fetchObject=$leavesDBO->fetchObject;
		$this->affectedRows=$leavesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Leave should be provided";
		}
		else if(empty($obj->allowanceid)){
			$error="Allowance to Cash should be provided";
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
