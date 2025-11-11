<?php 
require_once("TendertypesDBO.php");
class Tendertypes
{				
	var $id;			
	var $name;			
	var $description;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $tendertypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->description=str_replace("'","\'",$obj->description);
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

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
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
		$tendertypesDBO = new TendertypesDBO();
		if($tendertypesDBO->persist($obj)){
			$this->id=$tendertypesDBO->id;
			$this->sql=$tendertypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$tendertypesDBO = new TendertypesDBO();
		if($tendertypesDBO->update($obj,$where)){
			$this->sql=$tendertypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$tendertypesDBO = new TendertypesDBO();
		if($tendertypesDBO->delete($obj,$where=""))		
			$this->sql=$tendertypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$tendertypesDBO = new TendertypesDBO();
		$this->table=$tendertypesDBO->table;
		$tendertypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$tendertypesDBO->sql;
		$this->result=$tendertypesDBO->result;
		$this->fetchObject=$tendertypesDBO->fetchObject;
		$this->affectedRows=$tendertypesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Tender Type should be provided";
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
