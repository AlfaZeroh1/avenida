<?php 
require_once("FleetmodelsDBO.php");
class Fleetmodels
{				
	var $id;			
	var $name;			
	var $fleetmakeid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $fleetmodelsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->fleetmakeid))
			$obj->fleetmakeid='NULL';
		$this->fleetmakeid=$obj->fleetmakeid;
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get fleetmakeid
	function getFleetmakeid(){
		return $this->fleetmakeid;
	}
	//set fleetmakeid
	function setFleetmakeid($fleetmakeid){
		$this->fleetmakeid=$fleetmakeid;
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
		$fleetmodelsDBO = new FleetmodelsDBO();
		if($fleetmodelsDBO->persist($obj)){
			$this->id=$fleetmodelsDBO->id;
			$this->sql=$fleetmodelsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$fleetmodelsDBO = new FleetmodelsDBO();
		if($fleetmodelsDBO->update($obj,$where)){
			$this->sql=$fleetmodelsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$fleetmodelsDBO = new FleetmodelsDBO();
		if($fleetmodelsDBO->delete($obj,$where=""))		
			$this->sql=$fleetmodelsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$fleetmodelsDBO = new FleetmodelsDBO();
		$this->table=$fleetmodelsDBO->table;
		$fleetmodelsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$fleetmodelsDBO->sql;
		$this->result=$fleetmodelsDBO->result;
		$this->fetchObject=$fleetmodelsDBO->fetchObject;
		$this->affectedRows=$fleetmodelsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Model should be provided";
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
