<?php 
require_once("DocumentflowsDBO.php");
class Documentflows
{				
	var $id;			
	var $documentid;			
	var $remarks;			
	var $status;			
	var $document;			
	var $link;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $documentflowsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->documentid))
			$obj->documentid='NULL';
		$this->documentid=$obj->documentid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
		$this->document=str_replace("'","\'",$obj->document);
		$this->link=str_replace("'","\'",$obj->link);
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

	//get documentid
	function getDocumentid(){
		return $this->documentid;
	}
	//set documentid
	function setDocumentid($documentid){
		$this->documentid=$documentid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get document
	function getDocument(){
		return $this->document;
	}
	//set document
	function setDocument($document){
		$this->document=$document;
	}

	//get link
	function getLink(){
		return $this->link;
	}
	//set link
	function setLink($link){
		$this->link=$link;
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
		$documentflowsDBO = new DocumentflowsDBO();
		if($documentflowsDBO->persist($obj)){
			$this->id=$documentflowsDBO->id;
			$this->sql=$documentflowsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$documentflowsDBO = new DocumentflowsDBO();
		if($documentflowsDBO->update($obj,$where)){
			$this->sql=$documentflowsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$documentflowsDBO = new DocumentflowsDBO();
		if($documentflowsDBO->delete($obj,$where=""))		
			$this->sql=$documentflowsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$documentflowsDBO = new DocumentflowsDBO();
		$this->table=$documentflowsDBO->table;
		$documentflowsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$documentflowsDBO->sql;
		$this->result=$documentflowsDBO->result;
		$this->fetchObject=$documentflowsDBO->fetchObject;
		$this->affectedRows=$documentflowsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
