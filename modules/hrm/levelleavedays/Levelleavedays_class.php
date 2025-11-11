<?php 
require_once("LevelleavedaysDBO.php");
class Levelleavedays
{				
	var $id;			
	var $leaveid;			
	var $levelid;			
	var $leavedays;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $levelleavedaysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->leaveid))
			$obj->leaveid='NULL';
		$this->leaveid=$obj->leaveid;
		if(empty($obj->levelid))
			$obj->levelid='NULL';
		$this->levelid=$obj->levelid;
		$this->leavedays=str_replace("'","\'",$obj->leavedays);
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

	//get leaveid
	function getLeaveid(){
		return $this->leaveid;
	}
	//set leaveid
	function setLeaveid($leaveid){
		$this->leaveid=$leaveid;
	}

	//get levelid
	function getLevelid(){
		return $this->levelid;
	}
	//set levelid
	function setLevelid($levelid){
		$this->levelid=$levelid;
	}

	//get leavedays
	function getLeavedays(){
		return $this->leavedays;
	}
	//set leavedays
	function setLeavedays($leavedays){
		$this->leavedays=$leavedays;
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
		$levelleavedaysDBO = new LevelleavedaysDBO();
		if($levelleavedaysDBO->persist($obj)){
			$this->id=$levelleavedaysDBO->id;
			$this->sql=$levelleavedaysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$levelleavedaysDBO = new LevelleavedaysDBO();
		if($levelleavedaysDBO->update($obj,$where)){
			$this->sql=$levelleavedaysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$levelleavedaysDBO = new LevelleavedaysDBO();
		if($levelleavedaysDBO->delete($obj,$where=""))		
			$this->sql=$levelleavedaysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$levelleavedaysDBO = new LevelleavedaysDBO();
		$this->table=$levelleavedaysDBO->table;
		$levelleavedaysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$levelleavedaysDBO->sql;
		$this->result=$levelleavedaysDBO->result;
		$this->fetchObject=$levelleavedaysDBO->fetchObject;
		$this->affectedRows=$levelleavedaysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->leaveid)){
			$error="Leave should be provided";
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
