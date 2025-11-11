<?php 
require_once("MaterialsubcategorysDBO.php");
class Materialsubcategorys
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
	var $materialsubcategorysDBO;
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
		$materialsubcategorysDBO = new MaterialsubcategorysDBO();
		if($materialsubcategorysDBO->persist($obj)){
			$this->id=$materialsubcategorysDBO->id;
			$this->sql=$materialsubcategorysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$materialsubcategorysDBO = new MaterialsubcategorysDBO();
		if($materialsubcategorysDBO->update($obj,$where)){
			$this->sql=$materialsubcategorysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$materialsubcategorysDBO = new MaterialsubcategorysDBO();
		if($materialsubcategorysDBO->delete($obj,$where=""))		
			$this->sql=$materialsubcategorysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$materialsubcategorysDBO = new MaterialsubcategorysDBO();
		$this->table=$materialsubcategorysDBO->table;
		$materialsubcategorysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$materialsubcategorysDBO->sql;
		$this->result=$materialsubcategorysDBO->result;
		$this->fetchObject=$materialsubcategorysDBO->fetchObject;
		$this->affectedRows=$materialsubcategorysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Material's Sub-Category should be provided";
		}
		else if(empty($obj->categoryid)){
			$error="Material Category should be provided";
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
