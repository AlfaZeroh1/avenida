<?php 
require_once("ForecastingsDBO.php");
class Forecastings
{				
	var $id;			
	var $varietyid;			
	var $week;			
	var $year;			
	var $quantity;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $forecastingsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->varietyid))
			$obj->varietyid='NULL';
		$this->varietyid=$obj->varietyid;
		$this->week=str_replace("'","\'",$obj->week);
		$this->year=str_replace("'","\'",$obj->year);
		$this->quantity=str_replace("'","\'",$obj->quantity);
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

	//get varietyid
	function getVarietyid(){
		return $this->varietyid;
	}
	//set varietyid
	function setVarietyid($varietyid){
		$this->varietyid=$varietyid;
	}

	//get forecastdate
	function getForecastdate(){
		return $this->forecastdate;
	}
	//get week
	function getWeek(){
		return $this->week;
	}
	//set week
	function setWeek($week){
		$this->week=$week;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
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
		$forecastingsDBO = new ForecastingsDBO();
		if($forecastingsDBO->persist($obj)){
			$this->id=$forecastingsDBO->id;
			$this->sql=$forecastingsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$forecastingsDBO = new ForecastingsDBO();
		if($forecastingsDBO->update($obj,$where)){
			$this->sql=$forecastingsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$forecastingsDBO = new ForecastingsDBO();
		if($forecastingsDBO->delete($obj,$where=""))		
			$this->sql=$forecastingsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$forecastingsDBO = new ForecastingsDBO();
		$this->table=$forecastingsDBO->table;
		$forecastingsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$forecastingsDBO->sql;
		$this->result=$forecastingsDBO->result;
		$this->fetchObject=$forecastingsDBO->fetchObject;
		$this->affectedRows=$forecastingsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->varietyid)){
			$error="Product should be provided";
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
