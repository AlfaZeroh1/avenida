<?php 
require_once("BqitemsDBO.php");
class Bqitems
{				
	var $id;			
	var $name;			
	var $unitofmeasureid;			
	var $bqrate;			
	var $actualrate;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $bqitemsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->unitofmeasureid))
			$obj->unitofmeasureid='NULL';
		$this->unitofmeasureid=$obj->unitofmeasureid;
		$this->bqrate=str_replace("'","\'",$obj->bqrate);
		$this->actualrate=str_replace("'","\'",$obj->actualrate);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get unitofmeasureid
	function getUnitofmeasureid(){
		return $this->unitofmeasureid;
	}
	//set unitofmeasureid
	function setUnitofmeasureid($unitofmeasureid){
		$this->unitofmeasureid=$unitofmeasureid;
	}

	//get bqrate
	function getBqrate(){
		return $this->bqrate;
	}
	//set bqrate
	function setBqrate($bqrate){
		$this->bqrate=$bqrate;
	}

	//get actualrate
	function getActualrate(){
		return $this->actualrate;
	}
	//set actualrate
	function setActualrate($actualrate){
		$this->actualrate=$actualrate;
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
		$bqitemsDBO = new BqitemsDBO();
		if($bqitemsDBO->persist($obj)){
			$this->id=$bqitemsDBO->id;
			$this->sql=$bqitemsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$bqitemsDBO = new BqitemsDBO();
		if($bqitemsDBO->update($obj,$where)){
			$this->sql=$bqitemsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$bqitemsDBO = new BqitemsDBO();
		if($bqitemsDBO->delete($obj,$where=""))		
			$this->sql=$bqitemsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$bqitemsDBO = new BqitemsDBO();
		$this->table=$bqitemsDBO->table;
		$bqitemsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$bqitemsDBO->sql;
		$this->result=$bqitemsDBO->result;
		$this->fetchObject=$bqitemsDBO->fetchObject;
		$this->affectedRows=$bqitemsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="BQ Item should be provided";
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
