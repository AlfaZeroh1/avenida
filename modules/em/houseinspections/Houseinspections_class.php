<?php 
require_once("HouseinspectionsDBO.php");
class Houseinspections
{				
	var $id;			
	var $houseid;			
	var $housestatusid;			
	var $findings;			
	var $recommendations;			
	var $remarks;			
	var $employeeid;			
	var $doneon;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $houseinspectionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->houseid))
			$obj->houseid='NULL';
		$this->houseid=$obj->houseid;
		if(empty($obj->housestatusid))
			$obj->housestatusid='NULL';
		$this->housestatusid=$obj->housestatusid;
		$this->findings=str_replace("'","\'",$obj->findings);
		$this->recommendations=str_replace("'","\'",$obj->recommendations);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->doneon=str_replace("'","\'",$obj->doneon);
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

	//get houseid
	function getHouseid(){
		return $this->houseid;
	}
	//set houseid
	function setHouseid($houseid){
		$this->houseid=$houseid;
	}

	//get housestatusid
	function getHousestatusid(){
		return $this->housestatusid;
	}
	//set housestatusid
	function setHousestatusid($housestatusid){
		$this->housestatusid=$housestatusid;
	}

	//get findings
	function getFindings(){
		return $this->findings;
	}
	//set findings
	function setFindings($findings){
		$this->findings=$findings;
	}

	//get recommendations
	function getRecommendations(){
		return $this->recommendations;
	}
	//set recommendations
	function setRecommendations($recommendations){
		$this->recommendations=$recommendations;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get doneon
	function getDoneon(){
		return $this->doneon;
	}
	//set doneon
	function setDoneon($doneon){
		$this->doneon=$doneon;
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
		$houseinspectionsDBO = new HouseinspectionsDBO();
		if($houseinspectionsDBO->persist($obj)){
			$this->id=$houseinspectionsDBO->id;
			$this->sql=$houseinspectionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$houseinspectionsDBO = new HouseinspectionsDBO();
		if($houseinspectionsDBO->update($obj,$where)){
			$this->sql=$houseinspectionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$houseinspectionsDBO = new HouseinspectionsDBO();
		if($houseinspectionsDBO->delete($obj,$where=""))		
			$this->sql=$houseinspectionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$houseinspectionsDBO = new HouseinspectionsDBO();
		$this->table=$houseinspectionsDBO->table;
		$houseinspectionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$houseinspectionsDBO->sql;
		$this->result=$houseinspectionsDBO->result;
		$this->fetchObject=$houseinspectionsDBO->fetchObject;
		$this->affectedRows=$houseinspectionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->houseid)){
			$error="Unit should be provided";
		}
		else if(empty($obj->housestatusid)){
			$error="House Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->houseid)){
			$error="Unit should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
