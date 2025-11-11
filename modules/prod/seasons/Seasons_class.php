<?php 
require_once("SeasonsDBO.php");
class Seasons
{				
	var $id;			
	var $name;			
	var $startweek;			
	var $endweek;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $seasonsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->startweek=str_replace("'","\'",$obj->startweek);
		$this->endweek=str_replace("'","\'",$obj->endweek);
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

	//get startweek
	function getStartweek(){
		return $this->startweek;
	}
	//set startweek
	function setStartweek($startweek){
		$this->startweek=$startweek;
	}

	//get endweek
	function getEndweek(){
		return $this->endweek;
	}
	//set endweek
	function setEndweek($endweek){
		$this->endweek=$endweek;
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
		$seasonsDBO = new SeasonsDBO();
		if($seasonsDBO->persist($obj)){
			$this->id=$seasonsDBO->id;
			$this->sql=$seasonsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$seasonsDBO = new SeasonsDBO();
		if($seasonsDBO->update($obj,$where)){
			$this->sql=$seasonsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$seasonsDBO = new SeasonsDBO();
		if($seasonsDBO->delete($obj,$where=""))		
			$this->sql=$seasonsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$seasonsDBO = new SeasonsDBO();
		$this->table=$seasonsDBO->table;
		$seasonsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$seasonsDBO->sql;
		$this->result=$seasonsDBO->result;
		$this->fetchObject=$seasonsDBO->fetchObject;
		$this->affectedRows=$seasonsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Season should be provided";
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
