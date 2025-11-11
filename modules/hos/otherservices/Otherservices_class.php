<?php 
require_once("OtherservicesDBO.php");
class Otherservices
{				
	var $id;			
	var $name;			
	var $departmentid;			
	var $charge;	
	var $nssfcharge;
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $otherservicesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		$this->charge=str_replace("'","\'",$obj->charge);
		$this->nssfcharge=str_replace("'","\'",$obj->nssfcharge);
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

	//get charge
	function getCharge(){
		return $this->charge;
	}
	//set charge
	function setCharge($charge){
		$this->charge=$charge;
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
		$otherservicesDBO = new OtherservicesDBO();
		if($otherservicesDBO->persist($obj)){
			$this->id=$otherservicesDBO->id;
			$this->sql=$otherservicesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$otherservicesDBO = new OtherservicesDBO();
		if($otherservicesDBO->update($obj,$where)){
			$this->sql=$otherservicesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$otherservicesDBO = new OtherservicesDBO();
		if($otherservicesDBO->delete($obj,$where=""))		
			$this->sql=$otherservicesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$otherservicesDBO = new OtherservicesDBO();
		$this->table=$otherservicesDBO->table;
		$otherservicesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$otherservicesDBO->sql;
		$this->result=$otherservicesDBO->result;
		$this->fetchObject=$otherservicesDBO->fetchObject;
		$this->affectedRows=$otherservicesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Other Service should be provided";
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
