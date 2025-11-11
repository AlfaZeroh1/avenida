<?php 
require_once("AssetcategorysDBO.php");
class Assetcategorys
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $assetcategorysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
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
		$assetcategorysDBO = new AssetcategorysDBO();
		if($assetcategorysDBO->persist($obj)){
			//$this->id=$assetcategorysDBO->id;
			
			//adding general journal account(s)
			
			$name=$obj->name;
			$obj->name=$name." Asset A/c";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$assetcategorysDBO->id;
			$obj->acctypeid=7;
			$obj->currencyid=5;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
			
			$this->sql=$assetcategorysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$assetcategorysDBO = new AssetcategorysDBO();
		if($assetcategorysDBO->update($obj,$where)){
			$this->sql=$assetcategorysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$assetcategorysDBO = new AssetcategorysDBO();
		if($assetcategorysDBO->delete($obj,$where=""))		
			$this->sql=$assetcategorysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$assetcategorysDBO = new AssetcategorysDBO();
		$this->table=$assetcategorysDBO->table;
		$assetcategorysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$assetcategorysDBO->sql;
		$this->result=$assetcategorysDBO->result;
		$this->fetchObject=$assetcategorysDBO->fetchObject;
		$this->affectedRows=$assetcategorysDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
