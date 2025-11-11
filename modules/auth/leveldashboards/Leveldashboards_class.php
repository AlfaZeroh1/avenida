<?php 
require_once("LeveldashboardsDBO.php");
class Leveldashboards
{				
	var $id;			
	var $levelid;			
	var $dashboardid;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $leveldashboardsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->levelid))
			$obj->levelid='NULL';
		$this->levelid=$obj->levelid;
		if(empty($obj->dashboardid))
			$obj->dashboardid='NULL';
		$this->dashboardid=$obj->dashboardid;
		$this->status=str_replace("'","\'",$obj->status);
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

	//get levelid
	function getLevelid(){
		return $this->levelid;
	}
	//set levelid
	function setLevelid($levelid){
		$this->levelid=$levelid;
	}

	//get dashboardid
	function getDashboardid(){
		return $this->dashboardid;
	}
	//set dashboardid
	function setDashboardid($dashboardid){
		$this->dashboardid=$dashboardid;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		$leveldashboardsDBO = new LeveldashboardsDBO();
		if($leveldashboardsDBO->persist($obj)){
			$this->id=$leveldashboardsDBO->id;
			$this->sql=$leveldashboardsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$leveldashboardsDBO = new LeveldashboardsDBO();
		if($leveldashboardsDBO->update($obj,$where)){
			$this->sql=$leveldashboardsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$leveldashboardsDBO = new LeveldashboardsDBO();
		if($leveldashboardsDBO->delete($obj,$where=""))		
			$this->sql=$leveldashboardsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$leveldashboardsDBO = new LeveldashboardsDBO();
		$this->table=$leveldashboardsDBO->table;
		$leveldashboardsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$leveldashboardsDBO->sql;
		$this->result=$leveldashboardsDBO->result;
		$this->fetchObject=$leveldashboardsDBO->fetchObject;
		$this->affectedRows=$leveldashboardsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->dashboardid)){
			$error="Dash Board Statistic should be provided";
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
