<?php 
require_once("AccounttypesDBO.php");
class Accounttypes
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $balance;			
	var $accounttypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->customerid=$_SESSION['customerid'];
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get balance
	function getBalance(){
		return $this->balance;
	}
	//set balance
	function setBalance($balance){
		$this->balance=$balance;
	}

	function add($obj){
		$accounttypesDBO = new AccounttypesDBO();
		if($accounttypesDBO->persist($obj)){
			$this->id=$accounttypesDBO->id;
			$this->sql=$accounttypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$accounttypesDBO = new AccounttypesDBO();
		if($accounttypesDBO->update($obj,$where)){
			$this->sql=$accounttypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$accounttypesDBO = new AccounttypesDBO();
		if($accounttypesDBO->delete($obj,$where=""))		
			$this->sql=$accounttypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$accounttypesDBO = new AccounttypesDBO();
		$this->table=$accounttypesDBO->table;
		$accounttypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$accounttypesDBO->sql;
		$this->result=$accounttypesDBO->result;
		$this->fetchObject=$accounttypesDBO->fetchObject;
		$this->affectedRows=$accounttypesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
