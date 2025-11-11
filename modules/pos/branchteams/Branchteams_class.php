<?php 
require_once("BranchteamsDBO.php");
class Branchteams
{				
	var $id;			
	var $brancheid;			
	var $teamroleid;			
	var $number;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $branchteamsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
		if(empty($obj->teamroleid))
			$obj->teamroleid='NULL';
		$this->teamroleid=$obj->teamroleid;
		$this->number=str_replace("'","\'",$obj->number);
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

	//get brancheid
	function getBrancheid(){
		return $this->brancheid;
	}
	//set brancheid
	function setBrancheid($brancheid){
		$this->brancheid=$brancheid;
	}

	//get teamroleid
	function getTeamroleid(){
		return $this->teamroleid;
	}
	//set teamroleid
	function setTeamroleid($teamroleid){
		$this->teamroleid=$teamroleid;
	}

	//get number
	function getNumber(){
		return $this->number;
	}
	//set number
	function setNumber($number){
		$this->number=$number;
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
		$branchteamsDBO = new BranchteamsDBO();
		if($branchteamsDBO->persist($obj)){
			$this->id=$branchteamsDBO->id;
			$this->sql=$branchteamsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$branchteamsDBO = new BranchteamsDBO();
		if($branchteamsDBO->update($obj,$where)){
			$this->sql=$branchteamsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$branchteamsDBO = new BranchteamsDBO();
		if($branchteamsDBO->delete($obj,$where=""))		
			$this->sql=$branchteamsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$branchteamsDBO = new BranchteamsDBO();
		$this->table=$branchteamsDBO->table;
		$branchteamsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$branchteamsDBO->sql;
		$this->result=$branchteamsDBO->result;
		$this->fetchObject=$branchteamsDBO->fetchObject;
		$this->affectedRows=$branchteamsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->brancheid)){
			$error="Location should be provided";
		}
		else if(empty($obj->number)){
			$error="Number should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->brancheid)){
			$error="Location should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
