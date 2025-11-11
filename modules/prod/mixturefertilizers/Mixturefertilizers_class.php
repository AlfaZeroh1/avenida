<?php 
require_once("MixturefertilizersDBO.php");
class Mixturefertilizers
{				
	var $id;			
	var $mixtureid;			
	var $fertilizerid;			
	var $quantity;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $mixturefertilizersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->mixtureid))
			$obj->mixtureid='NULL';
		$this->mixtureid=$obj->mixtureid;
		if(empty($obj->fertilizerid))
			$obj->fertilizerid='NULL';
		$this->fertilizerid=$obj->fertilizerid;
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

	//get mixtureid
	function getMixtureid(){
		return $this->mixtureid;
	}
	//set mixtureid
	function setMixtureid($mixtureid){
		$this->mixtureid=$mixtureid;
	}

	//get fertilizerid
	function getFertilizerid(){
		return $this->fertilizerid;
	}
	//set fertilizerid
	function setFertilizerid($fertilizerid){
		$this->fertilizerid=$fertilizerid;
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
		$mixturefertilizersDBO = new MixturefertilizersDBO();
		if($mixturefertilizersDBO->persist($obj)){
			$this->id=$mixturefertilizersDBO->id;
			$this->sql=$mixturefertilizersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$mixturefertilizersDBO = new MixturefertilizersDBO();
		if($mixturefertilizersDBO->update($obj,$where)){
			$this->sql=$mixturefertilizersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$mixturefertilizersDBO = new MixturefertilizersDBO();
		if($mixturefertilizersDBO->delete($obj,$where=""))		
			$this->sql=$mixturefertilizersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$mixturefertilizersDBO = new MixturefertilizersDBO();
		$this->table=$mixturefertilizersDBO->table;
		$mixturefertilizersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$mixturefertilizersDBO->sql;
		$this->result=$mixturefertilizersDBO->result;
		$this->fetchObject=$mixturefertilizersDBO->fetchObject;
		$this->affectedRows=$mixturefertilizersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->mixtureid)){
			$error="Mixture should be provided";
		}
		else if(empty($obj->fertilizerid)){
			$error="Fertilizer should be provided";
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
