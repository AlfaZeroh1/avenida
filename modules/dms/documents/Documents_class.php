<?php 
require_once("DocumentsDBO.php");
class Documents
{				
	var $id;			
	var $routeid;			
	var $documentno;			
	var $documenttypeid;			
	var $departmentid;			
	var $departmentcategoryid;			
	var $categoryid;			
	var $hrmdepartmentid;			
	var $document;			
	var $link;			
	var $status;			
	var $description;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $documentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->routeid))
			$obj->routeid='NULL';
		$this->routeid=$obj->routeid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->documenttypeid))
			$obj->documenttypeid='NULL';
		$this->documenttypeid=$obj->documenttypeid;
		$this->departmentid=str_replace("'","\'",$obj->departmentid);
		$this->departmentcategoryid=str_replace("'","\'",$obj->departmentcategoryid);
		$this->categoryid=str_replace("'","\'",$obj->categoryid);
		$this->hrmdepartmentid=str_replace("'","\'",$obj->hrmdepartmentid);
		$this->document=str_replace("'","\'",$obj->document);
		$this->link=str_replace("'","\'",$obj->link);
		$this->status=str_replace("'","\'",$obj->status);
		$this->description=str_replace("'","\'",$obj->description);
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

	//get routeid
	function getRouteid(){
		return $this->routeid;
	}
	//set routeid
	function setRouteid($routeid){
		$this->routeid=$routeid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get documenttypeid
	function getDocumenttypeid(){
		return $this->documenttypeid;
	}
	//set documenttypeid
	function setDocumenttypeid($documenttypeid){
		$this->documenttypeid=$documenttypeid;
	}

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
	}

	//get departmentcategoryid
	function getDepartmentcategoryid(){
		return $this->departmentcategoryid;
	}
	//set departmentcategoryid
	function setDepartmentcategoryid($departmentcategoryid){
		$this->departmentcategoryid=$departmentcategoryid;
	}

	//get categoryid
	function getCategoryid(){
		return $this->categoryid;
	}
	//set categoryid
	function setCategoryid($categoryid){
		$this->categoryid=$categoryid;
	}

	//get hrmdepartmentid
	function getHrmdepartmentid(){
		return $this->hrmdepartmentid;
	}
	//set hrmdepartmentid
	function setHrmdepartmentid($hrmdepartmentid){
		$this->hrmdepartmentid=$hrmdepartmentid;
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

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
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
		$documentsDBO = new DocumentsDBO();
		if($documentsDBO->persist($obj)){
			$this->id=$documentsDBO->id;
			$this->sql=$documentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$documentsDBO = new DocumentsDBO();
		if($documentsDBO->update($obj,$where)){
			$this->sql=$documentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$documentsDBO = new DocumentsDBO();
		if($documentsDBO->delete($obj,$where=""))		
			$this->sql=$documentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$documentsDBO = new DocumentsDBO();
		$this->table=$documentsDBO->table;
		$documentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$documentsDBO->sql;
		$this->result=$documentsDBO->result;
		$this->fetchObject=$documentsDBO->fetchObject;
		$this->affectedRows=$documentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->routeid)){
			$error="Route should be provided";
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
	
			return null;
	
	}
}				
?>
