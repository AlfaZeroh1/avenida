<?php 
require_once("IpaddressDBO.php");
class Ipaddress
{				
	var $id;			
	var $task;			
	var $ipaddress;			
	var $remarks;			
	var $ipaddressDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->task=str_replace("'","\'",$obj->task);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get task
	function getTask(){
		return $this->task;
	}
	//set task
	function setTask($task){
		$this->task=$task;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	function add($obj){
		$ipaddressDBO = new IpaddressDBO();
		if($ipaddressDBO->persist($obj)){
			$this->id=$ipaddressDBO->id;
			$this->sql=$ipaddressDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$ipaddressDBO = new IpaddressDBO();
		if($ipaddressDBO->update($obj,$where)){
			$this->sql=$ipaddressDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$ipaddressDBO = new IpaddressDBO();
		if($ipaddressDBO->delete($obj,$where=""))		
			$this->sql=$ipaddressDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$ipaddressDBO = new IpaddressDBO();
		$this->table=$ipaddressDBO->table;
		$ipaddressDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$ipaddressDBO->sql;
		$this->result=$ipaddressDBO->result;
		$this->fetchObject=$ipaddressDBO->fetchObject;
		$this->affectedRows=$ipaddressDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
