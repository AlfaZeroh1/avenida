<?php 
require_once("RentaltypesDBO.php");
class Rentaltypes
{				
	var $id;			
	var $name;			
	var $months;			
	var $remarks;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $rentaltypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->months=str_replace("'","\'",$obj->months);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get months
	function getMonths(){
		return $this->months;
	}
	//set months
	function setMonths($months){
		$this->months=$months;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$rentaltypesDBO = new RentaltypesDBO();
		if($rentaltypesDBO->persist($obj)){
			$this->id=$rentaltypesDBO->id;
			$this->sql=$rentaltypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$rentaltypesDBO = new RentaltypesDBO();
		if($rentaltypesDBO->update($obj,$where)){
			$this->sql=$rentaltypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$rentaltypesDBO = new RentaltypesDBO();
		if($rentaltypesDBO->delete($obj,$where=""))		
			$this->sql=$rentaltypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$rentaltypesDBO = new RentaltypesDBO();
		$this->table=$rentaltypesDBO->table;
		$rentaltypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$rentaltypesDBO->sql;
		$this->result=$rentaltypesDBO->result;
		$this->fetchObject=$rentaltypesDBO->fetchObject;
		$this->affectedRows=$rentaltypesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->months)){
			$error="Payable after (Months) should be provided";
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
