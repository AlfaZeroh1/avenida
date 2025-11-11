<?php 
require_once("VarietystocksDBO.php");
class Varietystocks
{				
	var $id;			
	var $documentno;			
	var $varietyid;	
	var $sizeid;
	var $areaid;			
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
	var $varietystocksDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->varietyid))
			$obj->varietyid='NULL';
		$this->varietyid=$obj->varietyid;
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		if(empty($obj->areaid))
			$obj->areaid='NULL';
		$this->areaid=$obj->areaid;
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

	//get varietyid
	function getVarietyid(){
		return $this->varietyid;
	}
	//set varietyid
	function setVarietyid($varietyid){
		$this->varietyid=$varietyid;
	}

	//get areaid
	function getAreaid(){
		return $this->areaid;
	}
	//set areaid
	function setAreaid($areaid){
		$this->areaid=$areaid;
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
		$varietystocksDBO = new VarietystocksDBO();
		if($varietystocksDBO->persist($obj)){
			$this->id=$varietystocksDBO->id;
			$this->sql=$varietystocksDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$varietystocksDBO = new VarietystocksDBO();
		if($varietystocksDBO->update($obj,$where)){
			$this->sql=$varietystocksDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$varietystocksDBO = new VarietystocksDBO();
		if($varietystocksDBO->delete($obj,$where=""))		
			$this->sql=$varietystocksDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$varietystocksDBO = new VarietystocksDBO();
		$this->table=$varietystocksDBO->table;
		$varietystocksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$varietystocksDBO->sql;
		$this->result=$varietystocksDBO->result;
		$this->fetchObject=$varietystocksDBO->fetchObject;
		$this->affectedRows=$varietystocksDBO->affectedRows;
	}
	
	function addStock($obj){
	
	  $varietys = new Varietys();
	  $fields="*";
	  $join="";
	  $where=" where id='$obj->varietyid'";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $varietys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $varietys = $varietys->fetchObject;
	  
	  $varietys->quantity = $varietys->quantity+$obj->quantity;
	  $obj->remain=$varietys->quantity;
	  
	  $var = new Varietys();
	  $var = $var->setObject($varietys);
	  $var->edit($var);
	  
	  $varietystocks = new Varietystocks();
	  $obj->transaction="In";
	  $obj->remarks=$obj->status;
	  $varietystocks = $varietystocks->setObject($obj);
	  $varietystocks->add($varietystocks);
	  
	}
	
	function reduceStock($obj){
	
	  $varietys = new Varietys();
	  $fields="*";
	  $join="";
	  $where=" where id='$obj->varietyid'";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $varietys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $varietys = $varietys->fetchObject;
	  
	  $obj->quantity*=-1;
	  
	  $varietys->quantity = $varietys->quantity+$obj->quantity;
	  $obj->remain=$varietys->quantity;
	  
	  $var = new Varietys();
	  $var = $var->setObject($varietys);
	  $var->edit($var);
	  
	  $varietystocks = new Varietystocks();
	  $obj->transaction="Out";
	  $obj->remarks=$obj->status;
	  $varietystocks = $varietystocks->setObject($obj);
	  $varietystocks->add($varietystocks);
	  
	}
	
	function validate($obj){
		if(empty($obj->varietyid)){
			$error="Variety should be provided";
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
