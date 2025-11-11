<?php 
require_once("DepartmentdoctorsDBO.php");
class Departmentdoctors
{				
	var $id;			
	var $departmentid;			
	var $employeeid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $departmentdoctorsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
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

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
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
		$departmentdoctorsDBO = new DepartmentdoctorsDBO();
		if($departmentdoctorsDBO->persist($obj)){
			$this->id=$departmentdoctorsDBO->id;
			$this->sql=$departmentdoctorsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$departmentdoctorsDBO = new DepartmentdoctorsDBO();
		if($departmentdoctorsDBO->update($obj,$where)){
			$this->sql=$departmentdoctorsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$departmentdoctorsDBO = new DepartmentdoctorsDBO();
		if($departmentdoctorsDBO->delete($obj,$where=""))		
			$this->sql=$departmentdoctorsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$departmentdoctorsDBO = new DepartmentdoctorsDBO();
		$this->table=$departmentdoctorsDBO->table;
		$departmentdoctorsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$departmentdoctorsDBO->sql;
		$this->result=$departmentdoctorsDBO->result;
		$this->fetchObject=$departmentdoctorsDBO->fetchObject;
		$this->affectedRows=$departmentdoctorsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->departmentid)){
			$error="Department should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->departmentid)){
			$error="Department should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
