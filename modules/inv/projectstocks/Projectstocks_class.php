<?php 
require_once("ProjectstocksDBO.php");
class Projectstocks
{				
	var $id;			
	var $projectid;			
	var $itemid;			
	var $quantity;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectstocksDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
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

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
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
		$projectstocksDBO = new ProjectstocksDBO();
		if($projectstocksDBO->persist($obj)){
			$this->id=$projectstocksDBO->id;
			$this->sql=$projectstocksDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectstocksDBO = new ProjectstocksDBO();
		if($projectstocksDBO->update($obj,$where)){
			$this->sql=$projectstocksDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectstocksDBO = new ProjectstocksDBO();
		if($projectstocksDBO->delete($obj,$where=""))		
			$this->sql=$projectstocksDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectstocksDBO = new ProjectstocksDBO();
		$this->table=$projectstocksDBO->table;
		$projectstocksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectstocksDBO->sql;
		$this->result=$projectstocksDBO->result;
		$this->fetchObject=$projectstocksDBO->fetchObject;
		$this->affectedRows=$projectstocksDBO->affectedRows;
	}
	
	function addStock($obj){
	  //first add record to project stocks
	  //check if itemid exists
	  $projectstocks = new Projectstocks();
	  $fields="*";
	  $join="";
	  $where=" where itemid='$obj->itemid' and projectid='$obj->projectid' ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where con_projects.id='$projectid' ";
	  $projectstocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  if($projectstocks->affectedRows>0){
	    $ps = new Projectstocks();
	    $ps = $ps->setObject($obj);
	    $ps->edit($ps);
	  }
	  else{
	    $ps = new Projectstocks();
	    $ps = $ps->setObject($obj);
	    $ps->add($ps);
	  }
	  
	  $projectstocks = new Projectstocks();
	  $fields="*";
	  $join="";
	  $where=" where itemid='$obj->itemid' and projectid='$obj->projectid' ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where con_projects.id='$projectid' ";
	  $projectstocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $projectstocks = $projectstocks->fetchObject;
	  $obj->remain=$projectstocks->remain;
	  
	  //add to stocktrack
	  $stocktrack = new Stocktrack();
	  $stocktrack = $stocktrack->setObject($stocktrack);
	  $stocktrack->add($stocktrack);
	}
	
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
