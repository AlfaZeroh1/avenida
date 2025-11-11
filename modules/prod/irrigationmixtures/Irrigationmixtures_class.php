<?php 
require_once("IrrigationmixturesDBO.php");
class Irrigationmixtures
{				
	var $id;			
	var $irrigationid;			
	var $tankid;			
	var $water;			
	var $ec;			
	var $ph;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $irrigationmixturesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->irrigationid))
			$obj->irrigationid='NULL';
		$this->irrigationid=$obj->irrigationid;
		if(empty($obj->tankid))
			$obj->tankid='NULL';
		$this->tankid=$obj->tankid;
		$this->water=str_replace("'","\'",$obj->water);
		$this->ec=str_replace("'","\'",$obj->ec);
		$this->ph=str_replace("'","\'",$obj->ph);
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

	//get irrigationid
	function getIrrigationid(){
		return $this->irrigationid;
	}
	//set irrigationid
	function setIrrigationid($irrigationid){
		$this->irrigationid=$irrigationid;
	}

	//get tankid
	function getTankid(){
		return $this->tankid;
	}
	//set tankid
	function setTankid($tankid){
		$this->tankid=$tankid;
	}

	//get water
	function getWater(){
		return $this->water;
	}
	//set water
	function setWater($water){
		$this->water=$water;
	}

	//get ec
	function getEc(){
		return $this->ec;
	}
	//set ec
	function setEc($ec){
		$this->ec=$ec;
	}

	//get ph
	function getPh(){
		return $this->ph;
	}
	//set ph
	function setPh($ph){
		$this->ph=$ph;
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
		$irrigationmixturesDBO = new IrrigationmixturesDBO();
		if($irrigationmixturesDBO->persist($obj)){
			$this->id=$irrigationmixturesDBO->id;
			$this->sql=$irrigationmixturesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$irrigationmixturesDBO = new IrrigationmixturesDBO();
		if($irrigationmixturesDBO->update($obj,$where)){
			$this->sql=$irrigationmixturesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$irrigationmixturesDBO = new IrrigationmixturesDBO();
		if($irrigationmixturesDBO->delete($obj,$where=""))		
			$this->sql=$irrigationmixturesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$irrigationmixturesDBO = new IrrigationmixturesDBO();
		$this->table=$irrigationmixturesDBO->table;
		$irrigationmixturesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$irrigationmixturesDBO->sql;
		$this->result=$irrigationmixturesDBO->result;
		$this->fetchObject=$irrigationmixturesDBO->fetchObject;
		$this->affectedRows=$irrigationmixturesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->tankid)){
			$error="Tank should be provided";
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
