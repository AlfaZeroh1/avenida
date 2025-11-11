<?php 
require_once("SamDBO.php");
class Sam
{				
	var $id;			
	var $firstname;			
	var $othernames;			
	var $address;			
	var $brancheid;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $samDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->firstname=str_replace("'","\'",$obj->firstname);
		$this->othernames=str_replace("'","\'",$obj->othernames);
		$this->address=str_replace("'","\'",$obj->address);
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
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

	//get firstname
	function getFirstname(){
		return $this->firstname;
	}
	//set firstname
	function setFirstname($firstname){
		$this->firstname=$firstname;
	}

	//get othernames
	function getOthernames(){
		return $this->othernames;
	}
	//set othernames
	function setOthernames($othernames){
		$this->othernames=$othernames;
	}

	//get address
	function getAddress(){
		return $this->address;
	}
	//set address
	function setAddress($address){
		$this->address=$address;
	}

	//get brancheid
	function getBrancheid(){
		return $this->brancheid;
	}
	//set brancheid
	function setBrancheid($brancheid){
		$this->brancheid=$brancheid;
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
		$samDBO = new SamDBO();
		if($samDBO->persist($obj)){
			$this->id=$samDBO->id;
			$this->sql=$samDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$samDBO = new SamDBO();
		if($samDBO->update($obj,$where)){
			$this->sql=$samDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$samDBO = new SamDBO();
		if($samDBO->delete($obj,$where=""))		
			$this->sql=$samDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$samDBO = new SamDBO();
		$this->table=$samDBO->table;
		$samDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$samDBO->sql;
		$this->result=$samDBO->result;
		$this->fetchObject=$samDBO->fetchObject;
		$this->affectedRows=$samDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->firstname)){
			$error="First Name should be provided";
		}
		else if(empty($obj->brancheid)){
			$error="Branch should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->brancheid)){
			$error="Branch should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
