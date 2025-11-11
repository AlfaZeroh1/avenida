<?php 
require_once("EstimationdetailsDBO.php");
class Estimationdetails
{				
	var $id;			
	var $estimationid;			
	var $itemid;			
	var $quantity;
	var $type;
	var $types;
	var $unitofmeasureid;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $estimationdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->estimationid))
			$obj->estimationid='NULL';
		$this->estimationid=$obj->estimationid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		if(empty($obj->unitofmeasureid))
			$obj->unitofmeasureid='NULL';
		$this->unitofmeasureid=$obj->unitofmeasureid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->type=str_replace("'","\'",$obj->type);
		$this->types=str_replace("'","\'",$obj->types);
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

	//get estimationid
	function getEstimationid(){
		return $this->estimationid;
	}
	//set estimationid
	function setEstimationid($estimationid){
		$this->estimationid=$estimationid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get unitofmeasureid
	function getUnitofmeasureid(){
		return $this->unitofmeasureid;
	}
	//set unitofmeasureid
	function setUnitofmeasureid($unitofmeasureid){
		$this->unitofmeasureid=$unitofmeasureid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$estimationdetailsDBO = new EstimationdetailsDBO();
		if($estimationdetailsDBO->persist($obj)){
			$this->id=$estimationdetailsDBO->id;
			$this->sql=$estimationdetailsDBO->sql;
			$obj->estimationid=$estimationsDBO->id;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$estimationdetailsDBO = new EstimationdetailsDBO();
		if($estimationdetailsDBO->update($obj,$where)){
			$this->sql=$estimationdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$estimationdetailsDBO = new EstimationdetailsDBO();
		if($estimationdetailsDBO->delete($obj,$where=""))		
			$this->sql=$estimationdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$estimationdetailsDBO = new EstimationdetailsDBO();
		$this->table=$estimationdetailsDBO->table;
		$estimationdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$estimationdetailsDBO->sql;
		$this->result=$estimationdetailsDBO->result;
		$this->fetchObject=$estimationdetailsDBO->fetchObject;
		$this->affectedRows=$estimationdetailsDBO->affectedRows;
	}			
	function validate($obj){
		
	
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
