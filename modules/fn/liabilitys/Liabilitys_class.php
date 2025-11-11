<?php 
require_once("LiabilitysDBO.php");
class Liabilitys
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
	var $liabilitysDBO;
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
		$liabilitysDBO = new LiabilitysDBO();
		if($liabilitysDBO->persist($obj)){
		
			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$liabilitysDBO->id;
			$obj->acctypeid=35;
			$obj->currencyid=5;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
			
			$this->id=$liabilitysDBO->id;
			$this->sql=$liabilitysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$liabilitysDBO = new LiabilitysDBO();
		if($liabilitysDBO->update($obj,$where)){
                        
                        $obj->acctypeid=35;
                        
                        $generaljournalaccounts = new Generaljournalaccounts();
                        $fields="*";
                        $where=" where refid='$obj->id' and acctypeid=35 ";
                        $join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			if($generaljournalaccounts->affectedRows>0){
			
			  $journals = new Generaljournalaccounts();
			  $generaljournalaccounts = $generaljournalaccounts->fetchObject;
			  $generaljournalaccounts->name = $obj->name;
			  $generaljournalaccounts->acctypeid=35;
			  $generaljournalaccounts->currencyid=5;
			  
			  $journals = $journals->setObject($generaljournalaccounts);
			  
			  $journals->edit($journals);
			  
			}else{
			  $journals = new Generaljournalaccounts();
			  
			  $gna->refid=$liabilitysDBO->id;
			  $gna->acctypeid=35;
			  $gna->currencyid=5;
			  $journals = $journals->setObject($gna);
			  $journals->add($journals);
			}
                        
			$this->sql=$liabilitysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$liabilitysDBO = new LiabilitysDBO();
		if($liabilitysDBO->delete($obj,$where=""))		
			$this->sql=$liabilitysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$liabilitysDBO = new LiabilitysDBO();
		$this->table=$liabilitysDBO->table;
		$liabilitysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$liabilitysDBO->sql;
		$this->result=$liabilitysDBO->result;
		$this->fetchObject=$liabilitysDBO->fetchObject;
		$this->affectedRows=$liabilitysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Liability Name should be provided";
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
