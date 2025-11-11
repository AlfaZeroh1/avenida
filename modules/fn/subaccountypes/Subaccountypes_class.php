<?php 
require_once("SubaccountypesDBO.php");
class Subaccountypes
{				
	var $id;			
	var $name;			
	var $accounttypeid;			
	var $priority;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $subaccountypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->accounttypeid))
			$obj->accounttypeid='NULL';
		$this->accounttypeid=$obj->accounttypeid;
		$this->priority=str_replace("'","\'",$obj->priority);
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

	//get accounttypeid
	function getAccounttypeid(){
		return $this->accounttypeid;
	}
	//set accounttypeid
	function setAccounttypeid($accounttypeid){
		$this->accounttypeid=$accounttypeid;
	}

	//get priority
	function getPriority(){
		return $this->priority;
	}
	//set priority
	function setPriority($priority){
		$this->priority=$priority;
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
		$subaccountypesDBO = new SubaccountypesDBO();
		if($subaccountypesDBO->persist($obj)){
			$this->id=$subaccountypesDBO->id;
			$this->sql=$subaccountypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$subaccountypesDBO = new SubaccountypesDBO();
		if($subaccountypesDBO->update($obj,$where)){
			$this->sql=$subaccountypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$subaccountypesDBO = new SubaccountypesDBO();
		if($subaccountypesDBO->delete($obj,$where=""))		
			$this->sql=$subaccountypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$subaccountypesDBO = new SubaccountypesDBO();
		$this->table=$subaccountypesDBO->table;
		$subaccountypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$subaccountypesDBO->sql;
		$this->result=$subaccountypesDBO->result;
		$this->fetchObject=$subaccountypesDBO->fetchObject;
		$this->affectedRows=$subaccountypesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Sub Account should be provided";
		}
		else if(empty($obj->accounttypeid)){
			$error="Account Type should be provided";
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
