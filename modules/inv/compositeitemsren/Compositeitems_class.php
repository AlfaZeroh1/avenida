<?php 
require_once("CompositeitemsDBO.php");
class Compositeitems
{				
	var $id;
	var $brancheid;
	var $itemid;			
	var $itemid2;			
	var $quantity;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $compositeitemsDBO;
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
		
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
		
		$this->itemid2=str_replace("'","\'",$obj->itemid2);
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

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get itemid2
	function getItemid2(){
		return $this->itemid2;
	}
	//set itemid2
	function setItemid2($itemid2){
		$this->itemid2=$itemid2;
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
		$compositeitemsDBO = new CompositeitemsDBO();
		if($compositeitemsDBO->persist($obj)){
			$this->id=$compositeitemsDBO->id;
			$this->sql=$compositeitemsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$compositeitemsDBO = new CompositeitemsDBO();
		if($compositeitemsDBO->update($obj,$where)){
			$this->sql=$compositeitemsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$compositeitemsDBO = new CompositeitemsDBO();
		if($compositeitemsDBO->delete($obj,$where=""))		
			$this->sql=$compositeitemsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$compositeitemsDBO = new CompositeitemsDBO();
		$this->table=$compositeitemsDBO->table;
		$compositeitemsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$compositeitemsDBO->sql;
		$this->result=$compositeitemsDBO->result;
		$this->fetchObject=$compositeitemsDBO->fetchObject;
		$this->affectedRows=$compositeitemsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Product should be provided";
		}
		else if(empty($obj->itemid2)){
			$error="Constituent Product should be provided";
		}
		else if(empty($obj->quantity)){
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
