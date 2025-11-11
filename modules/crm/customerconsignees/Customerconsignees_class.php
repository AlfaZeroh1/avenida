<?php 
require_once("CustomerconsigneesDBO.php");
class Customerconsignees
{				
	var $id;			
	var $customerid;			
	var $name;			
	var $address;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $customerconsigneesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		$this->name=str_replace("'","\'",$obj->name);
		$this->address=str_replace("'","\'",$obj->address);
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

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get address
	function getAddress(){
		return $this->address;
	}
	//set address
	function setAddress($address){
		$this->address=$address;
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
		$customerconsigneesDBO = new CustomerconsigneesDBO();
		if($customerconsigneesDBO->persist($obj)){
			$this->id=$customerconsigneesDBO->id;
			$this->sql=$customerconsigneesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$customerconsigneesDBO = new CustomerconsigneesDBO();
		if($customerconsigneesDBO->update($obj,$where)){
			$this->sql=$customerconsigneesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$customerconsigneesDBO = new CustomerconsigneesDBO();
		if($customerconsigneesDBO->delete($obj,$where=""))		
			$this->sql=$customerconsigneesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$customerconsigneesDBO = new CustomerconsigneesDBO();
		$this->table=$customerconsigneesDBO->table;
		$customerconsigneesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$customerconsigneesDBO->sql;
		$this->result=$customerconsigneesDBO->result;
		$this->fetchObject=$customerconsigneesDBO->fetchObject;
		$this->affectedRows=$customerconsigneesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
