<?php 
require_once("CategorysizesDBO.php");
class Categorysizes
{				
	var $id;			
	var $categoryid;			
	var $sizeid;			
	var $price;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $categorysizesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->categoryid))
			$obj->categoryid='NULL';
		$this->categoryid=$obj->categoryid;
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		$this->price=str_replace("'","\'",$obj->price);
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

	//get categoryid
	function getCategoryid(){
		return $this->categoryid;
	}
	//set categoryid
	function setCategoryid($categoryid){
		$this->categoryid=$categoryid;
	}

	//get sizeid
	function getSizeid(){
		return $this->sizeid;
	}
	//set sizeid
	function setSizeid($sizeid){
		$this->sizeid=$sizeid;
	}

	//get price
	function getPrice(){
		return $this->price;
	}
	//set price
	function setPrice($price){
		$this->price=$price;
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
		$categorysizesDBO = new CategorysizesDBO();
		if($categorysizesDBO->persist($obj)){
			$this->id=$categorysizesDBO->id;
			$this->sql=$categorysizesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$categorysizesDBO = new CategorysizesDBO();
		if($categorysizesDBO->update($obj,$where)){
			$this->sql=$categorysizesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$categorysizesDBO = new CategorysizesDBO();
		if($categorysizesDBO->delete($obj,$where=""))		
			$this->sql=$categorysizesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$categorysizesDBO = new CategorysizesDBO();
		$this->table=$categorysizesDBO->table;
		$categorysizesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$categorysizesDBO->sql;
		$this->result=$categorysizesDBO->result;
		$this->fetchObject=$categorysizesDBO->fetchObject;
		$this->affectedRows=$categorysizesDBO->affectedRows;
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
	
			return null;
	
	}
}				
?>
