<?php 
require_once("EstimatedetailsDBO.php");
class Estimatedetails
{				
	var $id;			
	var $estimateid;			
	var $itemid;			
	var $quantity;			
	var $unitid;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $estimatedetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->estimateid))
			$obj->estimateid='NULL';
		$this->estimateid=$obj->estimateid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		if(empty($obj->unitid))
			$obj->unitid='NULL';
		$this->unitid=$obj->unitid;
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

	//get estimateid
	function getEstimateid(){
		return $this->estimateid;
	}
	//set estimateid
	function setEstimateid($estimateid){
		$this->estimateid=$estimateid;
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

	//get unitid
	function getUnitid(){
		return $this->unitid;
	}
	//set unitid
	function setUnitid($unitid){
		$this->unitid=$unitid;
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
		$estimatedetailsDBO = new EstimatedetailsDBO();
		if($estimatedetailsDBO->persist($obj)){
			$this->id=$estimatedetailsDBO->id;
			$this->sql=$estimatedetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$estimatedetailsDBO = new EstimatedetailsDBO();
		if($estimatedetailsDBO->update($obj,$where)){
			$this->sql=$estimatedetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$estimatedetailsDBO = new EstimatedetailsDBO();
		if($estimatedetailsDBO->delete($obj,$where=""))		
			$this->sql=$estimatedetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$estimatedetailsDBO = new EstimatedetailsDBO();
		$this->table=$estimatedetailsDBO->table;
		$estimatedetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$estimatedetailsDBO->sql;
		$this->result=$estimatedetailsDBO->result;
		$this->fetchObject=$estimatedetailsDBO->fetchObject;
		$this->affectedRows=$estimatedetailsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
