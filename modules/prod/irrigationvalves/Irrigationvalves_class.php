<?php 
require_once("IrrigationvalvesDBO.php");
class Irrigationvalves
{				
	var $id;			
	var $irrigationid;			
	var $valveid;			
	var $quantity;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $irrigationvalvesDBO;
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
		if(empty($obj->valveid))
			$obj->valveid='NULL';
		$this->valveid=$obj->valveid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
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

	//get valveid
	function getValveid(){
		return $this->valveid;
	}
	//set valveid
	function setValveid($valveid){
		$this->valveid=$valveid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
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
		$irrigationvalvesDBO = new IrrigationvalvesDBO();
		if($irrigationvalvesDBO->persist($obj)){
			$this->id=$irrigationvalvesDBO->id;
			$this->sql=$irrigationvalvesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$irrigationvalvesDBO = new IrrigationvalvesDBO();
		if($irrigationvalvesDBO->update($obj,$where)){
			$this->sql=$irrigationvalvesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$irrigationvalvesDBO = new IrrigationvalvesDBO();
		if($irrigationvalvesDBO->delete($obj,$where=""))		
			$this->sql=$irrigationvalvesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$irrigationvalvesDBO = new IrrigationvalvesDBO();
		$this->table=$irrigationvalvesDBO->table;
		$irrigationvalvesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$irrigationvalvesDBO->sql;
		$this->result=$irrigationvalvesDBO->result;
		$this->fetchObject=$irrigationvalvesDBO->fetchObject;
		$this->affectedRows=$irrigationvalvesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->valveid)){
			$error="Valve should be provided";
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
