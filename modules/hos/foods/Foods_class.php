<?php 
require_once("FoodsDBO.php");
class Foods
{				
	var $id;			
	var $name;			
	var $price;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $foodsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->price=str_replace("'","\'",$obj->price);
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

	//get price
	function getPrice(){
		return $this->price;
	}
	//set price
	function setPrice($price){
		$this->price=$price;
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
		$foodsDBO = new FoodsDBO();
		if($foodsDBO->persist($obj)){
			$this->id=$foodsDBO->id;
			$this->sql=$foodsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$foodsDBO = new FoodsDBO();
		if($foodsDBO->update($obj,$where)){
			$this->sql=$foodsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$foodsDBO = new FoodsDBO();
		if($foodsDBO->delete($obj,$where=""))		
			$this->sql=$foodsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$foodsDBO = new FoodsDBO();
		$this->table=$foodsDBO->table;
		$foodsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$foodsDBO->sql;
		$this->result=$foodsDBO->result;
		$this->fetchObject=$foodsDBO->fetchObject;
		$this->affectedRows=$foodsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
