<?php 
require_once("DashboardsDBO.php");
class Dashboards
{				
	var $id;			
	var $name;			
	var $type;			
	var $query;			
	var $cssclass;			
	var $status;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $dashboardsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->type=str_replace("'","\'",$obj->type);
		$this->query=str_replace("'","\'",$obj->query);
		$this->cssclass=str_replace("'","\'",$obj->cssclass);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
	}

	//get query
	function getQuery(){
		return $this->query;
	}
	//set query
	function setQuery($query){
		$this->query=$query;
	}

	//get cssclass
	function getCssclass(){
		return $this->cssclass;
	}
	//set cssclass
	function setCssclass($cssclass){
		$this->cssclass=$cssclass;
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
		$dashboardsDBO = new DashboardsDBO();
		if($dashboardsDBO->persist($obj)){
			$this->id=$dashboardsDBO->id;
			$this->sql=$dashboardsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$dashboardsDBO = new DashboardsDBO();
		if($dashboardsDBO->update($obj,$where)){
			$this->sql=$dashboardsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$dashboardsDBO = new DashboardsDBO();
		if($dashboardsDBO->delete($obj,$where=""))		
			$this->sql=$dashboardsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$dashboardsDBO = new DashboardsDBO();
		$this->table=$dashboardsDBO->table;
		$dashboardsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$dashboardsDBO->sql;
		$this->result=$dashboardsDBO->result;
		$this->fetchObject=$dashboardsDBO->fetchObject;
		$this->affectedRows=$dashboardsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Text should be provided";
		}
		else if(empty($obj->type)){
			$error="Type should be provided";
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
