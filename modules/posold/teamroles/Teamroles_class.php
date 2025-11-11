<?php 
require_once("TeamrolesDBO.php");
class Teamroles
{				
	var $id;			
	var $name;			
	var $type;
	var $levelid;
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $teamrolesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->type=str_replace("'","\'",$obj->type);
		if(empty($obj->levelid))
			$obj->levelid='NULL';
		$this->levelid=$obj->levelid;
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
		$teamrolesDBO = new TeamrolesDBO();
		if($teamrolesDBO->persist($obj)){
			$this->id=$teamrolesDBO->id;
			$this->sql=$teamrolesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$teamrolesDBO = new TeamrolesDBO();
		if($teamrolesDBO->update($obj,$where)){
			$this->sql=$teamrolesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$teamrolesDBO = new TeamrolesDBO();
		if($teamrolesDBO->delete($obj,$where=""))		
			$this->sql=$teamrolesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$teamrolesDBO = new TeamrolesDBO();
		$this->table=$teamrolesDBO->table;
		$teamrolesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$teamrolesDBO->sql;
		$this->result=$teamrolesDBO->result;
		$this->fetchObject=$teamrolesDBO->fetchObject;
		$this->affectedRows=$teamrolesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
