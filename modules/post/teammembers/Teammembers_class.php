<?php 
require_once("TeammembersDBO.php");
class Teammembers
{				
	var $id;			
	var $teamid;			
	var $employeeid;			
	var $teamroleid;			
	var $teamedon;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $teammembersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->teamid))
			$obj->teamid='NULL';
		$this->teamid=$obj->teamid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->teamroleid))
			$obj->teamroleid='NULL';
		$this->teamroleid=$obj->teamroleid;
		$this->teamedon=str_replace("'","\'",$obj->teamedon);
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

	//get teamid
	function getTeamid(){
		return $this->teamid;
	}
	//set teamid
	function setTeamid($teamid){
		$this->teamid=$teamid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get teamroleid
	function getTeamroleid(){
		return $this->teamroleid;
	}
	//set teamroleid
	function setTeamroleid($teamroleid){
		$this->teamroleid=$teamroleid;
	}

	//get teamedon
	function getTeamedon(){
		return $this->teamedon;
	}
	//set teamedon
	function setTeamedon($teamedon){
		$this->teamedon=$teamedon;
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
		$teammembersDBO = new TeammembersDBO();
		if($teammembersDBO->persist($obj)){
			$this->id=$teammembersDBO->id;
			$this->sql=$teammembersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$teammembersDBO = new TeammembersDBO();
		if($teammembersDBO->update($obj,$where)){
			$this->sql=$teammembersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$teammembersDBO = new TeammembersDBO();
		if($teammembersDBO->delete($obj,$where=""))		
			$this->sql=$teammembersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$teammembersDBO = new TeammembersDBO();
		$this->table=$teammembersDBO->table;
		$teammembersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$teammembersDBO->sql;
		$this->result=$teammembersDBO->result;
		$this->fetchObject=$teammembersDBO->fetchObject;
		$this->affectedRows=$teammembersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->teamid)){
			$error="Team should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Member should be provided";
		}
		else if(empty($obj->teamroleid)){
			$error="Role should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->employeeid)){
			$error="Member should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
