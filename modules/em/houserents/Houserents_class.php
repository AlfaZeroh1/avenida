<?php 
require_once("HouserentsDBO.php");
class Houserents
{				
	var $id;			
	var $houseid;			
	var $previous;			
	var $enddate;			
	var $current;		
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;
	var $houserentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->houseid=str_replace("'","\'",$obj->houseid);
		$this->previous=str_replace("'","\'",$obj->previous);
		$this->enddate=str_replace("'","\'",$obj->enddate);
		$this->current=str_replace("'","\'",$obj->current);
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

	//get houseid
	function getHouseid(){
		return $this->houseid;
	}
	//set houseid
	function setHouseid($houseid){
		$this->houseid=$houseid;
	}

	//get previous
	function getPrevious(){
		return $this->previous;
	}
	//set previous
	function setPrevious($previous){
		$this->previous=$previous;
	}

	//get enddate
	function getEnddate(){
		return $this->enddate;
	}
	//set enddate
	function setEnddate($enddate){
		$this->enddate=$enddate;
	}

	//get current
	function getCurrent(){
		return $this->current;
	}
	//set current
	function setCurrent($current){
		$this->current=$current;
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
		$houserentsDBO = new HouserentsDBO();
		if($houserentsDBO->persist($obj)){
			$this->id=$houserentsDBO->id;
			$this->sql=$houserentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$houserentsDBO = new HouserentsDBO();
		if($houserentsDBO->update($obj,$where)){
			$this->sql=$houserentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$houserentsDBO = new HouserentsDBO();
		if($houserentsDBO->delete($obj,$where=""))		
			$this->sql=$houserentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$houserentsDBO = new HouserentsDBO();
		$this->table=$houserentsDBO->table;
		$houserentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$houserentsDBO->sql;
		$this->result=$houserentsDBO->result;
		$this->fetchObject=$houserentsDBO->fetchObject;
		$this->affectedRows=$houserentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->houseid)){
			$error="House should be provided";
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
