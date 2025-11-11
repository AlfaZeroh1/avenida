<?php 
require_once("ItemsDBO.php");
class Items
{				
	var $id;			
	var $code;			
	var $name;			
	var $departmentid;			
	var $categoryid;			
	var $price;			
	var $tax;			
	var $stock;			
	var $itemstatusid;
	var $mixedbox;
	var $remarks;
	var $type;	
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $itemsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->code=str_replace("'","\'",$obj->code);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		$this->mixedbox=str_replace("'","\'",$obj->mixedbox);
		if(empty($obj->categoryid))
			$obj->categoryid='NULL';
		$this->categoryid=$obj->categoryid;
		$this->price=str_replace("'","\'",$obj->price);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->stock=str_replace("'","\'",$obj->stock);
		if(empty($obj->itemstatusid))
			$obj->itemstatusid='NULL';
		$this->itemstatusid=$obj->itemstatusid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->type=str_replace("'","\'",$obj->type);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
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

	//get categoryid
	function getCategoryid(){
		return $this->categoryid;
	}
	//set categoryid
	function setCategoryid($categoryid){
		$this->categoryid=$categoryid;
	}

	//get price
	function getPrice(){
		return $this->price;
	}
	//set price
	function setPrice($price){
		$this->price=$price;
	}

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get stock
	function getStock(){
		return $this->stock;
	}
	//set stock
	function setStock($stock){
		$this->stock=$stock;
	}

	//get itemstatusid
	function getItemstatusid(){
		return $this->itemstatusid;
	}
	//set itemstatusid
	function setItemstatusid($itemstatusid){
		$this->itemstatusid=$itemstatusid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$itemsDBO = new ItemsDBO();
		if($itemsDBO->persist($obj)){
			$this->id=$itemsDBO->id;
			$this->sql=$itemsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$itemsDBO = new ItemsDBO();
		if($itemsDBO->update($obj,$where)){
			$this->sql=$itemsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$itemsDBO = new ItemsDBO();
		if($itemsDBO->delete($obj,$where=""))		
			$this->sql=$itemsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$itemsDBO = new ItemsDBO();
		$this->table=$itemsDBO->table;
		$itemsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$itemsDBO->sql;
		$this->result=$itemsDBO->result;
		$this->fetchObject=$itemsDBO->fetchObject;
		$this->affectedRows=$itemsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
		}
		else if(empty($obj->departmentid)){
			$error="Department should be provided";
		}
		else if(empty($obj->categoryid)){
			$error="Category should be provided";
		}
		else if(empty($obj->itemstatusid)){
			$error="Status should be provided";
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
