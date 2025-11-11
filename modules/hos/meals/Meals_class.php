<?php 
require_once("MealsDBO.php");
class Meals
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $mealsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
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
		$mealsDBO = new MealsDBO();
		if($mealsDBO->persist($obj)){
			$this->id=$mealsDBO->id;
			$this->sql=$mealsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$mealsDBO = new MealsDBO();
		if($mealsDBO->update($obj,$where)){
			$this->sql=$mealsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$mealsDBO = new MealsDBO();
		if($mealsDBO->delete($obj,$where=""))		
			$this->sql=$mealsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$mealsDBO = new MealsDBO();
		$this->table=$mealsDBO->table;
		$mealsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$mealsDBO->sql;
		$this->result=$mealsDBO->result;
		$this->fetchObject=$mealsDBO->fetchObject;
		$this->affectedRows=$mealsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
