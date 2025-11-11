<?php 
require_once("BedsDBO.php");
class Beds
{				
	var $id;			
	var $wardid;			
	var $roomno;			
	var $name;			
	var $status;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $bedsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->wardid))
			$obj->wardid='NULL';
		$this->wardid=$obj->wardid;
		$this->roomno=str_replace("'","\'",$obj->roomno);
		$this->name=str_replace("'","\'",$obj->name);
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

	//get wardid
	function getWardid(){
		return $this->wardid;
	}
	//set wardid
	function setWardid($wardid){
		$this->wardid=$wardid;
	}

	//get roomno
	function getRoomno(){
		return $this->roomno;
	}
	//set roomno
	function setRoomno($roomno){
		$this->roomno=$roomno;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
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
		$bedsDBO = new BedsDBO();
		if($bedsDBO->persist($obj)){
			$this->id=$bedsDBO->id;
			$this->sql=$bedsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$bedsDBO = new BedsDBO();
		if($bedsDBO->update($obj,$where)){
			$this->sql=$bedsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$bedsDBO = new BedsDBO();
		if($bedsDBO->delete($obj,$where=""))		
			$this->sql=$bedsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$bedsDBO = new BedsDBO();
		$this->table=$bedsDBO->table;
		$bedsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$bedsDBO->sql;
		$this->result=$bedsDBO->result;
		$this->fetchObject=$bedsDBO->fetchObject;
		$this->affectedRows=$bedsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->roomno)){
			$error="Room Number should be provided";
		}
		else if(empty($obj->name)){
			$error="Beds should be provided";
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
