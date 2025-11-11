<?php 
require_once("AssignmentsDBO.php");
class Assignments
{				
	var $id;			
	var $code;			
	var $name;			
	var $departmentid;			
	var $levelid;			
	var $leavesectionid;			
	var $sectionid;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $assignmentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->code=str_replace("'","\'",$obj->code);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		if(empty($obj->levelid))
			$obj->levelid='NULL';
		$this->levelid=$obj->levelid;
		$this->leavesectionid=str_replace("'","\'",$obj->leavesectionid);
		$this->sectionid=str_replace("'","\'",$obj->sectionid);
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

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
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

	//get levelid
	function getLevelid(){
		return $this->levelid;
	}
	//set levelid
	function setLevelid($levelid){
		$this->levelid=$levelid;
	}

	//get leavesectionid
	function getLeavesectionid(){
		return $this->leavesectionid;
	}
	//set leavesectionid
	function setLeavesectionid($leavesectionid){
		$this->leavesectionid=$leavesectionid;
	}

	//get sectionid
	function getSectionid(){
		return $this->sectionid;
	}
	//set sectionid
	function setSectionid($sectionid){
		$this->sectionid=$sectionid;
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
		$assignmentsDBO = new AssignmentsDBO();
		if($assignmentsDBO->persist($obj)){
			$this->id=$assignmentsDBO->id;
			$this->sql=$assignmentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$assignmentsDBO = new AssignmentsDBO();
		if($assignmentsDBO->update($obj,$where)){
			$this->sql=$assignmentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$assignmentsDBO = new AssignmentsDBO();
		if($assignmentsDBO->delete($obj,$where=""))		
			$this->sql=$assignmentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$assignmentsDBO = new AssignmentsDBO();
		$this->table=$assignmentsDBO->table;
		$assignmentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$assignmentsDBO->sql;
		$this->result=$assignmentsDBO->result;
		$this->fetchObject=$assignmentsDBO->fetchObject;
		$this->affectedRows=$assignmentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->code)){
			$error="Code should be provided";
		}
		else if(empty($obj->name)){
			$error="Name should be provided";
		}
		else if(empty($obj->departmentid)){
			$error="Department should be provided";
		}
		else if(empty($obj->sectionid)){
			$error="Section should be provided";
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
