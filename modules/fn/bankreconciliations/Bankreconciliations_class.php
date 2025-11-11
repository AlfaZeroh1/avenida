<?php 
require_once("BankreconciliationsDBO.php");
class Bankreconciliations
{				
	var $id;			
	var $bankid;			
	var $recondate;			
	var $balance;			
	var $bankreconciliationsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->bankid=str_replace("'","\'",$obj->bankid);
		$this->recondate=str_replace("'","\'",$obj->recondate);
		$this->balance=str_replace("'","\'",$obj->balance);
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

	//get bankid
	function getBankid(){
		return $this->bankid;
	}
	//set bankid
	function setBankid($bankid){
		$this->bankid=$bankid;
	}

	//get recondate
	function getRecondate(){
		return $this->recondate;
	}
	//set recondate
	function setRecondate($recondate){
		$this->recondate=$recondate;
	}

	//get balance
	function getBalance(){
		return $this->balance;
	}
	//set balance
	function setBalance($balance){
		$this->balance=$balance;
	}

	function add($obj){
		$bankreconciliationsDBO = new BankreconciliationsDBO();
		if($bankreconciliationsDBO->persist($obj)){
			$this->id=$bankreconciliationsDBO->id;
			$this->sql=$bankreconciliationsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$bankreconciliationsDBO = new BankreconciliationsDBO();
		if($bankreconciliationsDBO->update($obj,$where)){
			$this->sql=$bankreconciliationsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$bankreconciliationsDBO = new BankreconciliationsDBO();
		if($bankreconciliationsDBO->delete($obj,$where=""))		
			$this->sql=$bankreconciliationsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$bankreconciliationsDBO = new BankreconciliationsDBO();
		$this->table=$bankreconciliationsDBO->table;
		$bankreconciliationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$bankreconciliationsDBO->sql;
		$this->result=$bankreconciliationsDBO->result;
		$this->fetchObject=$bankreconciliationsDBO->fetchObject;
		$this->affectedRows=$bankreconciliationsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
