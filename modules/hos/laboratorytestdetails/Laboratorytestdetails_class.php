<?php 
require_once("LaboratorytestdetailsDBO.php");
class Laboratorytestdetails
{				
	var $id;			
	var $laboratorytestid;			
	var $detail;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $laboratorytestdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->laboratorytestid))
			$obj->laboratorytestid='NULL';
		$this->laboratorytestid=$obj->laboratorytestid;
		$this->detail=str_replace("'","\'",$obj->detail);
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

	//get laboratorytestid
	function getLaboratorytestid(){
		return $this->laboratorytestid;
	}
	//set laboratorytestid
	function setLaboratorytestid($laboratorytestid){
		$this->laboratorytestid=$laboratorytestid;
	}

	//get detail
	function getDetail(){
		return $this->detail;
	}
	//set detail
	function setDetail($detail){
		$this->detail=$detail;
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
		$laboratorytestdetailsDBO = new LaboratorytestdetailsDBO();
		if($laboratorytestdetailsDBO->persist($obj)){
			$this->id=$laboratorytestdetailsDBO->id;
			$this->sql=$laboratorytestdetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$laboratorytestdetailsDBO = new LaboratorytestdetailsDBO();
		if($laboratorytestdetailsDBO->update($obj,$where)){
			$this->sql=$laboratorytestdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$laboratorytestdetailsDBO = new LaboratorytestdetailsDBO();
		if($laboratorytestdetailsDBO->delete($obj,$where=""))		
			$this->sql=$laboratorytestdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$laboratorytestdetailsDBO = new LaboratorytestdetailsDBO();
		$this->table=$laboratorytestdetailsDBO->table;
		$laboratorytestdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$laboratorytestdetailsDBO->sql;
		$this->result=$laboratorytestdetailsDBO->result;
		$this->fetchObject=$laboratorytestdetailsDBO->fetchObject;
		$this->affectedRows=$laboratorytestdetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->laboratorytestid)){
			$error="Laboratory Tests should be provided";
		}
		else if(empty($obj->detail)){
			$error="Test Detail should be provided";
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
