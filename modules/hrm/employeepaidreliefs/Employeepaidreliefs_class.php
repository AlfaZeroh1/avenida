<?php 
require_once("EmployeepaidreliefsDBO.php");
class Employeepaidreliefs
{				
	var $id;			
	var $employeeid;			
	var $employeereliefid;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeepaidreliefsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->employeereliefid=str_replace("'","\'",$obj->employeereliefid);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get employeereliefid
	function getEmployeereliefid(){
		return $this->employeereliefid;
	}
	//set employeereliefid
	function setEmployeereliefid($employeereliefid){
		$this->employeereliefid=$employeereliefid;
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
		$employeepaidreliefsDBO = new EmployeepaidreliefsDBO();
		if($employeepaidreliefsDBO->persist($obj)){
			$this->id=$employeepaidreliefsDBO->id;
			$this->sql=$employeepaidreliefsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeepaidreliefsDBO = new EmployeepaidreliefsDBO();
		if($employeepaidreliefsDBO->update($obj,$where)){
			$this->sql=$employeepaidreliefsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeepaidreliefsDBO = new EmployeepaidreliefsDBO();
		if($employeepaidreliefsDBO->delete($obj,$where=""))		
			$this->sql=$employeepaidreliefsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeepaidreliefsDBO = new EmployeepaidreliefsDBO();
		$this->table=$employeepaidreliefsDBO->table;
		$employeepaidreliefsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeepaidreliefsDBO->sql;
		$this->result=$employeepaidreliefsDBO->result;
		$this->fetchObject=$employeepaidreliefsDBO->fetchObject;
		$this->affectedRows=$employeepaidreliefsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->employeereliefid)){
			$error="Employee Relief should be provided";
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
