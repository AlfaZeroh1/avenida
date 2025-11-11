<?php 
require_once("ReportprogressDBO.php");
class Reportprogress
{				
	var $id;			
	var $reportid;			
	var $status;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $reportprogressDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->reportid))
			$obj->reportid='NULL';
		$this->reportid=$obj->reportid;
		$this->status=str_replace("'","\'",$obj->status);
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

	//get reportid
	function getReportid(){
		return $this->reportid;
	}
	//set reportid
	function setReportid($reportid){
		$this->reportid=$reportid;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		$reportprogressDBO = new ReportprogressDBO();
		if($reportprogressDBO->persist($obj)){
			$this->id=$reportprogressDBO->id;
			$this->sql=$reportprogressDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$reportprogressDBO = new ReportprogressDBO();
		if($reportprogressDBO->update($obj,$where)){
			$this->sql=$reportprogressDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$reportprogressDBO = new ReportprogressDBO();
		if($reportprogressDBO->delete($obj,$where=""))		
			$this->sql=$reportprogressDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$reportprogressDBO = new ReportprogressDBO();
		$this->table=$reportprogressDBO->table;
		$reportprogressDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$reportprogressDBO->sql;
		$this->result=$reportprogressDBO->result;
		$this->fetchObject=$reportprogressDBO->fetchObject;
		$this->affectedRows=$reportprogressDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->reportid)){
			$error="Report should be provided";
		}
		else if(empty($obj->status)){
			$error="Status should be provided";
		}
		else if(empty($obj->remarks)){
			$error="Remarks should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->status)){
			$error="Status should be provided";
		}
		else if(empty($obj->remarks)){
			$error="Remarks should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
