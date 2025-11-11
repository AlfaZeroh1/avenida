<?php 
require_once("WardsDBO.php");
class Wards
{				
	var $id;			
	var $name;			
	var $departmentid;			
	var $remarks;			
	var $firstroom;			
	var $lastroom;			
	var $roomprefix;			
	var $status;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $wardsDBO;
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
		$this->firstroom=str_replace("'","\'",$obj->firstroom);
		$this->lastroom=str_replace("'","\'",$obj->lastroom);
		$this->roomprefix=str_replace("'","\'",$obj->roomprefix);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get firstroom
	function getFirstroom(){
		return $this->firstroom;
	}
	//set firstroom
	function setFirstroom($firstroom){
		$this->firstroom=$firstroom;
	}

	//get lastroom
	function getLastroom(){
		return $this->lastroom;
	}
	//set lastroom
	function setLastroom($lastroom){
		$this->lastroom=$lastroom;
	}

	//get roomprefix
	function getRoomprefix(){
		return $this->roomprefix;
	}
	//set roomprefix
	function setRoomprefix($roomprefix){
		$this->roomprefix=$roomprefix;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		$wardsDBO = new WardsDBO();
		if($wardsDBO->persist($obj)){
			$this->id=$wardsDBO->id;
			$this->sql=$wardsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$wardsDBO = new WardsDBO();
		if($wardsDBO->update($obj,$where)){
			$this->sql=$wardsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$wardsDBO = new WardsDBO();
		if($wardsDBO->delete($obj,$where=""))		
			$this->sql=$wardsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$wardsDBO = new WardsDBO();
		$this->table=$wardsDBO->table;
		$wardsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$wardsDBO->sql;
		$this->result=$wardsDBO->result;
		$this->fetchObject=$wardsDBO->fetchObject;
		$this->affectedRows=$wardsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
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
