<?php 
require_once("ProjectstatusDBO.php");
class Projectstatus
{				
	var $id;			
	var $projectid;			
	var $statusid;			
	var $changedon;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectstatusDBO;
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
		if(empty($obj->statusid))
			$obj->statusid='NULL';
		$this->statusid=$obj->statusid;
		$this->changedon=str_replace("'","\'",$obj->changedon);
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

	//get statusid
	function getStatusid(){
		return $this->statusid;
	}
	//set statusid
	function setStatusid($statusid){
		$this->statusid=$statusid;
	}

	//get changedon
	function getChangedon(){
		return $this->changedon;
	}
	//set changedon
	function setChangedon($changedon){
		$this->changedon=$changedon;
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
		$projectstatusDBO = new ProjectstatusDBO();
		if($projectstatusDBO->persist($obj)){
			$this->id=$projectstatusDBO->id;
			$this->sql=$projectstatusDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectstatusDBO = new ProjectstatusDBO();
		if($projectstatusDBO->update($obj,$where)){
			$this->sql=$projectstatusDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectstatusDBO = new ProjectstatusDBO();
		if($projectstatusDBO->delete($obj,$where=""))		
			$this->sql=$projectstatusDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectstatusDBO = new ProjectstatusDBO();
		$this->table=$projectstatusDBO->table;
		$projectstatusDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectstatusDBO->sql;
		$this->result=$projectstatusDBO->result;
		$this->fetchObject=$projectstatusDBO->fetchObject;
		$this->affectedRows=$projectstatusDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->projectid)){
			$error="Project should be provided";
		}
		else if(empty($obj->statusid)){
			$error="Status should be provided";
		}
		else if(empty($obj->changedon)){
			$error="Status Changed On should be provided";
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
