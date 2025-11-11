<?php 
require_once("EstimationmanualitemsDBO.php");
class Estimationmanualitems
{				
	var $id;			
	var $estimationmanualid;			
	var $itemid;			
	var $labourid;			
	var $quantity;			
	var $rate;			
	var $total;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $estimationmanualitemsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->estimationmanualid))
			$obj->estimationmanualid='NULL';
		$this->estimationmanualid=$obj->estimationmanualid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->labourid))
			$obj->labourid='NULL';
		$this->labourid=$obj->labourid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->rate=str_replace("'","\'",$obj->rate);
		$this->total=str_replace("'","\'",$obj->total);
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

	//get estimationmanualid
	function getEstimationmanualid(){
		return $this->estimationmanualid;
	}
	//set estimationmanualid
	function setEstimationmanualid($estimationmanualid){
		$this->estimationmanualid=$estimationmanualid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get labourid
	function getLabourid(){
		return $this->labourid;
	}
	//set labourid
	function setLabourid($labourid){
		$this->labourid=$labourid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get rate
	function getRate(){
		return $this->rate;
	}
	//set rate
	function setRate($rate){
		$this->rate=$rate;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
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
		$estimationmanualitemsDBO = new EstimationmanualitemsDBO();
		if($estimationmanualitemsDBO->persist($obj)){
			$this->id=$estimationmanualitemsDBO->id;
			$this->sql=$estimationmanualitemsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$estimationmanualitemsDBO = new EstimationmanualitemsDBO();
		if($estimationmanualitemsDBO->update($obj,$where)){
			$this->sql=$estimationmanualitemsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$estimationmanualitemsDBO = new EstimationmanualitemsDBO();
		if($estimationmanualitemsDBO->delete($obj,$where=""))		
			$this->sql=$estimationmanualitemsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$estimationmanualitemsDBO = new EstimationmanualitemsDBO();
		$this->table=$estimationmanualitemsDBO->table;
		$estimationmanualitemsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$estimationmanualitemsDBO->sql;
		$this->result=$estimationmanualitemsDBO->result;
		$this->fetchObject=$estimationmanualitemsDBO->fetchObject;
		$this->affectedRows=$estimationmanualitemsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->quantity)){
			$error="Quantity should be provided";
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
