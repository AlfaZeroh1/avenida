<?php 
require_once("CategorydepartmentsDBO.php");
class Categorydepartments
{				
	var $id;			
	var $name;			
	var $departmentid;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $categorydepartmentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->departmentid=str_replace("'","\'",$obj->departmentid);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
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

	function add($obj){
		$categorydepartmentsDBO = new CategorydepartmentsDBO();
		if($categorydepartmentsDBO->persist($obj)){
			$this->id=$categorydepartmentsDBO->id;
			$this->sql=$categorydepartmentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$categorydepartmentsDBO = new CategorydepartmentsDBO();
		if($categorydepartmentsDBO->update($obj,$where)){
			$this->sql=$categorydepartmentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$categorydepartmentsDBO = new CategorydepartmentsDBO();
		if($categorydepartmentsDBO->delete($obj,$where=""))		
			$this->sql=$categorydepartmentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$categorydepartmentsDBO = new CategorydepartmentsDBO();
		$this->table=$categorydepartmentsDBO->table;
		$categorydepartmentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$categorydepartmentsDBO->sql;
		$this->result=$categorydepartmentsDBO->result;
		$this->fetchObject=$categorydepartmentsDBO->fetchObject;
		$this->affectedRows=$categorydepartmentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Department Category should be provided";
		}
		else if(empty($obj->departmentid)){
			$error="Department should be provided";
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
