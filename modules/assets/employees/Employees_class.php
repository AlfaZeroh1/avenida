<?php 
require_once("EmployeesDBO.php");
class Employees
{				
	var $id;			
	var $assetid;			
	var $employeeid;			
	var $datefrom;			
	var $todate;			
	var $reason;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->assetid))
			$obj->assetid='NULL';
		$this->assetid=$obj->assetid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->datefrom=str_replace("'","\'",$obj->datefrom);
		$this->todate=str_replace("'","\'",$obj->todate);
		$this->reason=str_replace("'","\'",$obj->reason);
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

	//get assetid
	function getAssetid(){
		return $this->assetid;
	}
	//set assetid
	function setAssetid($assetid){
		$this->assetid=$assetid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get datefrom
	function getDatefrom(){
		return $this->datefrom;
	}
	//set datefrom
	function setDatefrom($datefrom){
		$this->datefrom=$datefrom;
	}

	//get todate
	function getTodate(){
		return $this->todate;
	}
	//set todate
	function setTodate($todate){
		$this->todate=$todate;
	}

	//get reason
	function getReason(){
		return $this->reason;
	}
	//set reason
	function setReason($reason){
		$this->reason=$reason;
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
		$employeesDBO = new EmployeesDBO();
		if($employeesDBO->persist($obj)){
			$this->id=$employeesDBO->id;
			$this->sql=$employeesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeesDBO = new EmployeesDBO();
		if($employeesDBO->update($obj,$where)){
			$this->sql=$employeesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeesDBO = new EmployeesDBO();
		if($employeesDBO->delete($obj,$where=""))		
			$this->sql=$employeesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeesDBO = new EmployeesDBO();
		$this->table=$employeesDBO->table;
		$employeesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeesDBO->sql;
		$this->result=$employeesDBO->result;
		$this->fetchObject=$employeesDBO->fetchObject;
		$this->affectedRows=$employeesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->assetid)){
			$error="Asset should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->datefrom)){
			$error="Date From should be provided";
		}
		else if(empty($obj->reason)){
			$error="Reason should be provided";
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
