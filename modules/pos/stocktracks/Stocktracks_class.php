<?php 
require_once("StocktracksDBO.php");
class Stocktracks
{				
	var $id;			
	var $itemid;			
	var $tid;			
	var $documentno;			
	var $batchno;			
	var $quantity;			
	var $costprice;			
	var $value;			
	var $discount;			
	var $tradeprice;			
	var $retailprice;			
	var $tax;			
	var $expirydate;			
	var $recorddate;			
	var $status;			
	var $remain;			
	var $transaction;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $stocktracksDBO;
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
		$this->tid=str_replace("'","\'",$obj->tid);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->batchno=str_replace("'","\'",$obj->batchno);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->value=str_replace("'","\'",$obj->value);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->tradeprice=str_replace("'","\'",$obj->tradeprice);
		$this->retailprice=str_replace("'","\'",$obj->retailprice);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->expirydate=str_replace("'","\'",$obj->expirydate);
		$this->recorddate=str_replace("'","\'",$obj->recorddate);
		$this->status=str_replace("'","\'",$obj->status);
		$this->remain=str_replace("'","\'",$obj->remain);
		$this->transaction=str_replace("'","\'",$obj->transaction);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
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

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
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
		$stocktracksDBO = new StocktracksDBO();
		if($stocktracksDBO->persist($obj)){
			$this->id=$stocktracksDBO->id;
			$this->sql=$stocktracksDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$stocktracksDBO = new StocktracksDBO();
		if($stocktracksDBO->update($obj,$where)){
			$this->sql=$stocktracksDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$stocktracksDBO = new StocktracksDBO();
		if($stocktracksDBO->delete($obj,$where=""))		
			$this->sql=$stocktracksDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$stocktracksDBO = new StocktracksDBO();
		$this->table=$stocktracksDBO->table;
		$stocktracksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$stocktracksDBO->sql;
		$this->result=$stocktracksDBO->result;
		$this->fetchObject=$stocktracksDBO->fetchObject;
		$this->affectedRows=$stocktracksDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Item should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
		}
		else if(empty($obj->remain)){
			$error="Remain should be provided";
		}
		else if(empty($obj->createdby)){
			$error=" should be provided";
		}
		else if(empty($obj->createdon)){
			$error=" should be provided";
		}
		else if(empty($obj->lasteditedby)){
			$error=" should be provided";
		}
		else if(empty($obj->lasteditedon)){
			$error=" should be provided";
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
