<?php 
require_once("InspectionsDBO.php");
class Inspections
{				
	var $id;			
	var $assetid;			
	var $inspectionitemid;			
	var $value;			
	var $remarks;			
	var $inspectedon;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $inspectionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->assetid))
			$obj->assetid='NULL';
		$this->assetid=$obj->assetid;
		if(empty($obj->inspectionitemid))
			$obj->inspectionitemid='NULL';
		$this->inspectionitemid=$obj->inspectionitemid;
		$this->value=str_replace("'","\'",$obj->value);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->inspectedon=str_replace("'","\'",$obj->inspectedon);
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

	//get assetid
	function getAssetid(){
		return $this->assetid;
	}
	//set assetid
	function setAssetid($assetid){
		$this->assetid=$assetid;
	}

	//get inspectionitemid
	function getInspectionitemid(){
		return $this->inspectionitemid;
	}
	//set inspectionitemid
	function setInspectionitemid($inspectionitemid){
		$this->inspectionitemid=$inspectionitemid;
	}

	//get value
	function getValue(){
		return $this->value;
	}
	//set value
	function setValue($value){
		$this->value=$value;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get inspectedon
	function getInspectedon(){
		return $this->inspectedon;
	}
	//set inspectedon
	function setInspectedon($inspectedon){
		$this->inspectedon=$inspectedon;
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
		$inspectionsDBO = new InspectionsDBO();
		if($inspectionsDBO->persist($obj)){
			$this->id=$inspectionsDBO->id;
			$this->sql=$inspectionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$inspectionsDBO = new InspectionsDBO();
		if($inspectionsDBO->update($obj,$where)){
			$this->sql=$inspectionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$inspectionsDBO = new InspectionsDBO();
		if($inspectionsDBO->delete($obj,$where=""))		
			$this->sql=$inspectionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$inspectionsDBO = new InspectionsDBO();
		$this->table=$inspectionsDBO->table;
		$inspectionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$inspectionsDBO->sql;
		$this->result=$inspectionsDBO->result;
		$this->fetchObject=$inspectionsDBO->fetchObject;
		$this->affectedRows=$inspectionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->assetid)){
			$error="Asset should be provided";
		}
		else if(empty($obj->inspectionitemid)){
			$error="Inspection Item should be provided";
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
