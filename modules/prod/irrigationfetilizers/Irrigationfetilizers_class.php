<?php 
require_once("IrrigationfetilizersDBO.php");
class Irrigationfetilizers
{				
	var $id;			
	var $irrigationid;			
	var $fertilizerid;			
	var $amount;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $irrigationfetilizersDBO;
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
		if(empty($obj->fertilizerid))
			$obj->fertilizerid='NULL';
		$this->fertilizerid=$obj->fertilizerid;
		$this->amount=str_replace("'","\'",$obj->amount);
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

	//get fertilizerid
	function getFertilizerid(){
		return $this->fertilizerid;
	}
	//set fertilizerid
	function setFertilizerid($fertilizerid){
		$this->fertilizerid=$fertilizerid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
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
		$irrigationfetilizersDBO = new IrrigationfetilizersDBO();
		if($irrigationfetilizersDBO->persist($obj)){
			$this->id=$irrigationfetilizersDBO->id;
			$this->sql=$irrigationfetilizersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$irrigationfetilizersDBO = new IrrigationfetilizersDBO();
		if($irrigationfetilizersDBO->update($obj,$where)){
			$this->sql=$irrigationfetilizersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$irrigationfetilizersDBO = new IrrigationfetilizersDBO();
		if($irrigationfetilizersDBO->delete($obj,$where=""))		
			$this->sql=$irrigationfetilizersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$irrigationfetilizersDBO = new IrrigationfetilizersDBO();
		$this->table=$irrigationfetilizersDBO->table;
		$irrigationfetilizersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$irrigationfetilizersDBO->sql;
		$this->result=$irrigationfetilizersDBO->result;
		$this->fetchObject=$irrigationfetilizersDBO->fetchObject;
		$this->affectedRows=$irrigationfetilizersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->irrigationid)){
			$error="Irrigation should be provided";
		}
		else if(empty($obj->fertilizerid)){
			$error="Fertilizer should be provided";
		}
		else if(empty($obj->amount)){
			$error="Amount (Kgs) should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->amount)){
			$error="Amount (Kgs) should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
