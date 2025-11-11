<?php 
require_once("PrepaidusersDBO.php");
class Prepaidusers
{				
	var $User_id;			
	var $User_pin;			
	var $Account_balance;			
	var $last_reload_card;			
	var $Status;			
	var $User_phone_number;			
	var $User_Pin_Retries;			
	var $User_Allowed_pin_Retries;			
	var $prepaidusersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->User_id=str_replace("'","\'",$obj->User_id);
		$this->User_pin=str_replace("'","\'",$obj->User_pin);
		$this->Account_balance=str_replace("'","\'",$obj->Account_balance);
		$this->last_reload_card=str_replace("'","\'",$obj->last_reload_card);
		$this->Status=str_replace("'","\'",$obj->Status);
		$this->User_phone_number=str_replace("'","\'",$obj->User_phone_number);
		$this->User_Pin_Retries=str_replace("'","\'",$obj->User_Pin_Retries);
		$this->User_Allowed_pin_Retries=str_replace("'","\'",$obj->User_Allowed_pin_Retries);
		return $this;
	
	}
	//get User_id
	function getUser_id(){
		return $this->User_id;
	}
	//set User_id
	function setUser_id($User_id){
		$this->User_id=$User_id;
	}

	//get User_pin
	function getUser_pin(){
		return $this->User_pin;
	}
	//set User_pin
	function setUser_pin($User_pin){
		$this->User_pin=$User_pin;
	}

	//get Account_balance
	function getAccount_balance(){
		return $this->Account_balance;
	}
	//set Account_balance
	function setAccount_balance($Account_balance){
		$this->Account_balance=$Account_balance;
	}

	//get last_reload_card
	function getLast_reload_card(){
		return $this->last_reload_card;
	}
	//set last_reload_card
	function setLast_reload_card($last_reload_card){
		$this->last_reload_card=$last_reload_card;
	}

	//get Status
	function getStatus(){
		return $this->Status;
	}
	//set Status
	function setStatus($Status){
		$this->Status=$Status;
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
		$prepaidusersDBO = new PrepaidusersDBO();
		if($prepaidusersDBO->persist($obj)){
			$this->id=$prepaidusersDBO->id;
			$this->sql=$prepaidusersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$prepaidusersDBO = new PrepaidusersDBO();
		if($prepaidusersDBO->update($obj,$where)){
			$this->sql=$prepaidusersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$prepaidusersDBO = new PrepaidusersDBO();
		if($prepaidusersDBO->delete($obj,$where=""))		
			$this->sql=$prepaidusersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$prepaidusersDBO = new PrepaidusersDBO();
		$this->table=$prepaidusersDBO->table;
		$prepaidusersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$prepaidusersDBO->sql;
		$this->result=$prepaidusersDBO->result;
		$this->fetchObject=$prepaidusersDBO->fetchObject;
		$this->affectedRows=$prepaidusersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->User_id)){
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
