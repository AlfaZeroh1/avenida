<?php 
require_once("AssetsDBO.php");
class Assets
{				
	var $id;			
	var $name;			
	var $categoryid;			
	var $quantity;			
	var $costprice;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $assetsDBO;
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
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
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

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get costprice
	function getCostprice(){
		return $this->costprice;
	}
	//set costprice
	function setCostprice($costprice){
		$this->costprice=$costprice;
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
		$assetsDBO = new AssetsDBO();
		if($assetsDBO->persist($obj)){
			$this->id=$assetsDBO->id;
			$this->sql=$assetsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$assetsDBO = new AssetsDBO();
		if($assetsDBO->update($obj,$where)){
			$this->sql=$assetsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$assetsDBO = new AssetsDBO();
		if($assetsDBO->delete($obj,$where=""))		
			$this->sql=$assetsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$assetsDBO = new AssetsDBO();
		$this->table=$assetsDBO->table;
		$assetsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$assetsDBO->sql;
		$this->result=$assetsDBO->result;
		$this->fetchObject=$assetsDBO->fetchObject;
		$this->affectedRows=$assetsDBO->affectedRows;
	}			
	function validate($obj){
	
		if(empty($obj->categoryid)){
			$error="Category should be provided";
		}
		
		if(!empty($error))
			return $error;
		else
			return null;
			
	}
	


	function validates($obj){
	
	
		if(empty($obj->categoryid)){
			$error="Category should be provided";
		}
		
		if(!empty($error))
			return $error;
		else
	
			return null;
	
	}
}				
?>
