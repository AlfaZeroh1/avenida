<?php 
require_once("BranchcategorysDBO.php");
class Branchcategorys
{				
	var $id;			
	var $brancheid;			
	var $categoryid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $branchcategorysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
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

	//get brancheid
	function getBrancheid(){
		return $this->brancheid;
	}
	//set brancheid
	function setBrancheid($brancheid){
		$this->brancheid=$brancheid;
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
		$branchcategorysDBO = new BranchcategorysDBO();
		if($branchcategorysDBO->persist($obj)){
			$this->id=$branchcategorysDBO->id;
			$this->sql=$branchcategorysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$branchcategorysDBO = new BranchcategorysDBO();
		if($branchcategorysDBO->update($obj,$where)){
			$this->sql=$branchcategorysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$branchcategorysDBO = new BranchcategorysDBO();
		if($branchcategorysDBO->delete($obj,$where=""))		
			$this->sql=$branchcategorysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$branchcategorysDBO = new BranchcategorysDBO();
		$this->table=$branchcategorysDBO->table;
		$branchcategorysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$branchcategorysDBO->sql;
		$this->result=$branchcategorysDBO->result;
		$this->fetchObject=$branchcategorysDBO->fetchObject;
		$this->affectedRows=$branchcategorysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->brancheid)){
			$error="Location should be provided";
		}
		else if(empty($obj->categoryid)){
			$error="Category should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->brancheid)){
			$error="Location should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
