<?php 
require_once("ExpensetypesDBO.php");
class Expensetypes
{				
	var $id;			
	var $name;
	var $acctypeid;
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $expensetypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->acctypeid=str_replace("'","\'",$obj->acctypeid);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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
		$expensetypesDBO = new ExpensetypesDBO();
		if($expensetypesDBO->persist($obj)){
			
			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$expensetypesDBO->id;
// 			$obj->acctypeid=5;
			$obj->currencyid=5;
			if($obj->acctypeid==5){
			  $obj->type="expensetype";
			}else{
			  $obj->type="cos";
			}
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
			
			$this->id=$expensetypesDBO->id;
			$this->sql=$expensetypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$expensetypesDBO = new ExpensetypesDBO();
		if($expensetypesDBO->update($obj,$where)){
			
			$id=$obj->id;
			$obj->id="";
			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$id;
// 			$obj->acctypeid=5;
			if($obj->acctypeid==4){
			  $obj->type="expensetype";
			  $obj->acctypeid=5;
			}else{
			  $obj->type="cos";
			}
			if($obj->oldacctypeid==4){
			  $obj->oldtype="expensetype";
			  $oldacctypeid=5;
			}else{
			  $obj->oldtype="cos";
			  $oldacctypeid=26;
			}
			$obj->currencyid=5;
			$generaljournalaccounts->setObject($obj);
			
			//get expense type account
			$expensetypes = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$id' and acctypeid='$oldacctypeid' and type='$obj->oldtype' ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$expensetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			if($expensetypes->affectedRows>0){
			  $expensetypes = $expensetypes->fetchObject;
			  $generaljournalaccounts->id=$expensetypes->id;
			  $generaljournalaccounts->edit($generaljournalaccounts);
			}else{			  
			  $generaljournalaccounts->add($generaljournalaccounts);
			}
			
			$this->sql=$expensetypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$expensetypesDBO = new ExpensetypesDBO();
		if($expensetypesDBO->delete($obj,$where=""))		
			$this->sql=$expensetypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$expensetypesDBO = new ExpensetypesDBO();
		$this->table=$expensetypesDBO->table;
		$expensetypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$expensetypesDBO->sql;
		$this->result=$expensetypesDBO->result;
		$this->fetchObject=$expensetypesDBO->fetchObject;
		$this->affectedRows=$expensetypesDBO->affectedRows;
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
