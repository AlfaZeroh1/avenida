<?php 
require_once("LeavesectionDBO.php");
class Leavesection
{				
	var $sectionid;			
	var $sectionname;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $leavesectionDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->sectionid=str_replace("'","\'",$obj->sectionid);
		$this->sectionname=str_replace("'","\'",$obj->sectionname);
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
	//get sectionid
	function getSectionid(){
		return $this->sectionid;
	}
	//set sectionid
	function setSectionid($sectionid){
		$this->sectionid=$sectionid;
	}

	//get sectionname
	function getSectionname(){
		return $this->sectionname;
	}
	//set sectionname
	function setSectionname($sectionname){
		$this->sectionname=$sectionname;
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
		$leavesectionDBO = new LeavesectionDBO();
		if($leavesectionDBO->persist($obj)){
			$this->id=$leavesectionDBO->id;
			$this->sql=$leavesectionDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$leavesectionDBO = new LeavesectionDBO();
		if($leavesectionDBO->update($obj,$where)){
			$this->sql=$leavesectionDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$leavesectionDBO = new LeavesectionDBO();
		if($leavesectionDBO->delete($obj,$where=""))		
			$this->sql=$leavesectionDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$leavesectionDBO = new LeavesectionDBO();
		$this->table=$leavesectionDBO->table;
		$leavesectionDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$leavesectionDBO->sql;
		$this->result=$leavesectionDBO->result;
		$this->fetchObject=$leavesectionDBO->fetchObject;
		$this->affectedRows=$leavesectionDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->sectionid)){
			$error="Section Id should be provided";
		}
		else if(empty($obj->sectionname)){
			$error="Section Name should be provided";
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
