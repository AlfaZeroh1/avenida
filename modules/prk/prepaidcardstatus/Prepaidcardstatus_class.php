<?php 
require_once("PrepaidcardstatusDBO.php");
class Prepaidcardstatus
{				
	var $Card_Number;			
	var $Amount;			
	var $Status;			
	var $User_pin;			
	var $User_id;			
	var $Card_Serial_number;			
	var $User_phone_number;			
	var $User_Pin_Retries;			
	var $User_Allowed_pin_Retries;			
	var $prepaidcardstatusDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->Card_Number=str_replace("'","\'",$obj->Card_Number);
		$this->Amount=str_replace("'","\'",$obj->Amount);
		$this->Status=str_replace("'","\'",$obj->Status);
		$this->User_pin=str_replace("'","\'",$obj->User_pin);
		$this->User_id=str_replace("'","\'",$obj->User_id);
		$this->Card_Serial_number=str_replace("'","\'",$obj->Card_Serial_number);
		$this->User_phone_number=str_replace("'","\'",$obj->User_phone_number);
		$this->User_Pin_Retries=str_replace("'","\'",$obj->User_Pin_Retries);
		$this->User_Allowed_pin_Retries=str_replace("'","\'",$obj->User_Allowed_pin_Retries);
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

	//get User_pin
	function getUser_pin(){
		return $this->User_pin;
	}
	//set User_pin
	function setUser_pin($User_pin){
		$this->User_pin=$User_pin;
	}

	//get User_id
	function getUser_id(){
		return $this->User_id;
	}
	//set User_id
	function setUser_id($User_id){
		$this->User_id=$User_id;
	}

	//get Card_Serial_number
	function getCard_Serial_number(){
		return $this->Card_Serial_number;
	}
	//set Card_Serial_number
	function setCard_Serial_number($Card_Serial_number){
		$this->Card_Serial_number=$Card_Serial_number;
	}

	//get User_phone_number
	function getUser_phone_number(){
		return $this->User_phone_number;
	}
	//set User_phone_number
	function setUser_phone_number($User_phone_number){
		$this->User_phone_number=$User_phone_number;
	}

	//get User_Pin_Retries
	function getUser_Pin_Retries(){
		return $this->User_Pin_Retries;
	}
	//set User_Pin_Retries
	function setUser_Pin_Retries($User_Pin_Retries){
		$this->User_Pin_Retries=$User_Pin_Retries;
	}

	//get User_Allowed_pin_Retries
	function getUser_Allowed_pin_Retries(){
		return $this->User_Allowed_pin_Retries;
	}
	//set User_Allowed_pin_Retries
	function setUser_Allowed_pin_Retries($User_Allowed_pin_Retries){
		$this->User_Allowed_pin_Retries=$User_Allowed_pin_Retries;
	}

	function add($obj){
		$prepaidcardstatusDBO = new PrepaidcardstatusDBO();
		if($prepaidcardstatusDBO->persist($obj)){
			$this->id=$prepaidcardstatusDBO->id;
			$this->sql=$prepaidcardstatusDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$prepaidcardstatusDBO = new PrepaidcardstatusDBO();
		if($prepaidcardstatusDBO->update($obj,$where)){
			$this->sql=$prepaidcardstatusDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$prepaidcardstatusDBO = new PrepaidcardstatusDBO();
		if($prepaidcardstatusDBO->delete($obj,$where=""))		
			$this->sql=$prepaidcardstatusDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$prepaidcardstatusDBO = new PrepaidcardstatusDBO();
		$this->table=$prepaidcardstatusDBO->table;
		$prepaidcardstatusDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$prepaidcardstatusDBO->sql;
		$this->result=$prepaidcardstatusDBO->result;
		$this->fetchObject=$prepaidcardstatusDBO->fetchObject;
		$this->affectedRows=$prepaidcardstatusDBO->affectedRows;
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
