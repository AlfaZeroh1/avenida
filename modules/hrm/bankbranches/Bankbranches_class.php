<?php 
require_once("BankbranchesDBO.php");
class Bankbranches
{				
	var $id;			
	var $name;
	var $code;
	var $employeebankid;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $bankbranchesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->employeebankid))
			$obj->employeebankid='NULL';
		$this->employeebankid=$obj->employeebankid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->code=str_replace("'","\'",$obj->code);
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

	//get employeebankid
	function getEmployeebankid(){
		return $this->employeebankid;
	}
	//set employeebankid
	function setEmployeebankid($employeebankid){
		$this->employeebankid=$employeebankid;
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
		$bankbranchesDBO = new BankbranchesDBO();
		if($bankbranchesDBO->persist($obj)){
			$this->id=$bankbranchesDBO->id;
			$this->sql=$bankbranchesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$bankbranchesDBO = new BankbranchesDBO();
		if($bankbranchesDBO->update($obj,$where)){
			$this->sql=$bankbranchesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$bankbranchesDBO = new BankbranchesDBO();
		if($bankbranchesDBO->delete($obj,$where=""))		
			$this->sql=$bankbranchesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$bankbranchesDBO = new BankbranchesDBO();
		$this->table=$bankbranchesDBO->table;
		$bankbranchesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$bankbranchesDBO->sql;
		$this->result=$bankbranchesDBO->result;
		$this->fetchObject=$bankbranchesDBO->fetchObject;
		$this->affectedRows=$bankbranchesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeebankid)){
			$error="Bank should be provided";
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
