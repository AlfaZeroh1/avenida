<?php 
require_once("RoutesDBO.php");
class Routes
{				
	var $id;			
	var $name;			
	var $moduleid;			
	var $roleid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $routesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->projectid=$_SESSION['projectid'];
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->moduleid))
			$obj->moduleid='NULL';
		$this->moduleid=$obj->moduleid;
		if(empty($obj->roleid))
			$obj->roleid='NULL';
		$this->roleid=$obj->roleid;
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get moduleid
	function getModuleid(){
		return $this->moduleid;
	}
	//set moduleid
	function setModuleid($moduleid){
		$this->moduleid=$moduleid;
	}

	//get roleid
	function getRoleid(){
		return $this->roleid;
	}
	//set roleid
	function setRoleid($roleid){
		$this->roleid=$roleid;
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
		$routesDBO = new RoutesDBO();
		if($routesDBO->persist($obj)){
			$this->id=$routesDBO->id;
			$this->sql=$routesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$routesDBO = new RoutesDBO();
		if($routesDBO->update($obj,$where)){
			$this->sql=$routesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$routesDBO = new RoutesDBO();
		if($routesDBO->delete($obj,$where=""))		
			$this->sql=$routesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$routesDBO = new RoutesDBO();
		$this->table=$routesDBO->table;
		$routesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$routesDBO->sql;
		$this->result=$routesDBO->result;
		$this->fetchObject=$routesDBO->fetchObject;
		$this->affectedRows=$routesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Work Flow Title should be provided";
		}
		else if(empty($obj->moduleid)){
			$error="Module Associated should be provided";
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
