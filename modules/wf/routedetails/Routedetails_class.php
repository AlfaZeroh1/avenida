<?php 
require_once("RoutedetailsDBO.php");
class Routedetails
{				
	var $id;			
	var $routeid;			
	var $departmentid;			
	var $levelid;			
	var $assignmentid;
	var $query;
	var $systemtaskid;			
	var $follows;			
	var $expectedduration;			
	var $durationtype;
	var $approval;
	var $squery;
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $routedetailsDBO;
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
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		if(empty($obj->levelid))
			$obj->levelid='NULL';
		$this->levelid=$obj->levelid;
		if(empty($obj->assignmentid))
			$obj->assignmentid='NULL';
		$this->assignmentid=$obj->assignmentid;
		$this->query=$obj->query;
		$this->squery=str_replace("'","\'",$obj->squery);
		
		if(empty($obj->systemtaskid))
			$obj->systemtaskid='NULL';
		$this->systemtaskid=$obj->systemtaskid;
		$this->follows=str_replace("'","\'",$obj->follows);
		$this->expectedduration=str_replace("'","\'",$obj->expectedduration);
		$this->durationtype=str_replace("'","\'",$obj->durationtype);
		$this->approval=str_replace("'","\'",$obj->approval);
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

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
	}

	//get levelid
	function getLevelid(){
		return $this->levelid;
	}
	//set levelid
	function setLevelid($levelid){
		$this->levelid=$levelid;
	}

	//get assignmentid
	function getAssignmentid(){
		return $this->assignmentid;
	}
	//set assignmentid
	function setAssignmentid($assignmentid){
		$this->assignmentid=$assignmentid;
	}

	//get systemtaskid
	function getSystemtaskid(){
		return $this->systemtaskid;
	}
	//set systemtaskid
	function setSystemtaskid($systemtaskid){
		$this->systemtaskid=$systemtaskid;
	}

	//get follows
	function getFollows(){
		return $this->follows;
	}
	//set follows
	function setFollows($follows){
		$this->follows=$follows;
	}

	//get expectedduration
	function getExpectedduration(){
		return $this->expectedduration;
	}
	//set expectedduration
	function setExpectedduration($expectedduration){
		$this->expectedduration=$expectedduration;
	}

	//get durationtype
	function getDurationtype(){
		return $this->durationtype;
	}
	//set durationtype
	function setDurationtype($durationtype){
		$this->durationtype=$durationtype;
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
		$routedetail = new Routedetails();
		$fields="*";
		$where=" where follows='$obj->follows' ";
		$having="";
		$orderby=" order by follows ";
		$groupby="";
		$join="";
		$routedetail->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  
		  $where="";
		  
		$routedetailsDBO = new RoutedetailsDBO();
		if($routedetailsDBO->persist($obj)){
		
		      if($routedetail->affectedRows>0 and !empty($obj->follows)){
			$routedetail = $routedetail->fetchObject;
			$routedetail->follows=$routedetailsDBO->id;
			$rt = new Routedetails();
			$rt = $rt->setObject($routedetail);
			
			$where="";
			
			$rt->edit($rt);
		      }	
		      
			$this->id=$routedetailsDBO->id;
			$this->sql=$routedetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$routedetailsDBO = new RoutedetailsDBO();
		if($routedetailsDBO->update($obj,$where)){
			$this->sql=$routedetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$routedetailsDBO = new RoutedetailsDBO();
		if($routedetailsDBO->delete($obj,$where=""))		
			$this->sql=$routedetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$routedetailsDBO = new RoutedetailsDBO();
		$this->table=$routedetailsDBO->table;
		$routedetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$routedetailsDBO->sql;
		$this->result=$routedetailsDBO->result;
		$this->fetchObject=$routedetailsDBO->fetchObject;
		$this->affectedRows=$routedetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->routeid)){
			$error="Route should be provided";
		}
		elseif(empty($obj->assignmentid) and empty($obj->levelid)){
		  $error="Either Job Position or Job Level Must be provided";
		}
		elseif(!empty($obj->assignmentid) and !empty($obj->levelid)){
		  $error="Only one of Job Position and Job Level Must be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
