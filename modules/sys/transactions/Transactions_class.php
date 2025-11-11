<?php 
require_once("TransactionsDBO.php");
class Transactions
{				
	var $id;			
	var $name;			
	var $transactionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
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

	function add($obj){
		$transactionsDBO = new TransactionsDBO();
		if($transactionsDBO->persist($obj)){
			$this->id=$transactionsDBO->id;
			$this->sql=$transactionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$transactionsDBO = new TransactionsDBO();
		if($transactionsDBO->update($obj,$where)){
			$this->sql=$transactionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$transactionsDBO = new TransactionsDBO();
		if($transactionsDBO->delete($obj,$where=""))		
			$this->sql=$transactionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$transactionsDBO = new TransactionsDBO();
		$this->table=$transactionsDBO->table;
		$transactionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$transactionsDBO->sql;
		$this->result=$transactionsDBO->result;
		$this->fetchObject=$transactionsDBO->fetchObject;
		$this->affectedRows=$transactionsDBO->affectedRows;
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
