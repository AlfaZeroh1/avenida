<?php 
require_once("DepartmentcategorysDBO.php");
class Departmentcategorys
{				
	var $id;			
	var $departmentid;			
	var $name;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $departmentcategorysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->departmentid=str_replace("'","\'",$obj->departmentid);
		$this->name=str_replace("'","\'",$obj->name);
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

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
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
		$departmentcategorysDBO = new DepartmentcategorysDBO();
		if($departmentcategorysDBO->persist($obj)){
			$this->id=$departmentcategorysDBO->id;
			$this->sql=$departmentcategorysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$departmentcategorysDBO = new DepartmentcategorysDBO();
		if($departmentcategorysDBO->update($obj,$where)){
			$this->sql=$departmentcategorysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$departmentcategorysDBO = new DepartmentcategorysDBO();
		if($departmentcategorysDBO->delete($obj,$where=""))		
			$this->sql=$departmentcategorysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$departmentcategorysDBO = new DepartmentcategorysDBO();
		$this->table=$departmentcategorysDBO->table;
		$departmentcategorysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$departmentcategorysDBO->sql;
		$this->result=$departmentcategorysDBO->result;
		$this->fetchObject=$departmentcategorysDBO->fetchObject;
		$this->affectedRows=$departmentcategorysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->departmentid)){
			$error="Department should be provided";
		}
		else if(empty($obj->name)){
			$error="Category should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->departmentid)){
			$error="Department should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
