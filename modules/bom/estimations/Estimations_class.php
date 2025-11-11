<?php 
require_once("EstimationsDBO.php");
class Estimations
{				
	var $id;			
	var $name;			
	var $itemid;
	var $prc;	
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $estimationsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->prc=str_replace("'","\'",$obj->prc);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
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
		$estimationsDBO = new EstimationsDBO();
		if($estimationsDBO->persist($obj)){
			$this->id=$estimationsDBO->id;
			$this->sql=$estimationsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$estimationsDBO = new EstimationsDBO();
		if($estimationsDBO->update($obj,$where)){
			$this->sql=$estimationsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$estimationsDBO = new EstimationsDBO();
		if($estimationsDBO->delete($obj,$where=""))		
			$this->sql=$estimationsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$estimationsDBO = new EstimationsDBO();
		$this->table=$estimationsDBO->table;
		$estimationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$estimationsDBO->sql;
		$this->result=$estimationsDBO->result;
		$this->fetchObject=$estimationsDBO->fetchObject;
		$this->affectedRows=$estimationsDBO->affectedRows;
	}			
	function validate($obj){
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
	
	function addStocks($itemid,$quantity,$transaction){
	  //get estimation details
	  $query="select bom_estimationdetails.* from bom_estimationdetails left join bom_estimations on bom_estimationdetails.estimationid=bom_estimations.id where bom_estimations.itemid='$itemid'";
	  $res= mysql_query($res);
	  while($row=mysql_fetch_object($res)){
	    $stocktrack=new Stocktrack();
	    $oj->itemid=$row->itemid;
	    $oj->quantity=$row->quantity;
	    $oj->transaction=$transaction;
	    $stocktrack->addStock($oj);
	  }
	}
	
	function reduceStocks($itemid,$quantity,$transaction){
	  //get estimation details
	  $query="select bom_estimationdetails.* from bom_estimationdetails left join bom_estimations on bom_estimationdetails.estimationid=bom_estimations.id where bom_estimations.itemid='$itemid'";
	  $res= mysql_query($res);
	  while($row=mysql_fetch_object($res)){
	    $stocktrack=new Stocktrack();
	    $oj->itemid=$row->itemid;
	    $oj->quantity=$row->quantity;
	    $oj->transaction=$transaction;
	    $stocktrack->reduceStock($oj);
	  }
	}
}				
?>
