<?php 
require_once("PrepaidprovisioningDBO.php");
class Prepaidprovisioning
{				
	var $Card_Number;			
	var $Amount;			
	var $Status;			
	var $Hash_Key;			
	var $prepaidprovisioningDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->Card_Number=str_replace("'","\'",$obj->Card_Number);
		$this->Amount=str_replace("'","\'",$obj->Amount);
		$this->Status=str_replace("'","\'",$obj->Status);
		$this->Hash_Key=str_replace("'","\'",$obj->Hash_Key);
		return $this;
	
	}
	//get Card_Number
	function getCard_Number(){
		return $this->Card_Number;
	}
	//set Card_Number
	function setCard_Number($Card_Number){
		$this->Card_Number=$Card_Number;
	}

	//get Amount
	function getAmount(){
		return $this->Amount;
	}
	//set Amount
	function setAmount($Amount){
		$this->Amount=$Amount;
	}

	//get Status
	function getStatus(){
		return $this->Status;
	}
	//set Status
	function setStatus($Status){
		$this->Status=$Status;
	}

	//get Hash_Key
	function getHash_Key(){
		return $this->Hash_Key;
	}
	//set Hash_Key
	function setHash_Key($Hash_Key){
		$this->Hash_Key=$Hash_Key;
	}

	function add($obj){
		$prepaidprovisioningDBO = new PrepaidprovisioningDBO();
		if($prepaidprovisioningDBO->persist($obj)){
			$this->id=$prepaidprovisioningDBO->id;
			$this->sql=$prepaidprovisioningDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$prepaidprovisioningDBO = new PrepaidprovisioningDBO();
		if($prepaidprovisioningDBO->update($obj,$where)){
			$this->sql=$prepaidprovisioningDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$prepaidprovisioningDBO = new PrepaidprovisioningDBO();
		if($prepaidprovisioningDBO->delete($obj,$where=""))		
			$this->sql=$prepaidprovisioningDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$prepaidprovisioningDBO = new PrepaidprovisioningDBO();
		$this->table=$prepaidprovisioningDBO->table;
		$prepaidprovisioningDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$prepaidprovisioningDBO->sql;
		$this->result=$prepaidprovisioningDBO->result;
		$this->fetchObject=$prepaidprovisioningDBO->fetchObject;
		$this->affectedRows=$prepaidprovisioningDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->Card_Number)){
			$error=" should be provided";
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
