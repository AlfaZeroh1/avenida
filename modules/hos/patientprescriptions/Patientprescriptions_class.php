<?php 
require_once("PatientprescriptionsDBO.php");
class Patientprescriptions
{				
	var $id;			
	var $itemid;			
	var $patienttreatmentid;			
	var $quantity;			
	var $price;			
	var $frequency;	
	var $remarks;
	var $totals;	//and this	
	var $duration;			
	var $issued;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $patientprescriptionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->itemid=str_replace("'","\'",$obj->itemid);
		$this->patienttreatmentid=str_replace("'","\'",$obj->patienttreatmentid);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->price=str_replace("'","\'",$obj->price);
		$this->frequency=str_replace("'","\'",$obj->frequency);
		$this->totals=str_replace("'","\'",$obj->totals);//added this
		$this->duration=str_replace("'","\'",$obj->duration);
		$this->issued=str_replace("'","\'",$obj->issued);
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

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get patienttreatmentid
	function getPatienttreatmentid(){
		return $this->patienttreatmentid;
	}
	//set patienttreatmentid
	function setPatienttreatmentid($patienttreatmentid){
		$this->patienttreatmentid=$patienttreatmentid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get price
	function getPrice(){
		return $this->price;
	}
	//set price
	function setPrice($price){
		$this->price=$price;
	}

	//get frequency
	function getFrequency(){
		return $this->frequency;
	}
	//set frequency
	function setFrequency($frequency){
		$this->frequency=$frequency;
	}
	//get frequency
	function getTotals(){
		return $this->totals;
	}
	//set frequency
	function setTotals($totals){
		$this->totals=$totals;
	}

	//get duration
	function getDuration(){
		return $this->duration;
	}
	//set duration
	function setDuration($duration){
		$this->duration=$duration;
	}

	//get issued
	function getIssued(){
		return $this->issued;
	}
	//set issued
	function setIssued($issued){
		$this->issued=$issued;
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
		$patientprescriptionsDBO = new PatientprescriptionsDBO();
		if($patientprescriptionsDBO->persist($obj)){		
			$this->id=$patientprescriptionsDBO->id;
			$this->sql=$patientprescriptionsDBO->sql;
			return true;
		}		
	}			
	function edit($obj){
	$patientprescriptionsDBO = new PatientprescriptionsDBO();
		if($patientprescriptionsDBO->update($obj)){		
			$this->id=$patientprescriptionsDBO->id;
			$this->sql=$patientprescriptionsDBO->sql;
			return true;
		}		
	}			
	function delete($obj,$where=""){			
		$patientprescriptionsDBO = new PatientprescriptionsDBO();
		if($patientprescriptionsDBO->delete($obj,$where=""))		
			$this->sql=$patientprescriptionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientprescriptionsDBO = new PatientprescriptionsDBO();
		$this->table=$patientprescriptionsDBO->table;
		$patientprescriptionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patientprescriptionsDBO->sql;
		$this->result=$patientprescriptionsDBO->result;
		$this->fetchObject=$patientprescriptionsDBO->fetchObject;
		$this->affectedRows=$patientprescriptionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Item Name should be provided";
		}
		else if(empty($obj->patienttreatmentid)){
			$error="Treatment should be provided";
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
