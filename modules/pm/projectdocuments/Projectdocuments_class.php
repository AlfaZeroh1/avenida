<?php 
require_once("ProjectdocumentsDBO.php");
class Projectdocuments
{				
	var $id;			
	var $projectid;			
	var $documenttypeid;			
	var $file;			
	var $uploadedon;			
	var $type;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectdocumentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->documenttypeid))
			$obj->documenttypeid='NULL';
		$this->documenttypeid=$obj->documenttypeid;
		$this->file=str_replace("'","\'",$obj->file);
		$this->uploadedon=str_replace("'","\'",$obj->uploadedon);
		$this->type=str_replace("'","\'",$obj->type);
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

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get documenttypeid
	function getDocumenttypeid(){
		return $this->documenttypeid;
	}
	//set documenttypeid
	function setDocumenttypeid($documenttypeid){
		$this->documenttypeid=$documenttypeid;
	}

	//get file
	function getFile(){
		return $this->file;
	}
	//set file
	function setFile($file){
		$this->file=$file;
	}

	//get uploadedon
	function getUploadedon(){
		return $this->uploadedon;
	}
	//set uploadedon
	function setUploadedon($uploadedon){
		$this->uploadedon=$uploadedon;
	}

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
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
		$projectdocumentsDBO = new ProjectdocumentsDBO();
		if($projectdocumentsDBO->persist($obj)){
			$this->id=$projectdocumentsDBO->id;
			$this->sql=$projectdocumentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectdocumentsDBO = new ProjectdocumentsDBO();
		if($projectdocumentsDBO->update($obj,$where)){
			$this->sql=$projectdocumentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectdocumentsDBO = new ProjectdocumentsDBO();
		if($projectdocumentsDBO->delete($obj,$where=""))		
			$this->sql=$projectdocumentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectdocumentsDBO = new ProjectdocumentsDBO();
		$this->table=$projectdocumentsDBO->table;
		$projectdocumentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectdocumentsDBO->sql;
		$this->result=$projectdocumentsDBO->result;
		$this->fetchObject=$projectdocumentsDBO->fetchObject;
		$this->affectedRows=$projectdocumentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->projectid)){
			$error="Project should be provided";
		}
		else if(empty($obj->documenttypeid)){
			$error="Document Type should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->projectid)){
			$error="Project should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
