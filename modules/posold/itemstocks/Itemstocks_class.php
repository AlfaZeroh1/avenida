<?php 
require_once("ItemstocksDBO.php");
class Itemstocks
{				
	var $id;			
	var $documentno;	
	var $datecode;
	var $itemid;
	var $sizeid;
	var $customerid;			
	var $transaction;			
	var $quantity;			
	var $remain;			
	var $recordedon;			
	var $actedon;	
	var $remarks;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $itemstocksDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->datecode=str_replace("'","\'",$obj->datecode);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		$this->transaction=str_replace("'","\'",$obj->transaction);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->remain=str_replace("'","\'",$obj->remain);
		$this->recordedon=str_replace("'","\'",$obj->recordedon);
		$this->actedon=str_replace("'","\'",$obj->actedon);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get transaction
	function getTransaction(){
		return $this->transaction;
	}
	//set transaction
	function setTransaction($transaction){
		$this->transaction=$transaction;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get remain
	function getRemain(){
		return $this->remain;
	}
	//set remain
	function setRemain($remain){
		$this->remain=$remain;
	}

	//get recordedon
	function getRecordedon(){
		return $this->recordedon;
	}
	//set recordedon
	function setRecordedon($recordedon){
		$this->recordedon=$recordedon;
	}

	//get actedon
	function getActedon(){
		return $this->actedon;
	}
	//set actedon
	function setActedon($actedon){
		$this->actedon=$actedon;
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
		$itemstocksDBO = new ItemstocksDBO();
		if($itemstocksDBO->persist($obj)){
			$this->id=$itemstocksDBO->id;
			$this->sql=$itemstocksDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$itemstocksDBO = new ItemstocksDBO();
		if($itemstocksDBO->update($obj,$where)){
			$this->sql=$itemstocksDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$itemstocksDBO = new ItemstocksDBO();
		if($itemstocksDBO->delete($obj,$where=""))		
			$this->sql=$itemstocksDBO->sql;
			return true;	
	}
	
	function addStock($obj){
	
	  $items = new Items();
	  $fields="*";
	  $join="";
	  $where=" where id='$obj->itemid'";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $items = $items->fetchObject;
	  
	  $items->stock = $items->stock+$obj->quantity;
	  $obj->remain=$items->stock;
	  
	  $var = new Items();
	  $var = $var->setObject($items);
	  $var->edit($var);
	  
	  $itemstocks = new Itemstocks();
	  $obj->transaction="In";
	  $obj->recordedon=date("Y-m-d");
	  $obj->actedon=date("Y-m-d");
	  $obj->remarks=$obj->status;
	  $itemstocks = $itemstocks->setObject($obj);
	  $itemstocks->add($itemstocks);
	  
	}
	
	function reduceStock($obj){
	
	  $items = new Items();
	  $fields="*";
	  $join="";
	  $where=" where id='$obj->itemid'";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $items = $items->fetchObject;
	  
	  $obj->quantity*=-1;
	  
	  $items->stock = $items->stock+$obj->quantity;
	  $obj->remain=$items->stock;
	  
	  $var = new Items();
	  $var = $var->setObject($items);
	  $var->edit($var);
	  
	  $itemstocks = new Itemstocks();
	  $obj->transaction="Out";
	  $obj->recordedon=date("Y-m-d");
	  $obj->actedon=date("Y-m-d");
	  $obj->remarks=$obj->status;
	  $itemstocks = $itemstocks->setObject($obj);
	  $itemstocks->add($itemstocks);
	  
	}
	
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$itemstocksDBO = new ItemstocksDBO();
		$this->table=$itemstocksDBO->table;
		$itemstocksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$itemstocksDBO->sql;
		$this->result=$itemstocksDBO->result;
		$this->fetchObject=$itemstocksDBO->fetchObject;
		$this->affectedRows=$itemstocksDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Product should be provided";
		}
		else if(empty($obj->transaction)){
			$error="Action should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
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
