<?php 
require_once("ProductionbudgetsDBO.php");
class Productionbudgets
{				
	var $id;			
	var $greenhousevarietyid;			
	var $month;			
	var $year;			
	var $budgetedon;			
	var $quantity;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $productionbudgetsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->greenhousevarietyid))
			$obj->greenhousevarietyid='NULL';
		$this->greenhousevarietyid=$obj->greenhousevarietyid;
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->budgetedon=str_replace("'","\'",$obj->budgetedon);
		$this->quantity=str_replace("'","\'",$obj->quantity);
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

	//get greenhousevarietyid
	function getGreenhousevarietyid(){
		return $this->greenhousevarietyid;
	}
	//set greenhousevarietyid
	function setGreenhousevarietyid($greenhousevarietyid){
		$this->greenhousevarietyid=$greenhousevarietyid;
	}

	//get month
	function getMonth(){
		return $this->month;
	}
	//set month
	function setMonth($month){
		$this->month=$month;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get budgetedon
	function getBudgetedon(){
		return $this->budgetedon;
	}
	//set budgetedon
	function setBudgetedon($budgetedon){
		$this->budgetedon=$budgetedon;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
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
		$productionbudgetsDBO = new ProductionbudgetsDBO();
		if($productionbudgetsDBO->persist($obj)){
			$this->id=$productionbudgetsDBO->id;
			$this->sql=$productionbudgetsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$productionbudgetsDBO = new ProductionbudgetsDBO();
		if($productionbudgetsDBO->update($obj,$where)){
			$this->sql=$productionbudgetsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$productionbudgetsDBO = new ProductionbudgetsDBO();
		if($productionbudgetsDBO->delete($obj,$where=""))		
			$this->sql=$productionbudgetsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$productionbudgetsDBO = new ProductionbudgetsDBO();
		$this->table=$productionbudgetsDBO->table;
		$productionbudgetsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$productionbudgetsDBO->sql;
		$this->result=$productionbudgetsDBO->result;
		$this->fetchObject=$productionbudgetsDBO->fetchObject;
		$this->affectedRows=$productionbudgetsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
