<?php 
require_once("SaletypesDBO.php");
class Saletypes
{				
	var $id;			
	var $name;			
	var $paymenttermid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $saletypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->paymenttermid))
			$obj->paymenttermid='NULL';
		$this->paymenttermid=$obj->paymenttermid;
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

	//get paymenttermid
	function getPaymenttermid(){
		return $this->paymenttermid;
	}
	//set paymenttermid
	function setPaymenttermid($paymenttermid){
		$this->paymenttermid=$paymenttermid;
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
		$saletypesDBO = new SaletypesDBO();
		if($saletypesDBO->persist($obj)){
		
			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$saletypesDBO->id;
			$obj->acctypeid=25;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
			
			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$saletypesDBO->id;
			$obj->acctypeid=27;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
			
			$this->id=$saletypesDBO->id;
			$this->sql=$saletypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$saletypesDBO = new SaletypesDBO();
		if($saletypesDBO->update($obj,$where)){
			
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields=" * ";
			$join="";
			$having="";
			$groupby="";
			$orderby=" ";
			$where=" where refid='$obj->id' and acctypeid='25'";
			$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			
			if($generaljournalaccounts->affectedRows>0){
			  $generaljournalaccounts = $generaljournalaccounts->fetchObject;
			  
			  //adding general journal account(s)
			  $generaljournalaccounts->name=$obj->name;
			  $gn = new Generaljournalaccounts();
			  $gn = $gn->setObject($generaljournalaccounts);
			  $gn->edit($gn);
			}
			else{
			  $name=$obj->name;
			  $obj->name=$name;
			  $generaljournalaccounts = new Generaljournalaccounts();
			  $obj->refid=$obj->id;
			  $obj->id="";
			  $obj->acctypeid=25;
			  $generaljournalaccounts->setObject($obj);
			  $generaljournalaccounts->add($generaljournalaccounts);
			}
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields=" * ";
			$join="";
			$having="";
			$groupby="";
			$orderby=" ";
			$where=" where refid='$obj->id' and acctypeid='27'";
			$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			
			if($generaljournalaccounts->affectedRows>0){
			  $generaljournalaccounts = $generaljournalaccounts->fetchObject;
			  
			  //adding general journal account(s)
			  $generaljournalaccounts->name=$obj->name;
			  $gn = new Generaljournalaccounts();
			  $gn = $gn->setObject($generaljournalaccounts);
			  $gn->edit($gn);
			}else{
			  $name=$obj->name;
			  $obj->name=$name;
			  $generaljournalaccounts = new Generaljournalaccounts();
			  $obj->refid=$obj->id;
			  $obj->id="";
			  $obj->acctypeid=27;
			  $generaljournalaccounts->setObject($obj);
			  $generaljournalaccounts->add($generaljournalaccounts);
			}
			$this->sql=$saletypesDBO->sql;
			return true;	
		}
			
	}			
	function delete($obj,$where=""){			
		$saletypesDBO = new SaletypesDBO();
		if($saletypesDBO->delete($obj,$where=""))		
			$this->sql=$saletypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$saletypesDBO = new SaletypesDBO();
		$this->table=$saletypesDBO->table;
		$saletypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$saletypesDBO->sql;
		$this->result=$saletypesDBO->result;
		$this->fetchObject=$saletypesDBO->fetchObject;
		$this->affectedRows=$saletypesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Saletype Name should be provided";
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
