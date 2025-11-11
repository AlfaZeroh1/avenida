<?php 
require_once("EstimatesDBO.php");
class Estimates
{				
	var $id;			
	var $itemid;			
	var $itemdetailid;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $estimatesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->itemdetailid))
			$obj->itemdetailid='NULL';
		$this->itemdetailid=$obj->itemdetailid;
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

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get itemdetailid
	function getItemdetailid(){
		return $this->itemdetailid;
	}
	//set itemdetailid
	function setItemdetailid($itemdetailid){
		$this->itemdetailid=$itemdetailid;
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
		$estimatesDBO = new EstimatesDBO();
		if($estimatesDBO->persist($obj)){
			$this->id=$estimatesDBO->id;
			$this->sql=$estimatesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$estimatesDBO = new EstimatesDBO();
		if($estimatesDBO->update($obj,$where)){
			$this->sql=$estimatesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$estimatesDBO = new EstimatesDBO();
		if($estimatesDBO->delete($obj,$where=""))		
			$this->sql=$estimatesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$estimatesDBO = new EstimatesDBO();
		$this->table=$estimatesDBO->table;
		$estimatesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$estimatesDBO->sql;
		$this->result=$estimatesDBO->result;
		$this->fetchObject=$estimatesDBO->fetchObject;
		$this->affectedRows=$estimatesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
