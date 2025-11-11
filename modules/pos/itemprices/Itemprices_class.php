<?php 
require_once("ItempricesDBO.php");
class Itemprices
{				
	var $id;			
	var $priceid;			
	var $itemid;			
	var $amount;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $itempricesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->priceid))
			$obj->priceid='NULL';
		$this->priceid=$obj->priceid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get priceid
	function getPriceid(){
		return $this->priceid;
	}
	//set priceid
	function setPriceid($priceid){
		$this->priceid=$priceid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
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
		$itempricesDBO = new ItempricesDBO();
		if($itempricesDBO->persist($obj)){
			$this->id=$itempricesDBO->id;
			$this->sql=$itempricesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$itempricesDBO = new ItempricesDBO();
		if($itempricesDBO->update($obj,$where)){
			$this->sql=$itempricesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$itempricesDBO = new ItempricesDBO();
		if($itempricesDBO->delete($obj,$where=""))		
			$this->sql=$itempricesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$itempricesDBO = new ItempricesDBO();
		$this->table=$itempricesDBO->table;
		$itempricesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$itempricesDBO->sql;
		$this->result=$itempricesDBO->result;
		$this->fetchObject=$itempricesDBO->fetchObject;
		$this->affectedRows=$itempricesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->priceid)){
			$error="Price Name should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Item should be provided";
		}
		else if(empty($obj->amount)){
			$error="Amount should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->amount)){
			$error="Amount should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
