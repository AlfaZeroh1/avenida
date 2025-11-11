<?php 
require_once("ProjectsDBO.php");
class Projects
{				
	var $id;			
	var $customerid;			
	var $name;			
	var $description;			
	var $startdate;			
	var $expectedcompletion;			
	var $actualcompletion;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		$this->name=str_replace("'","\'",$obj->name);
		$this->description=str_replace("'","\'",$obj->description);
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->expectedcompletion=str_replace("'","\'",$obj->expectedcompletion);
		$this->actualcompletion=str_replace("'","\'",$obj->actualcompletion);
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

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
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

	//get startdate
	function getStartdate(){
		return $this->startdate;
	}
	//set startdate
	function setStartdate($startdate){
		$this->startdate=$startdate;
	}

	//get expectedcompletion
	function getExpectedcompletion(){
		return $this->expectedcompletion;
	}
	//set expectedcompletion
	function setExpectedcompletion($expectedcompletion){
		$this->expectedcompletion=$expectedcompletion;
	}

	//get actualcompletion
	function getActualcompletion(){
		return $this->actualcompletion;
	}
	//set actualcompletion
	function setActualcompletion($actualcompletion){
		$this->actualcompletion=$actualcompletion;
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
		$projectsDBO = new ProjectsDBO();
		if($projectsDBO->persist($obj)){
			$this->id=$projectsDBO->id;
			$this->sql=$projectsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectsDBO = new ProjectsDBO();
		if($projectsDBO->update($obj,$where)){
			$this->sql=$projectsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectsDBO = new ProjectsDBO();
		if($projectsDBO->delete($obj,$where=""))		
			$this->sql=$projectsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectsDBO = new ProjectsDBO();
		$this->table=$projectsDBO->table;
		$projectsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectsDBO->sql;
		$this->result=$projectsDBO->result;
		$this->fetchObject=$projectsDBO->fetchObject;
		$this->affectedRows=$projectsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
