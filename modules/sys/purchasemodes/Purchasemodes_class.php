<?php 
require_once("PurchasemodesDBO.php");
class Purchasemodes
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $purchasemodesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	function add($obj){
		$purchasemodesDBO = new PurchasemodesDBO();
		if($purchasemodesDBO->persist($obj)){
			$this->id=$purchasemodesDBO->id;
			$this->sql=$purchasemodesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$purchasemodesDBO = new PurchasemodesDBO();
		if($purchasemodesDBO->update($obj,$where)){
			$this->sql=$purchasemodesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$purchasemodesDBO = new PurchasemodesDBO();
		if($purchasemodesDBO->delete($obj,$where=""))		
			$this->sql=$purchasemodesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$purchasemodesDBO = new PurchasemodesDBO();
		$this->table=$purchasemodesDBO->table;
		$purchasemodesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$purchasemodesDBO->sql;
		$this->result=$purchasemodesDBO->result;
		$this->fetchObject=$purchasemodesDBO->fetchObject;
		$this->affectedRows=$purchasemodesDBO->affectedRows;
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
