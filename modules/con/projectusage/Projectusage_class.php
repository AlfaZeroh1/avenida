<?php 
require_once("ProjectusageDBO.php");
class Projectusage
{				
	var $id;			
	var $projectid;			
	var $itemid;			
	var $quantity;			
	var $usedon;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectusageDBO;
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
		$this->usedon=str_replace("'","\'",$obj->usedon);
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

	//get usedon
	function getUsedon(){
		return $this->usedon;
	}
	//set usedon
	function setUsedon($usedon){
		$this->usedon=$usedon;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$projectusageDBO = new ProjectusageDBO();
		if($projectusageDBO->persist($obj)){
			$this->id=$projectusageDBO->id;
			$this->sql=$projectusageDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectusageDBO = new ProjectusageDBO();
		if($projectusageDBO->update($obj,$where)){
			$this->sql=$projectusageDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectusageDBO = new ProjectusageDBO();
		if($projectusageDBO->delete($obj,$where=""))		
			$this->sql=$projectusageDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectusageDBO = new ProjectusageDBO();
		$this->table=$projectusageDBO->table;
		$projectusageDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectusageDBO->sql;
		$this->result=$projectusageDBO->result;
		$this->fetchObject=$projectusageDBO->fetchObject;
		$this->affectedRows=$projectusageDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->projectid)){
			$error="Project should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Item should be provided";
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
