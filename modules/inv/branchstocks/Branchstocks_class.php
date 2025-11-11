<?php 
require_once("BranchstocksDBO.php");
require_once("../../../modules/inv/stocktrack/StocktrackDBO.php");
require_once("../../../modules/inv/stocktrack/Stocktrack_class.php");
class Branchstocks
{				
	var $id;			
	var $brancheid;			
	var $itemid;			
	var $itemdetailid;			
	var $code;			
	var $quantity;			
	var $recorddate;			
	var $documentno;			
	var $transactionid;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $branchstocksDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->itemdetailid))
			$obj->itemdetailid='NULL';
		$this->itemdetailid=$obj->itemdetailid;
		$this->code=str_replace("'","\'",$obj->code);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->recorddate=str_replace("'","\'",$obj->recorddate);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->transactionid))
			$obj->transactionid='NULL';
		$this->transactionid=$obj->transactionid;
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

	//get brancheid
	function getBrancheid(){
		return $this->brancheid;
	}
	//set brancheid
	function setBrancheid($brancheid){
		$this->brancheid=$brancheid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get itemdetailid
	function getItemdetailid(){
		return $this->itemdetailid;
	}
	//set itemdetailid
	function setItemdetailid($itemdetailid){
		$this->itemdetailid=$itemdetailid;
	}

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get recorddate
	function getRecorddate(){
		return $this->recorddate;
	}
	//set recorddate
	function setRecorddate($recorddate){
		$this->recorddate=$recorddate;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get transactionid
	function getTransactionid(){
		return $this->transactionid;
	}
	//set transactionid
	function setTransactionid($transactionid){
		$this->transactionid=$transactionid;
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
		$branchstocksDBO = new BranchstocksDBO();
		if($branchstocksDBO->persist($obj)){
	                  
	                  if(!empty($obj->quantitys))
			    $obj->quantity=$obj->quantitys;
			    
			    
	                  //insert into stock track  
			  $stocktrack=new Stocktrack();
			  
			  $branchstock = mysql_fetch_object(mysql_query("select quantity from inv_branchstocks where itemid='$obj->itemid' and brancheid='$obj->brancheid'"));
			    
			  $obj->available=$branchstock->quantity;
			  $obj->remain=$obj->available;
			  $obj->createdby=$_SESSION['userid'];
			  $obj->createdon=date("Y-m-d H:i:s");
			  $obj->lasteditedby=$_SESSION['userid'];
			  $obj->lasteditedon=date("Y-m-d H:i:s");
			  $obj->ipaddress=$_SERVER['REMOTE_ADDR'];
			  $stocktrack->add($obj);
 
			$this->id=$branchstocksDBO->id;
			$this->sql=$branchstocksDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		
		$branchstocksDBO = new BranchstocksDBO();
		if($branchstocksDBO->update($obj,$where)){
		
			  if(!empty($obj->quantitys))
			    $obj->quantity=$obj->quantitys;
			    
		           //insert into stock track  
			  $stocktrack=new Stocktrack();
			  
			    $branchstock = mysql_fetch_object(mysql_query("select quantity from inv_branchstocks where itemid='$obj->itemid' and brancheid='$obj->brancheid'"));
			  $obj->available=$branchstock->quantity;
			  
			  $obj->remain=$obj->available;
			  $obj->createdby=$_SESSION['userid'];
			  $obj->createdon=date("Y-m-d H:i:s");
			  $obj->lasteditedby=$_SESSION['userid'];
			  $obj->lasteditedon=date("Y-m-d H:i:s");
			  $obj->ipaddress=$_SERVER['REMOTE_ADDR'];
			  $stocktrack->add($obj);
 
			$this->sql=$branchstocksDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$branchstocksDBO = new BranchstocksDBO();
		if($branchstocksDBO->delete($obj,$where=""))		
			$this->sql=$branchstocksDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$branchstocksDBO = new BranchstocksDBO();
		$this->table=$branchstocksDBO->table;
		$branchstocksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$branchstocksDBO->sql;
		$this->result=$branchstocksDBO->result;
		$this->fetchObject=$branchstocksDBO->fetchObject;
		$this->affectedRows=$branchstocksDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->brancheid)){
			$error="Branch should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Product should be provided";
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
		if(empty($obj->brancheid)){
			$error="Branch should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
	
}				
?>
