<?php 
require_once("HolidaysDBO.php");
class Holidays
{				
	var $id;			
	var $name;			
	var $date;			
	var $recurse;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $holidaysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->date=str_replace("'","\'",$obj->date);
		$this->recurse=str_replace("'","\'",$obj->recurse);
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

	//get date
	function getDate(){
		return $this->date;
	}
	//set date
	function setDate($date){
		$this->date=$date;
	}

	//get recurse
	function getRecurse(){
		return $this->recurse;
	}
	//set recurse
	function setRecurse($recurse){
		$this->recurse=$recurse;
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
		$holidaysDBO = new HolidaysDBO();
		if($holidaysDBO->persist($obj)){
			$this->id=$holidaysDBO->id;
			$this->sql=$holidaysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$holidaysDBO = new HolidaysDBO();
		if($holidaysDBO->update($obj,$where)){
			$this->sql=$holidaysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$holidaysDBO = new HolidaysDBO();
		if($holidaysDBO->delete($obj,$where=""))		
			$this->sql=$holidaysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$holidaysDBO = new HolidaysDBO();
		$this->table=$holidaysDBO->table;
		$holidaysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$holidaysDBO->sql;
		$this->result=$holidaysDBO->result;
		$this->fetchObject=$holidaysDBO->fetchObject;
		$this->affectedRows=$holidaysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
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
