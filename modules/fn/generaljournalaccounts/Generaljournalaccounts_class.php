<?php 
require_once("GeneraljournalaccountsDBO.php");
class Generaljournalaccounts
{				
	var $id;			
	var $refid;			
	var $code;			
	var $name;			
	var $acctypeid;	
	var $currencyid;
	var $categoryid;
	var $type;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $generaljournalaccountsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->refid=str_replace("'","\'",$obj->refid);
		$this->code=str_replace("'","\'",$obj->code);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->acctypeid))
			$obj->acctypeid='NULL';
		$this->acctypeid=$obj->acctypeid;
		if(empty($obj->categoryid))
			$obj->categoryid='NULL';
		$this->categoryid=$obj->categoryid;
		
		if(empty($obj->currencyid))
			$obj->currencyid='NULL';
		$this->currencyid=$obj->currencyid;
		$this->type=str_replace("'","\'",$obj->type);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get refid
	function getRefid(){
		return $this->refid;
	}
	//set refid
	function setRefid($refid){
		$this->refid=$refid;
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

	//get acctypeid
	function getAcctypeid(){
		return $this->acctypeid;
	}
	//set acctypeid
	function setAcctypeid($acctypeid){
		$this->acctypeid=$acctypeid;
	}

	//get categoryid
	function getCategoryid(){
		return $this->categoryid;
	}
	//set categoryid
	function setCategoryid($categoryid){
		$this->categoryid=$categoryid;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
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
		$generaljournalaccountsDBO = new GeneraljournalaccountsDBO();
		if($generaljournalaccountsDBO->persist($obj)){
			$this->id=$generaljournalaccountsDBO->id;
			$this->sql=$generaljournalaccountsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$generaljournalaccountsDBO = new GeneraljournalaccountsDBO();
		if($generaljournalaccountsDBO->update($obj,$where)){
			$this->sql=$generaljournalaccountsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$generaljournalaccountsDBO = new GeneraljournalaccountsDBO();
		if($generaljournalaccountsDBO->delete($obj,$where))		
			$this->sql=$generaljournalaccountsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$generaljournalaccountsDBO = new GeneraljournalaccountsDBO();
		$this->table=$generaljournalaccountsDBO->table;
		$generaljournalaccountsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$generaljournalaccountsDBO->sql;
		$this->result=$generaljournalaccountsDBO->result;
		$this->fetchObject=$generaljournalaccountsDBO->fetchObject;
		$this->affectedRows=$generaljournalaccountsDBO->affectedRows;
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
