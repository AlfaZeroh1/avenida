<?php 
require_once("EstimationmanualsDBO.php");
class Estimationmanuals
{				
	var $id;			
	var $type;			
	var $name;			
	var $unitofmeasureid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $estimationmanualsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->type=str_replace("'","\'",$obj->type);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->unitofmeasureid))
			$obj->unitofmeasureid='NULL';
		$this->unitofmeasureid=$obj->unitofmeasureid;
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

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
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
		$estimationmanualsDBO = new EstimationmanualsDBO();
		if($estimationmanualsDBO->persist($obj)){
			$this->id=$estimationmanualsDBO->id;
			$this->sql=$estimationmanualsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$estimationmanualsDBO = new EstimationmanualsDBO();
		if($estimationmanualsDBO->update($obj,$where)){
			$this->sql=$estimationmanualsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$estimationmanualsDBO = new EstimationmanualsDBO();
		if($estimationmanualsDBO->delete($obj,$where=""))		
			$this->sql=$estimationmanualsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$estimationmanualsDBO = new EstimationmanualsDBO();
		$this->table=$estimationmanualsDBO->table;
		$estimationmanualsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$estimationmanualsDBO->sql;
		$this->result=$estimationmanualsDBO->result;
		$this->fetchObject=$estimationmanualsDBO->fetchObject;
		$this->affectedRows=$estimationmanualsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->type)){
			$error="Estimation Manual Type should be provided";
		}
		else if(empty($obj->name)){
			$error="Estimation Desc should be provided";
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
