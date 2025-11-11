<?php 
require_once("StocktakesDBO.php");
class Stocktakes
{				
	var $id;			
	var $documentno;
	var $brancheid;
	var $openedon;			
	var $closedon;			
	var $remarks;			
	var $status;			
	var $createdby;			
	var $createdon;			
	var $lasteditedon;			
	var $lasteditedby;			
	var $ipaddress;			
	var $stocktakesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->openedon=str_replace("'","\'",$obj->openedon);
		
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
		
		$this->closedon=str_replace("'","\'",$obj->closedon);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get documentno
	function getItemid(){
		return $this->documentno;
	}
	//set documentno
	function setItemid($documentno){
		$this->documentno=$documentno;
	}

	//get openedon
	function getTakenon(){
		return $this->openedon;
	}
	//set openedon
	function setTakenon($openedon){
		$this->openedon=$openedon;
	}

	//get closedon
	function getQuantity(){
		return $this->closedon;
	}
	//set closedon
	function setQuantity($closedon){
		$this->closedon=$closedon;
	}

	//get remarks
	function getCostprice(){
		return $this->remarks;
	}
	//set remarks
	function setCostprice($remarks){
		$this->remarks=$remarks;
	}

	//get status
	function getTotal(){
		return $this->status;
	}
	//set status
	function setTotal($status){
		$this->status=$status;
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
		$stocktakesDBO = new StocktakesDBO();
		if($stocktakesDBO->persist($obj)){
			
			//addstock
// 			$stocktrack = new Stocktrack();
// 			$obj->recorddate=$obj->openedon;
// 			$obj->transaction="Stock Take";
// 			$stocktrack->addStock($obj);
			
			$this->id=$stocktakesDBO->id;
			$this->sql=$stocktakesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$stocktakesDBO = new StocktakesDBO();
		if($stocktakesDBO->update($obj,$where)){
			$this->sql=$stocktakesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$stocktakesDBO = new StocktakesDBO();
		if($stocktakesDBO->delete($obj,$where=""))		
			$this->sql=$stocktakesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$stocktakesDBO = new StocktakesDBO();
		$this->table=$stocktakesDBO->table;
		$stocktakesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$stocktakesDBO->sql;
		$this->result=$stocktakesDBO->result;
		$this->fetchObject=$stocktakesDBO->fetchObject;
		$this->affectedRows=$stocktakesDBO->affectedRows;
	}			
	function validate($obj){
			
		$stocktakes=new Stocktakes();
		$where=" where status='Active' ";
		$fields="count(*) cnt";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$stocktakes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$stocktakes=$stocktakes->fetchObject;
		
		if($stocktakes->cnt>0){
			$error="Only one Stock take Should be Active!";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
		if(empty($obj->closedon) or $obj->closedon=="0000-00-00"){
			$error="Closed on should be provided and should not be 0000-00-00";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
