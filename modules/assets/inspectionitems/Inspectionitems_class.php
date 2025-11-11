<?php 
require_once("InspectionitemsDBO.php");
class Inspectionitems
{				
	var $id;			
	var $name;			
	var $categoryid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $inspectionitemsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->categoryid))
			$obj->categoryid='NULL';
		$this->categoryid=$obj->categoryid;
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

	//get categoryid
	function getCategoryid(){
		return $this->categoryid;
	}
	//set categoryid
	function setCategoryid($categoryid){
		$this->categoryid=$categoryid;
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
		$inspectionitemsDBO = new InspectionitemsDBO();
		if($inspectionitemsDBO->persist($obj)){
			$this->id=$inspectionitemsDBO->id;
			$this->sql=$inspectionitemsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$inspectionitemsDBO = new InspectionitemsDBO();
		if($inspectionitemsDBO->update($obj,$where)){
			$this->sql=$inspectionitemsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$inspectionitemsDBO = new InspectionitemsDBO();
		if($inspectionitemsDBO->delete($obj,$where=""))		
			$this->sql=$inspectionitemsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$inspectionitemsDBO = new InspectionitemsDBO();
		$this->table=$inspectionitemsDBO->table;
		$inspectionitemsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$inspectionitemsDBO->sql;
		$this->result=$inspectionitemsDBO->result;
		$this->fetchObject=$inspectionitemsDBO->fetchObject;
		$this->affectedRows=$inspectionitemsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
