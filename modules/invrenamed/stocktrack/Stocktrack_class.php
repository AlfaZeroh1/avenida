<?php 
require_once("StocktrackDBO.php");
class Stocktrack
{				
	var $id;			
	var $itemid;			
	var $tid;	
	var $brancheid;
	var $documentno;			
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
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $stocktrackDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->itemid=str_replace("'","\'",$obj->itemid);
		$this->tid=str_replace("'","\'",$obj->tid);
		
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
		
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->batchno=str_replace("'","\'",$obj->batchno);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->value=str_replace("'","\'",$obj->value);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->tradeprice=str_replace("'","\'",$obj->tradeprice);
		$this->retailprice=str_replace("'","\'",$obj->retailprice);
		$this->applicabletax=str_replace("'","\'",$obj->applicabletax);
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
		$stocktrackDBO = new StocktrackDBO();
		if($stocktrackDBO->persist($obj)){
			$this->id=$stocktrackDBO->id;
			$this->sql=$stocktrackDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$stocktrackDBO = new StocktrackDBO();
		if($stocktrackDBO->update($obj,$where)){
			$this->sql=$stocktrackDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$stocktrackDBO = new StocktrackDBO();
		if($stocktrackDBO->delete($obj,$where=""))		
			$this->sql=$stocktrackDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$stocktrackDBO = new StocktrackDBO();
		$this->table=$stocktrackDBO->table;
		$stocktrackDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$stocktrackDBO->sql;
		$this->result=$stocktrackDBO->result;
		$this->fetchObject=$stocktrackDBO->fetchObject;
		$this->affectedRows=$stocktrackDBO->affectedRows;
	}
	
	function addStock($obj,$bool=false){
	  //first add record to project stocks
	  //check if itemid exists
	  
	  $items = new Items();
	  $fields="*";
	  $join="";
	  $where=" where id='$obj->itemid'";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $items = $items->fetchObject;
	  if(!$bool){   
	      $items->quantity+=$obj->quantity;
	  }else{
	      $items->quantity=$obj->quantity;
	  }
	  $ps = new Items();
	  $ps = $ps->setObject($items);
	  $ps->edit($ps);	  
	  
	  $obj->remain=$items->quantity;
	  $obj->createdby=$_SESSION['userid'];
	  $obj->createdon=date("Y-m-d H:i:s");
	  $obj->lasteditedby=$_SESSION['userid'];
	  $obj->lasteditedon=date("Y-m-d H:i:s");
	  $obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	  
	  //add to stocktrack
	  $stocktrack = new Stocktrack();
	  $stocktrack = $stocktrack->setObject($obj);
	  $stocktrack->add($stocktrack);
	}
	
	function reduceStock($obj){
	  //first add record to project stocks
	  //check if itemid exists
	  $items = new Items();
	  $fields="*";
	  $join="";
	  $where=" where id='$obj->itemid'";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $items = $items->fetchObject;
	  
	  $obj->quantity*=-1;
	  

	  $items->quantity+=$obj->quantity;
	  
	  $ps = new Items();
	  $ps = $ps->setObject($items);
	  $ps->edit($ps);  
	  
	  $obj->remain=$items->quantity;
	  $obj->createdby=$_SESSION['userid'];
	  $obj->createdon=date("Y-m-d H:i:s");
	  $obj->lasteditedby=$_SESSION['userid'];
	  $obj->lasteditedon=date("Y-m-d H:i:s");
	  $obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	  
	  //add to stocktrack
	  //add to stocktrack
	  $stocktrack = new Stocktrack();
	  $stocktrack = $stocktrack->setObject($obj);
	  $stocktrack->add($stocktrack);
	}
	
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Item should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
		}
		else if(empty($obj->expirydate)){
			$error="Name should be provided";
		}
		else if(empty($obj->remain)){
			$error="Remain should be provided";
		}
		else if(empty($obj->createdby)){
			$error="CreatedBy should be provided";
		}
		else if(empty($obj->createdon)){
			$error="CreatedOn should be provided";
		}
		else if(empty($obj->lasteditedby)){
			$error="LastEditedBy should be provided";
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
