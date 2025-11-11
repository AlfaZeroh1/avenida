<?php 
require_once("StocktakedetailsDBO.php");
class Stocktakedetails
{				
	var $id;			
	var $itemid;
	var $stocktakeid;
	var $brancheid;
	var $takenon;			
	var $quantity;			
	var $costprice;			
	var $total;
	var $stock;
	var $createdby;			
	var $createdon;			
	var $lasteditedon;			
	var $lasteditedby;			
	var $ipaddress;			
	var $stocktakedetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->itemid=str_replace("'","\'",$obj->itemid);
		$this->stocktakeid=str_replace("'","\'",$obj->stocktakeid);
		$this->brancheid=str_replace("'","\'",$obj->brancheid);
		$this->takenon=str_replace("'","\'",$obj->takenon);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->stock=str_replace("'","\'",$obj->stock);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->total=str_replace("'","\'",$obj->total);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
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

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get takenon
	function getTakenon(){
		return $this->takenon;
	}
	//set takenon
	function setTakenon($takenon){
		$this->takenon=$takenon;
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

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
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

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
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
		$stocktakedetailsDBO = new StocktakedetailsDBO();
		if($stocktakedetailsDBO->persist($obj)){
			
			//addstock
// 			$stocktrack = new Stocktrack();
// 			$obj->recorddate=$obj->takenon;
// 			$obj->transaction="Stock Take";
// 			$stocktrack->addStock($obj,true);
			
			$this->id=$stocktakedetailsDBO->id;
			$this->sql=$stocktakedetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$stocktakedetailsDBO = new StocktakedetailsDBO();
		if($stocktakedetailsDBO->update($obj,$where)){
			$this->sql=$stocktakedetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$stocktakedetailsDBO = new StocktakedetailsDBO();
		if($stocktakedetailsDBO->delete($obj,$where=""))		
			$this->sql=$stocktakedetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$stocktakedetailsDBO = new StocktakedetailsDBO();
		$this->table=$stocktakedetailsDBO->table;
		$stocktakedetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$stocktakedetailsDBO->sql;
		$this->result=$stocktakedetailsDBO->result;
		$this->fetchObject=$stocktakedetailsDBO->fetchObject;
		$this->affectedRows=$stocktakedetailsDBO->affectedRows;
	}			
	function validate($obj){
	        if(empty($obj->documentno)){
			$error="Stock Take No Should be Provided!";
		}
		else if(empty($obj->itemid)){
			$error="Item Should be Provided!";
		}
		else if(empty($obj->quantity)){
			$error="Quantity Should be Provided!";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){	
		if(empty($obj->documentno)){
			$error="Stock Take No Should be Provided!";
		}
		else if(empty($obj->itemid)){
			$error="Item Should be Provided!";
		}
		else if(empty($obj->quantity)){
			$error="Quantity Should be Provided!";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
