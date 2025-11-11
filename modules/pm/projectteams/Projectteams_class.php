<?php 
require_once("ProjectteamsDBO.php");
class Projectteams
{				
	var $id;			
	var $projectid;			
	var $employeeid;			
	var $teampositionid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectteamsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->teampositionid))
			$obj->teampositionid='NULL';
		$this->teampositionid=$obj->teampositionid;
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

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get teampositionid
	function getTeampositionid(){
		return $this->teampositionid;
	}
	//set teampositionid
	function setTeampositionid($teampositionid){
		$this->teampositionid=$teampositionid;
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
		$projectteamsDBO = new ProjectteamsDBO();
		if($projectteamsDBO->persist($obj)){
			$this->id=$projectteamsDBO->id;
			$this->sql=$projectteamsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectteamsDBO = new ProjectteamsDBO();
		if($projectteamsDBO->update($obj,$where)){
			$this->sql=$projectteamsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectteamsDBO = new ProjectteamsDBO();
		if($projectteamsDBO->delete($obj,$where=""))		
			$this->sql=$projectteamsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectteamsDBO = new ProjectteamsDBO();
		$this->table=$projectteamsDBO->table;
		$projectteamsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectteamsDBO->sql;
		$this->result=$projectteamsDBO->result;
		$this->fetchObject=$projectteamsDBO->fetchObject;
		$this->affectedRows=$projectteamsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->projectid)){
			$error="Project should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->teampositionid)){
			$error="Team Position should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->projectid)){
			$error="Project should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
