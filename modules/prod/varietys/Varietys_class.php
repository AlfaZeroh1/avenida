<?php 
require_once("VarietysDBO.php");
class Varietys
{				
	var $id;			
	var $name;			
	var $typeid;			
	var $colourid;			
	var $duration;			
	var $quantity;			
	var $stems;			
	var $remarks;	
	var $type;	
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $varietysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->typeid))
			$obj->typeid='NULL';
		$this->typeid=$obj->typeid;
		if(empty($obj->colourid))
			$obj->colourid='NULL';
		$this->colourid=$obj->colourid;
		$this->duration=str_replace("'","\'",$obj->duration);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->stems=str_replace("'","\'",$obj->stems);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->type=str_replace("'","\'",$obj->type);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get typeid
	function getTypeid(){
		return $this->typeid;
	}
	//set typeid
	function setTypeid($typeid){
		$this->typeid=$typeid;
	}

	//get colourid
	function getColourid(){
		return $this->colourid;
	}
	//set colourid
	function setColourid($colourid){
		$this->colourid=$colourid;
	}

	//get duration
	function getDuration(){
		return $this->duration;
	}
	//set duration
	function setDuration($duration){
		$this->duration=$duration;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get stems
	function getStems(){
		return $this->stems;
	}
	//set stems
	function setStems($stems){
		$this->stems=$stems;
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
		$varietysDBO = new VarietysDBO();
		if($varietysDBO->persist($obj)){
			$this->id=$varietysDBO->id;
			$this->sql=$varietysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$varietysDBO = new VarietysDBO();
		if($varietysDBO->update($obj,$where)){
			$this->sql=$varietysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$varietysDBO = new VarietysDBO();
		if($varietysDBO->delete($obj,$where=""))		
			$this->sql=$varietysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$varietysDBO = new VarietysDBO();
		$this->table=$varietysDBO->table;
		$varietysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$varietysDBO->sql;
		$this->result=$varietysDBO->result;
		$this->fetchObject=$varietysDBO->fetchObject;
		$this->affectedRows=$varietysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Variety should be provided";
		}
		else if(empty($obj->typeid)){
			$error="Type should be provided";
		}
		else if(empty($obj->colourid)){
			$error="Colour should be provided";
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
