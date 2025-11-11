<?php 
require_once("StocktrackDBO.php");
class Stocktrack
{				
	var $id;			
	var $itemid;			
	var $tid;			
	var $batchno;			
	var $quantity;			
	var $costprice;			
	var $value;			
	var $discount;			
	var $tradeprice;			
	var $retailprice;			
	var $applicabletax;			
	var $expirydate;			
	var $recorddate;			
	var $status;			
	var $remain;			
	var $transaction;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $stocktrackDBO;
	var $fetchObject;
	var $result;
	var $table;
	var $affectedRows;

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

	//get tid
	function getTid(){
		return $this->tid;
	}
	//set tid
	function setTid($tid){
		$this->tid=$tid;
	}

	//get batchno
	function getBatchno(){
		return $this->batchno;
	}
	//set batchno
	function setBatchno($batchno){
		$this->batchno=$batchno;
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

	//get value
	function getValue(){
		return $this->value;
	}
	//set value
	function setValue($value){
		$this->value=$value;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get tradeprice
	function getTradeprice(){
		return $this->tradeprice;
	}
	//set tradeprice
	function setTradeprice($tradeprice){
		$this->tradeprice=$tradeprice;
	}

	//get retailprice
	function getRetailprice(){
		return $this->retailprice;
	}
	//set retailprice
	function setRetailprice($retailprice){
		$this->retailprice=$retailprice;
	}

	//get applicabletax
	function getApplicabletax(){
		return $this->applicabletax;
	}
	//set applicabletax
	function setApplicabletax($applicabletax){
		$this->applicabletax=$applicabletax;
	}

	//get expirydate
	function getExpirydate(){
		return $this->expirydate;
	}
	//set expirydate
	function setExpirydate($expirydate){
		$this->expirydate=$expirydate;
	}

	//get recorddate
	function getRecorddate(){
		return $this->recorddate;
	}
	//set recorddate
	function setRecorddate($recorddate){
		$this->recorddate=$recorddate;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get remain
	function getRemain(){
		return $this->remain;
	}
	//set remain
	function setRemain($remain){
		$this->remain=$remain;
	}

	//get transaction
	function getTransaction(){
		return $this->transaction;
	}
	//set transaction
	function setTransaction($transaction){
		$this->transaction=$transaction;
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
		$stocktrackDBO = new StocktrackDBO();
		if($stocktrackDBO->persist($obj))		
			return true;	
	}			
	function edit($obj){			
		$stocktrackDBO = new StocktrackDBO();
		if($stocktrackDBO->update($obj))		
			return true;	
	}			
	function delete($obj){			
		$stocktrackDBO = new StocktrackDBO();
		if($stocktrackDBO->delete($obj))		
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$stocktrackDBO = new StocktrackDBO();
		$this->table=$stocktrackDBO->table;
		$stocktrackDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->result=$stocktrackDBO->result;
		$this->fetchObject=$stocktrackDBO->fetchObject;
		$this->affectedRows=$stocktrackDBO->affectedRows;
	}			
}				
?>
