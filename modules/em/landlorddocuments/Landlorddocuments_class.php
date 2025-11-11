<?php 
require_once("LandlorddocumentsDBO.php");
class Landlorddocuments
{				
	var $id;			
	var $landlordid;			
	var $documenttypeid;			
	var $name;			
	var $document;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $landlorddocumentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->landlordid))
			$obj->landlordid='NULL';
		$this->landlordid=$obj->landlordid;
		$this->documenttypeid=str_replace("'","\'",$obj->documenttypeid);
		$this->name=str_replace("'","\'",$obj->name);
		$this->document=str_replace("'","\'",$obj->document);
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

	//get landlordid
	function getLandlordid(){
		return $this->landlordid;
	}
	//set landlordid
	function setLandlordid($landlordid){
		$this->landlordid=$landlordid;
	}

	//get documenttypeid
	function getDocumenttypeid(){
		return $this->documenttypeid;
	}
	//set documenttypeid
	function setDocumenttypeid($documenttypeid){
		$this->documenttypeid=$documenttypeid;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get document
	function getDocument(){
		return $this->document;
	}
	//set document
	function setDocument($document){
		$this->document=$document;
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
		$landlorddocumentsDBO = new LandlorddocumentsDBO();
		if($landlorddocumentsDBO->persist($obj)){
			$this->id=$landlorddocumentsDBO->id;
			$this->sql=$landlorddocumentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$landlorddocumentsDBO = new LandlorddocumentsDBO();
		if($landlorddocumentsDBO->update($obj,$where)){
			$this->sql=$landlorddocumentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$landlorddocumentsDBO = new LandlorddocumentsDBO();
		if($landlorddocumentsDBO->delete($obj,$where=""))		
			$this->sql=$landlorddocumentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$landlorddocumentsDBO = new LandlorddocumentsDBO();
		$this->table=$landlorddocumentsDBO->table;
		$landlorddocumentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$landlorddocumentsDBO->sql;
		$this->result=$landlorddocumentsDBO->result;
		$this->fetchObject=$landlorddocumentsDBO->fetchObject;
		$this->affectedRows=$landlorddocumentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->landlordid)){
			$error="Landlord should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->landlordid)){
			$error="Landlord should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
