<?php 
require_once("PrepaidbillingDBO.php");
class Prepaidbilling
{				
	var $User_id;			
	var $User_id_type;			
	var $Transaction_Type;			
	var $Transaction_Amount;			
	var $Account_Balance;			
	var $Card_number;			
	var $prepaidbillingDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->User_id=str_replace("'","\'",$obj->User_id);
		$this->User_id_type=str_replace("'","\'",$obj->User_id_type);
		$this->Transaction_Type=str_replace("'","\'",$obj->Transaction_Type);
		$this->Transaction_Amount=str_replace("'","\'",$obj->Transaction_Amount);
		$this->Account_Balance=str_replace("'","\'",$obj->Account_Balance);
		$this->Card_number=str_replace("'","\'",$obj->Card_number);
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

	//get User_id_type
	function getUser_id_type(){
		return $this->User_id_type;
	}
	//set User_id_type
	function setUser_id_type($User_id_type){
		$this->User_id_type=$User_id_type;
	}

	//get Transaction_Type
	function getTransaction_Type(){
		return $this->Transaction_Type;
	}
	//set Transaction_Type
	function setTransaction_Type($Transaction_Type){
		$this->Transaction_Type=$Transaction_Type;
	}

	//get Transaction_Amount
	function getTransaction_Amount(){
		return $this->Transaction_Amount;
	}
	//set Transaction_Amount
	function setTransaction_Amount($Transaction_Amount){
		$this->Transaction_Amount=$Transaction_Amount;
	}

	//get Account_Balance
	function getAccount_Balance(){
		return $this->Account_Balance;
	}
	//set Account_Balance
	function setAccount_Balance($Account_Balance){
		$this->Account_Balance=$Account_Balance;
	}

	//get Card_number
	function getCard_number(){
		return $this->Card_number;
	}
	//set Card_number
	function setCard_number($Card_number){
		$this->Card_number=$Card_number;
	}

	function add($obj){
		$prepaidbillingDBO = new PrepaidbillingDBO();
		if($prepaidbillingDBO->persist($obj)){
			$this->id=$prepaidbillingDBO->id;
			$this->sql=$prepaidbillingDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$prepaidbillingDBO = new PrepaidbillingDBO();
		if($prepaidbillingDBO->update($obj,$where)){
			$this->sql=$prepaidbillingDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$prepaidbillingDBO = new PrepaidbillingDBO();
		if($prepaidbillingDBO->delete($obj,$where=""))		
			$this->sql=$prepaidbillingDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$prepaidbillingDBO = new PrepaidbillingDBO();
		$this->table=$prepaidbillingDBO->table;
		$prepaidbillingDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$prepaidbillingDBO->sql;
		$this->result=$prepaidbillingDBO->result;
		$this->fetchObject=$prepaidbillingDBO->fetchObject;
		$this->affectedRows=$prepaidbillingDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
