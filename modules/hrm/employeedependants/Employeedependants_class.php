<?php 
require_once("EmployeedependantsDBO.php");
class Employeedependants
{				
	var $id;			
	var $employeeid;			
	var $name;			
	var $dob;
	var $relationship;
	var $email;
	var $mobile;
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeedependantsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->name=str_replace("'","\'",$obj->name);
		$this->dob=str_replace("'","\'",$obj->dob);
		$this->relationship=str_replace("'","\'",$obj->relationship);
		$this->email=str_replace("'","\'",$obj->email);
		$this->mobile=str_replace("'","\'",$obj->mobile);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get dob
	function getDob(){
		return $this->dob;
	}
	//set dob
	function setDob($dob){
		$this->dob=$dob;
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
		$employeedependantsDBO = new EmployeedependantsDBO();
		if($employeedependantsDBO->persist($obj)){
			$this->id=$employeedependantsDBO->id;
			$this->sql=$employeedependantsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeedependantsDBO = new EmployeedependantsDBO();
		if($employeedependantsDBO->update($obj,$where)){
			$this->sql=$employeedependantsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeedependantsDBO = new EmployeedependantsDBO();
		if($employeedependantsDBO->delete($obj,$where=""))		
			$this->sql=$employeedependantsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeedependantsDBO = new EmployeedependantsDBO();
		$this->table=$employeedependantsDBO->table;
		$employeedependantsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeedependantsDBO->sql;
		$this->result=$employeedependantsDBO->result;
		$this->fetchObject=$employeedependantsDBO->fetchObject;
		$this->affectedRows=$employeedependantsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->name)){
			$error="Dependant should be provided";
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
