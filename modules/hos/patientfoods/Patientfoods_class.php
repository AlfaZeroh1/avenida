<?php 
require_once("PatientfoodsDBO.php");
class Patientfoods
{				
	var $id;			
	var $foodid;			
	var $patientid;			
	var $price;			
	var $servedon;			
	var $mealid;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $patientfoodsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->foodid=str_replace("'","\'",$obj->foodid);
		$this->patientid=str_replace("'","\'",$obj->patientid);
		$this->price=str_replace("'","\'",$obj->price);
		$this->servedon=str_replace("'","\'",$obj->servedon);
		$this->mealid=str_replace("'","\'",$obj->mealid);
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

	//get foodid
	function getFoodid(){
		return $this->foodid;
	}
	//set foodid
	function setFoodid($foodid){
		$this->foodid=$foodid;
	}

	//get patientid
	function getPatientid(){
		return $this->patientid;
	}
	//set patientid
	function setPatientid($patientid){
		$this->patientid=$patientid;
	}

	//get price
	function getPrice(){
		return $this->price;
	}
	//set price
	function setPrice($price){
		$this->price=$price;
	}

	//get servedon
	function getServedon(){
		return $this->servedon;
	}
	//set servedon
	function setServedon($servedon){
		$this->servedon=$servedon;
	}

	//get mealid
	function getMealid(){
		return $this->mealid;
	}
	//set mealid
	function setMealid($mealid){
		$this->mealid=$mealid;
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
		$patientfoodsDBO = new PatientfoodsDBO();
		if($patientfoodsDBO->persist($obj)){
			$this->id=$patientfoodsDBO->id;
			$this->sql=$patientfoodsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$patientfoodsDBO = new PatientfoodsDBO();
		if($patientfoodsDBO->update($obj,$where)){
			$this->sql=$patientfoodsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$patientfoodsDBO = new PatientfoodsDBO();
		if($patientfoodsDBO->delete($obj,$where=""))		
			$this->sql=$patientfoodsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientfoodsDBO = new PatientfoodsDBO();
		$this->table=$patientfoodsDBO->table;
		$patientfoodsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patientfoodsDBO->sql;
		$this->result=$patientfoodsDBO->result;
		$this->fetchObject=$patientfoodsDBO->fetchObject;
		$this->affectedRows=$patientfoodsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
