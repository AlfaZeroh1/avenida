<?php 
require_once("EmployeedocumentsDBO.php");
class Employeedocuments
{				
	var $id;			
	var $employeeid;			
	var $documenttypeid;			
	var $file;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $employeedocumentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->documenttypeid))
			$obj->documenttypeid='NULL';
		$this->documenttypeid=$obj->documenttypeid;
		$this->file=str_replace("'","\'",$obj->file);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
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

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$employeedocumentsDBO = new EmployeedocumentsDBO();
		if($employeedocumentsDBO->persist($obj)){
			$this->id=$employeedocumentsDBO->id;
			$this->sql=$employeedocumentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeedocumentsDBO = new EmployeedocumentsDBO();
		if($employeedocumentsDBO->update($obj,$where)){
			$this->sql=$employeedocumentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeedocumentsDBO = new EmployeedocumentsDBO();
		if($employeedocumentsDBO->delete($obj,$where=""))		
			$this->sql=$employeedocumentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeedocumentsDBO = new EmployeedocumentsDBO();
		$this->table=$employeedocumentsDBO->table;
		$employeedocumentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeedocumentsDBO->sql;
		$this->result=$employeedocumentsDBO->result;
		$this->fetchObject=$employeedocumentsDBO->fetchObject;
		$this->affectedRows=$employeedocumentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->documenttypeid)){
			$error="Document Type should be provided";
		}
		else if(empty($obj->file)){
			$error="Browse Document should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
