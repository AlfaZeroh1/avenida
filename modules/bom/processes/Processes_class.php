<?php 
require_once("ProcessesDBO.php");
class Processes
{				
	var $id;			
	var $estimationid;			
	var $processedon;			
	var $quantity;			
	var $actual;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $processesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->estimationid))
			$obj->estimationid='NULL';
		$this->estimationid=$obj->estimationid;
		$this->processedon=str_replace("'","\'",$obj->processedon);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->actual=str_replace("'","\'",$obj->actual);
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

	//get estimationid
	function getEstimationid(){
		return $this->estimationid;
	}
	//set estimationid
	function setEstimationid($estimationid){
		$this->estimationid=$estimationid;
	}

	//get processedon
	function getProcessedon(){
		return $this->processedon;
	}
	//set processedon
	function setProcessedon($processedon){
		$this->processedon=$processedon;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get actual
	function getActual(){
		return $this->actual;
	}
	//set actual
	function setActual($actual){
		$this->actual=$actual;
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
		$processesDBO = new ProcessesDBO();
		if($processesDBO->persist($obj)){
			$this->id=$processesDBO->id;
			$this->sql=$processesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$processesDBO = new ProcessesDBO();
		if($processesDBO->update($obj,$where)){
			
			if($obj->actual>0){
			  //add stock
			  $stocktrack = new Stocktrack();
			  $obj->recorddate=date("Y-m-d");;
			  $obj->transaction="Processed";
			  $stocktrack->addStock($obj);
			}
			
			$this->sql=$processesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$processesDBO = new ProcessesDBO();
		if($processesDBO->delete($obj,$where=""))		
			$this->sql=$processesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$processesDBO = new ProcessesDBO();
		$this->table=$processesDBO->table;
		$processesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$processesDBO->sql;
		$this->result=$processesDBO->result;
		$this->fetchObject=$processesDBO->fetchObject;
		$this->affectedRows=$processesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
