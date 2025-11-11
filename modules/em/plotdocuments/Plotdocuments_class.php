<?php 
require_once("PlotdocumentsDBO.php");
class Plotdocuments
{				
	var $id;			
	var $plotid;			
	var $documenttypeid;			
	var $name;			
	var $document;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $plotdocumentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->plotid))
			$obj->plotid='NULL';
		$this->plotid=$obj->plotid;
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

	//get plotid
	function getPlotid(){
		return $this->plotid;
	}
	//set plotid
	function setPlotid($plotid){
		$this->plotid=$plotid;
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
		$plotdocumentsDBO = new PlotdocumentsDBO();
		if($plotdocumentsDBO->persist($obj)){
			$this->id=$plotdocumentsDBO->id;
			$this->sql=$plotdocumentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$plotdocumentsDBO = new PlotdocumentsDBO();
		if($plotdocumentsDBO->update($obj,$where)){
			$this->sql=$plotdocumentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$plotdocumentsDBO = new PlotdocumentsDBO();
		if($plotdocumentsDBO->delete($obj,$where=""))		
			$this->sql=$plotdocumentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$plotdocumentsDBO = new PlotdocumentsDBO();
		$this->table=$plotdocumentsDBO->table;
		$plotdocumentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$plotdocumentsDBO->sql;
		$this->result=$plotdocumentsDBO->result;
		$this->fetchObject=$plotdocumentsDBO->fetchObject;
		$this->affectedRows=$plotdocumentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->plotid)){
			$error="Plot should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->plotid)){
			$error="Plot should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
