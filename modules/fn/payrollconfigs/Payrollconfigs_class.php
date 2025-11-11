<?php 
require_once("PayrollconfigsDBO.php");
class Payrollconfigs
{				
	var $id;			
	var $name;			
	var $type;			
	var $value;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $payrollconfigsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->type=str_replace("'","\'",$obj->type);
		$this->value=str_replace("'","\'",$obj->value);
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

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
	}

	//get value
	function getValue(){
		return $this->value;
	}
	//set value
	function setValue($value){
		$this->value=$value;
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
		$payrollconfigsDBO = new PayrollconfigsDBO();
		if($payrollconfigsDBO->persist($obj)){
			$this->id=$payrollconfigsDBO->id;
			$this->sql=$payrollconfigsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$payrollconfigsDBO = new PayrollconfigsDBO();
		if($payrollconfigsDBO->update($obj,$where)){
			$this->sql=$payrollconfigsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$payrollconfigsDBO = new PayrollconfigsDBO();
		if($payrollconfigsDBO->delete($obj,$where=""))		
			$this->sql=$payrollconfigsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$payrollconfigsDBO = new PayrollconfigsDBO();
		$this->table=$payrollconfigsDBO->table;
		$payrollconfigsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$payrollconfigsDBO->sql;
		$this->result=$payrollconfigsDBO->result;
		$this->fetchObject=$payrollconfigsDBO->fetchObject;
		$this->affectedRows=$payrollconfigsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->value)){
			$error="Value should be provided";
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
