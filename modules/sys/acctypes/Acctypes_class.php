<?php 
require_once("AcctypesDBO.php");
class Acctypes
{				
	var $id;			
	var $code;			
	var $name;			
	var $accounttypeid;			
	var $subaccountypeid;			
	var $balance;			
	var $accounttype;			
	var $direct;			
	var $acctypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->code=str_replace("'","\'",$obj->code);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->accounttypeid))
			$obj->accounttypeid='NULL';
		$this->accounttypeid=$obj->accounttypeid;
		if(empty($obj->subaccountypeid))
			$obj->subaccountypeid='NULL';
		$this->subaccountypeid=$obj->subaccountypeid;
		$this->balance=str_replace("'","\'",$obj->balance);
		$this->accounttype=str_replace("'","\'",$obj->accounttype);
		$this->direct=str_replace("'","\'",$obj->direct);
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

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get accounttypeid
	function getAccounttypeid(){
		return $this->accounttypeid;
	}
	//set accounttypeid
	function setAccounttypeid($accounttypeid){
		$this->accounttypeid=$accounttypeid;
	}

	//get subaccountypeid
	function getSubaccountypeid(){
		return $this->subaccountypeid;
	}
	//set subaccountypeid
	function setSubaccountypeid($subaccountypeid){
		$this->subaccountypeid=$subaccountypeid;
	}

	//get balance
	function getBalance(){
		return $this->balance;
	}
	//set balance
	function setBalance($balance){
		$this->balance=$balance;
	}

	//get accounttype
	function getAccounttype(){
		return $this->accounttype;
	}
	//set accounttype
	function setAccounttype($accounttype){
		$this->accounttype=$accounttype;
	}

	//get direct
	function getDirect(){
		return $this->direct;
	}
	//set direct
	function setDirect($direct){
		$this->direct=$direct;
	}

	function add($obj){
		$acctypesDBO = new AcctypesDBO();
		if($acctypesDBO->persist($obj)){
			$this->id=$acctypesDBO->id;
			$this->sql=$acctypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$acctypesDBO = new AcctypesDBO();
		if($acctypesDBO->update($obj,$where)){
			$this->sql=$acctypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$acctypesDBO = new AcctypesDBO();
		if($acctypesDBO->delete($obj,$where=""))		
			$this->sql=$acctypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$acctypesDBO = new AcctypesDBO();
		$this->table=$acctypesDBO->table;
		$acctypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$acctypesDBO->sql;
		$this->result=$acctypesDBO->result;
		$this->fetchObject=$acctypesDBO->fetchObject;
		$this->affectedRows=$acctypesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
