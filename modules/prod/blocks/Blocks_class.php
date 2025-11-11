<?php 
require_once("BlocksDBO.php");
class Blocks
{				
	var $id;			
	var $name;			
	var $length;			
	var $width;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $blocksDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->length=str_replace("'","\'",$obj->length);
		$this->width=str_replace("'","\'",$obj->width);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get length
	function getLength(){
		return $this->length;
	}
	//set length
	function setLength($length){
		$this->length=$length;
	}

	//get width
	function getWidth(){
		return $this->width;
	}
	//set width
	function setWidth($width){
		$this->width=$width;
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
		$blocksDBO = new BlocksDBO();
		if($blocksDBO->persist($obj)){
			$this->id=$blocksDBO->id;
			$this->sql=$blocksDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$blocksDBO = new BlocksDBO();
		if($blocksDBO->update($obj,$where)){
			$this->sql=$blocksDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$blocksDBO = new BlocksDBO();
		if($blocksDBO->delete($obj,$where=""))		
			$this->sql=$blocksDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$blocksDBO = new BlocksDBO();
		$this->table=$blocksDBO->table;
		$blocksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$blocksDBO->sql;
		$this->result=$blocksDBO->result;
		$this->fetchObject=$blocksDBO->fetchObject;
		$this->affectedRows=$blocksDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Block should be provided";
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
