<?php 
require_once("UprootsDBO.php");
class Uproots
{				
	var $id;			
	var $plantingdetailid;			
	var $areaid;			
	var $varietyid;			
	var $quantity;			
	var $reportedon;
	var $uprootedon;
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $uprootsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->plantingdetailid))
			$obj->plantingdetailid='NULL';
		$this->plantingdetailid=$obj->plantingdetailid;
		if(empty($obj->areaid))
			$obj->areaid='NULL';
		$this->areaid=$obj->areaid;
		if(empty($obj->varietyid))
			$obj->varietyid='NULL';
		$this->varietyid=$obj->varietyid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->reportedon=str_replace("'","\'",$obj->reportedon);
		$this->uprootedon=str_replace("'","\'",$obj->uprootedon);
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

	//get plantingdetailid
	function getPlantingdetailid(){
		return $this->plantingdetailid;
	}
	//set plantingdetailid
	function setPlantingdetailid($plantingdetailid){
		$this->plantingdetailid=$plantingdetailid;
	}

	//get areaid
	function getAreaid(){
		return $this->areaid;
	}
	//set areaid
	function setAreaid($areaid){
		$this->areaid=$areaid;
	}

	//get varietyid
	function getVarietyid(){
		return $this->varietyid;
	}
	//set varietyid
	function setVarietyid($varietyid){
		$this->varietyid=$varietyid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get reportedon
	function getReportedon(){
		return $this->reportedon;
	}
	//set reportedon
	function setReportedon($reportedon){
		$this->reportedon=$reportedon;
	}
	
	//get uprootedon
	function getUprootedon(){
		return $this->uprootedon;
	}
	//set uprootedon
	function setUprootedon($uprootedon){
		$this->uprootedon=$uprootedon;
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
		$uprootsDBO = new UprootsDBO();
		if($uprootsDBO->persist($obj)){
			$this->id=$uprootsDBO->id;
			$this->sql=$uprootsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$uprootsDBO = new UprootsDBO();
		if($uprootsDBO->update($obj,$where)){
			$this->sql=$uprootsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$uprootsDBO = new UprootsDBO();
		if($uprootsDBO->delete($obj,$where=""))		
			$this->sql=$uprootsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$uprootsDBO = new UprootsDBO();
		$this->table=$uprootsDBO->table;
		$uprootsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$uprootsDBO->sql;
		$this->result=$uprootsDBO->result;
		$this->fetchObject=$uprootsDBO->fetchObject;
		$this->affectedRows=$uprootsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->plantingdetailid)){
			$error="Planting Detail should be provided";
		}
		else if(empty($obj->areaid)){
			$error="Area should be provided";
		}
		else if(empty($obj->varietyid)){
			$error="Variety should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
		}
		else if(empty($obj->reportedon)){
			$error="Date Reported should be provided";
		}
		else if(empty($obj->uprootedon)){
			$error="Date Uprooted should be provided";
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
