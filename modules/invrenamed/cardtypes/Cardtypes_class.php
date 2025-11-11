<?php 
require_once("CardtypesDBO.php");
class Cardtypes
{				
	var $id;			
	var $name;			
	var $discount;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $cardtypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
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
		$cardtypesDBO = new CardtypesDBO();
		if($cardtypesDBO->persist($obj)){
			$this->id=$cardtypesDBO->id;
			$this->sql=$cardtypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$cardtypesDBO = new CardtypesDBO();
		if($cardtypesDBO->update($obj,$where)){
			$this->sql=$cardtypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$cardtypesDBO = new CardtypesDBO();
		if($cardtypesDBO->delete($obj,$where=""))		
			$this->sql=$cardtypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$cardtypesDBO = new CardtypesDBO();
		$this->table=$cardtypesDBO->table;
		$cardtypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$cardtypesDBO->sql;
		$this->result=$cardtypesDBO->result;
		$this->fetchObject=$cardtypesDBO->fetchObject;
		$this->affectedRows=$cardtypesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Card Type should be provided";
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
