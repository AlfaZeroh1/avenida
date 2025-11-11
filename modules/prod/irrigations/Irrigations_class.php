<?php 
require_once("IrrigationsDBO.php");
class Irrigations
{				
	var $id;			
	var $irrigationsystemid;			
	var $irrigationdate;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $irrigationsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->irrigationsystemid))
			$obj->irrigationsystemid='NULL';
		$this->irrigationsystemid=$obj->irrigationsystemid;
		$this->irrigationdate=str_replace("'","\'",$obj->irrigationdate);
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

	//get irrigationsystemid
	function getIrrigationsystemid(){
		return $this->irrigationsystemid;
	}
	//set irrigationsystemid
	function setIrrigationsystemid($irrigationsystemid){
		$this->irrigationsystemid=$irrigationsystemid;
	}

	//get irrigationdate
	function getIrrigationdate(){
		return $this->irrigationdate;
	}
	//set irrigationdate
	function setIrrigationdate($irrigationdate){
		$this->irrigationdate=$irrigationdate;
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
		$irrigationsDBO = new IrrigationsDBO();
		if($irrigationsDBO->persist($obj)){
			$this->id=$irrigationsDBO->id;
			$this->sql=$irrigationsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$irrigationsDBO = new IrrigationsDBO();
		if($irrigationsDBO->update($obj,$where)){
			$this->sql=$irrigationsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$irrigationsDBO = new IrrigationsDBO();
		if($irrigationsDBO->delete($obj,$where=""))		
			$this->sql=$irrigationsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$irrigationsDBO = new IrrigationsDBO();
		$this->table=$irrigationsDBO->table;
		$irrigationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$irrigationsDBO->sql;
		$this->result=$irrigationsDBO->result;
		$this->fetchObject=$irrigationsDBO->fetchObject;
		$this->affectedRows=$irrigationsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->irrigationsystemid)){
			$error="Irrigation System should be provided";
		}
		else if(empty($obj->irrigationdate)){
			$error="Irrigation Date should be provided";
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
