<?php 
require_once("TeamdetailsDBO.php");
class Teamdetails
{				
	var $id;			
	var $teamid;			
	var $teamroleid;			
	var $employeeid;
	var $ordered;
	var $paid;
	var $balance;
	var $submitted;
	var $short;
	var $remarks;	
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $teamdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->teamid))
			$obj->teamid='NULL';
		$this->teamid=$obj->teamid;
		if(empty($obj->teamroleid))
			$obj->teamroleid='NULL';
		$this->teamroleid=$obj->teamroleid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->ordered=$obj->ordered;
		$this->paid=$obj->paid;
		$this->balance=$obj->balance;
		$this->submitted=$obj->submitted;
		$this->short=$obj->short;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		
		$this->createdby=$_SESSION['userid'];
		$this->createdon=date("Y-m-d H:i:s");
		$this->lasteditedby=$_SESSION['userid'];
		$this->lasteditedon=date("Y-m-d H:i:s");
		$this->ipaddress=$_SERVER['REMOTE_ADDR'];
		
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

	//get teamid
	function getTeamid(){
		return $this->teamid;
	}
	//set teamid
	function setTeamid($teamid){
		$this->teamid=$teamid;
	}

	//get teamroleid
	function getTeamroleid(){
		return $this->teamroleid;
	}
	//set teamroleid
	function setTeamroleid($teamroleid){
		$this->teamroleid=$teamroleid;
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
		$teamdetailsDBO = new TeamdetailsDBO();
		if($teamdetailsDBO->persist($obj)){
			$this->id=$teamdetailsDBO->id;
			$this->sql=$teamdetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$teamdetailsDBO = new TeamdetailsDBO();
		if($teamdetailsDBO->update($obj,$where)){
			$this->sql=$teamdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$teamdetailsDBO = new TeamdetailsDBO();
		if($teamdetailsDBO->delete($obj,$where=""))		
			$this->sql=$teamdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$teamdetailsDBO = new TeamdetailsDBO();
		$this->table=$teamdetailsDBO->table;
		$teamdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$teamdetailsDBO->sql;
		$this->result=$teamdetailsDBO->result;
		$this->fetchObject=$teamdetailsDBO->fetchObject;
		$this->affectedRows=$teamdetailsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
