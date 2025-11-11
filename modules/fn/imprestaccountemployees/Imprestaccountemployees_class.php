<?php 
require_once("ImprestaccountemployeesDBO.php");
class Imprestaccountemployees
{				
	var $id;			
	var $imprestaccountid;			
	var $employeeid;			
	var $addedon;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $imprestaccountemployeesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->imprestaccountid))
			$obj->imprestaccountid='NULL';
		$this->imprestaccountid=$obj->imprestaccountid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->addedon=str_replace("'","\'",$obj->addedon);
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

	//get imprestaccountid
	function getImprestaccountid(){
		return $this->imprestaccountid;
	}
	//set imprestaccountid
	function setImprestaccountid($imprestaccountid){
		$this->imprestaccountid=$imprestaccountid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get addedon
	function getAddedon(){
		return $this->addedon;
	}
	//set addedon
	function setAddedon($addedon){
		$this->addedon=$addedon;
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
		$imprestaccountemployeesDBO = new ImprestaccountemployeesDBO();
		if($imprestaccountemployeesDBO->persist($obj)){
			$this->id=$imprestaccountemployeesDBO->id;
			$this->sql=$imprestaccountemployeesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$imprestaccountemployeesDBO = new ImprestaccountemployeesDBO();
		if($imprestaccountemployeesDBO->update($obj,$where)){
			$this->sql=$imprestaccountemployeesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$imprestaccountemployeesDBO = new ImprestaccountemployeesDBO();
		if($imprestaccountemployeesDBO->delete($obj,$where=""))		
			$this->sql=$imprestaccountemployeesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$imprestaccountemployeesDBO = new ImprestaccountemployeesDBO();
		$this->table=$imprestaccountemployeesDBO->table;
		$imprestaccountemployeesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$imprestaccountemployeesDBO->sql;
		$this->result=$imprestaccountemployeesDBO->result;
		$this->fetchObject=$imprestaccountemployeesDBO->fetchObject;
		$this->affectedRows=$imprestaccountemployeesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->imprestaccountid)){
			$error="Imprest Account should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Owned By should be provided";
		}
		else if(empty($obj->addedon)){
			$error="Added On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->employeeid)){
			$error="Owned By should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
