<?php 
require_once("ChecklistemployeesDBO.php");
class Checklistemployees
{				
	var $id;			
	var $checklistid;			
	var $employeeid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $checklistemployeesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->checklistid))
			$obj->checklistid='NULL';
		$this->checklistid=$obj->checklistid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
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

	//get checklistid
	function getChecklistid(){
		return $this->checklistid;
	}
	//set checklistid
	function setChecklistid($checklistid){
		$this->checklistid=$checklistid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
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
		$checklistemployeesDBO = new ChecklistemployeesDBO();
		if($checklistemployeesDBO->persist($obj)){
		
				$obj->workflow=0;
				$obj->routeid=0;
				$obj->ownerid=$_SESSION['userid'];
				$obj->name="Tender Checklist [".$obj->responsibility."] ";
				$obj->projectid=$obj->projectid;
				$obj->projecttype="Tender";
				$obj->assignmentid=$obj->assignmentid;
				$obj->employeeid=$obj->employeeid;
				$obj->documenttype="Tender Checklist";
				$obj->documentno=$obj->documentno;
				$obj->tracktime="Yes";
				$obj->reqduration=$routedetails->expectedduration;
				$obj->reqdurationtype=$routedetails->durationtype;
				$obj->createdby=$_SESSION['userid'];
				$obj->createdon=date("Y-m-d H:i:s");
				$obj->lasteditedby=$_SESSION['userid'];
				$obj->lasteditedon=date("Y-m-d H:i:s");
				$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
				$obj->statusid=1;
				$obj->subject="Action Plan Assignment";
				$obj->body="You have been assigned an action plan task to work on $obj->name.\"$obj->description\"";
				
				$tasks = new Tasks();
				$tasks->processTask($obj);
				
			$this->id=$checklistemployeesDBO->id;
			$this->sql=$checklistemployeesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$checklistemployeesDBO = new ChecklistemployeesDBO();
		if($checklistemployeesDBO->update($obj,$where)){
			$this->sql=$checklistemployeesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$checklistemployeesDBO = new ChecklistemployeesDBO();
		if($checklistemployeesDBO->delete($obj,$where=""))		
			$this->sql=$checklistemployeesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$checklistemployeesDBO = new ChecklistemployeesDBO();
		$this->table=$checklistemployeesDBO->table;
		$checklistemployeesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$checklistemployeesDBO->sql;
		$this->result=$checklistemployeesDBO->result;
		$this->fetchObject=$checklistemployeesDBO->fetchObject;
		$this->affectedRows=$checklistemployeesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->checklistid)){
			$error="Responsibility should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Assigned To should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->employeeid)){
			$error="Assigned To should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
