<?php 
require_once("SystemblocksDBO.php");
class Systemblocks
{				
	var $id;			
	var $systemid;			
	var $blockid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $systemblocksDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->systemid))
			$obj->systemid='NULL';
		$this->systemid=$obj->systemid;
		if(empty($obj->blockid))
			$obj->blockid='NULL';
		$this->blockid=$obj->blockid;
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

	//get systemid
	function getSystemid(){
		return $this->systemid;
	}
	//set systemid
	function setSystemid($systemid){
		$this->systemid=$systemid;
	}

	//get blockid
	function getBlockid(){
		return $this->blockid;
	}
	//set blockid
	function setBlockid($blockid){
		$this->blockid=$blockid;
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
		$systemblocksDBO = new SystemblocksDBO();
		if($systemblocksDBO->persist($obj)){
			$this->id=$systemblocksDBO->id;
			$this->sql=$systemblocksDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$systemblocksDBO = new SystemblocksDBO();
		if($systemblocksDBO->update($obj,$where)){
			$this->sql=$systemblocksDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$systemblocksDBO = new SystemblocksDBO();
		if($systemblocksDBO->delete($obj,$where=""))		
			$this->sql=$systemblocksDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$systemblocksDBO = new SystemblocksDBO();
		$this->table=$systemblocksDBO->table;
		$systemblocksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$systemblocksDBO->sql;
		$this->result=$systemblocksDBO->result;
		$this->fetchObject=$systemblocksDBO->fetchObject;
		$this->affectedRows=$systemblocksDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->blockid)){
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
