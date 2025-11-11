<?php 
require_once("CustomerissuesDBO.php");
class Customerissues
{				
	var $id;			
	var $documentno;			
	var $customerid;			
	var $issuetypeid;			
	var $description;			
	var $remarks;			
	var $status;			
	var $employeeid;			
	var $startedon;			
	var $finishedon;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $customerissuesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->customerid=str_replace("'","\'",$obj->customerid);
		$this->issuetypeid=str_replace("'","\'",$obj->issuetypeid);
		$this->description=str_replace("'","\'",$obj->description);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->startedon=str_replace("'","\'",$obj->startedon);
		$this->finishedon=str_replace("'","\'",$obj->finishedon);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get issuetypeid
	function getIssuetypeid(){
		return $this->issuetypeid;
	}
	//set issuetypeid
	function setIssuetypeid($issuetypeid){
		$this->issuetypeid=$issuetypeid;
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

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get startedon
	function getStartedon(){
		return $this->startedon;
	}
	//set startedon
	function setStartedon($startedon){
		$this->startedon=$startedon;
	}

	//get finishedon
	function getFinishedon(){
		return $this->finishedon;
	}
	//set finishedon
	function setFinishedon($finishedon){
		$this->finishedon=$finishedon;
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
		$customerissuesDBO = new CustomerissuesDBO();
		if($customerissuesDBO->persist($obj)){
			$this->id=$customerissuesDBO->id;
			$this->sql=$customerissuesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$customerissuesDBO = new CustomerissuesDBO();
		if($customerissuesDBO->update($obj,$where)){
			$this->sql=$customerissuesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$customerissuesDBO = new CustomerissuesDBO();
		if($customerissuesDBO->delete($obj,$where=""))		
			$this->sql=$customerissuesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$customerissuesDBO = new CustomerissuesDBO();
		$this->table=$customerissuesDBO->table;
		$customerissuesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$customerissuesDBO->sql;
		$this->result=$customerissuesDBO->result;
		$this->fetchObject=$customerissuesDBO->fetchObject;
		$this->affectedRows=$customerissuesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Issue # should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Issue # should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
