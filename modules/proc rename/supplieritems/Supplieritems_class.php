<?php 
require_once("SupplieritemsDBO.php");
class Supplieritems
{				
	var $id;			
	var $itemid;			
	var $supplierid;			
	var $price;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $supplieritemsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
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

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
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
		$supplieritemsDBO = new SupplieritemsDBO();
		if($supplieritemsDBO->persist($obj)){
			$this->id=$supplieritemsDBO->id;
			$this->sql=$supplieritemsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$supplieritemsDBO = new SupplieritemsDBO();
		if($supplieritemsDBO->update($obj,$where)){
			$this->sql=$supplieritemsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$supplieritemsDBO = new SupplieritemsDBO();
		if($supplieritemsDBO->delete($obj,$where=""))		
			$this->sql=$supplieritemsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$supplieritemsDBO = new SupplieritemsDBO();
		$this->table=$supplieritemsDBO->table;
		$supplieritemsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$supplieritemsDBO->sql;
		$this->result=$supplieritemsDBO->result;
		$this->fetchObject=$supplieritemsDBO->fetchObject;
		$this->affectedRows=$supplieritemsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Item should be provided";
		}
		else if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
		else if(empty($obj->price)){
			$error="Price should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
