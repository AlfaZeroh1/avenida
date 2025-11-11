<?php 
require_once("MaintenanceschedulesDBO.php");
class Maintenanceschedules
{				
	var $id;			
	var $maintenancetypeid;			
	var $assetid;			
	var $nextinspection;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $maintenanceschedulesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->maintenancetypeid))
			$obj->maintenancetypeid='NULL';
		$this->maintenancetypeid=$obj->maintenancetypeid;
		if(empty($obj->assetid))
			$obj->assetid='NULL';
		$this->assetid=$obj->assetid;
		$this->nextinspection=str_replace("'","\'",$obj->nextinspection);
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

	//get maintenancetypeid
	function getMaintenancetypeid(){
		return $this->maintenancetypeid;
	}
	//set maintenancetypeid
	function setMaintenancetypeid($maintenancetypeid){
		$this->maintenancetypeid=$maintenancetypeid;
	}

	//get assetid
	function getAssetid(){
		return $this->assetid;
	}
	//set assetid
	function setAssetid($assetid){
		$this->assetid=$assetid;
	}

	//get nextinspection
	function getNextinspection(){
		return $this->nextinspection;
	}
	//set nextinspection
	function setNextinspection($nextinspection){
		$this->nextinspection=$nextinspection;
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
		$maintenanceschedulesDBO = new MaintenanceschedulesDBO();
		if($maintenanceschedulesDBO->persist($obj)){
			$this->id=$maintenanceschedulesDBO->id;
			$this->sql=$maintenanceschedulesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$maintenanceschedulesDBO = new MaintenanceschedulesDBO();
		if($maintenanceschedulesDBO->update($obj,$where)){
			$this->sql=$maintenanceschedulesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$maintenanceschedulesDBO = new MaintenanceschedulesDBO();
		if($maintenanceschedulesDBO->delete($obj,$where=""))		
			$this->sql=$maintenanceschedulesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$maintenanceschedulesDBO = new MaintenanceschedulesDBO();
		$this->table=$maintenanceschedulesDBO->table;
		$maintenanceschedulesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$maintenanceschedulesDBO->sql;
		$this->result=$maintenanceschedulesDBO->result;
		$this->fetchObject=$maintenanceschedulesDBO->fetchObject;
		$this->affectedRows=$maintenanceschedulesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->maintenancetypeid)){
			$error="Maintenance Types should be provided";
		}
		else if(empty($obj->assetid)){
			$error="Asset should be provided";
		}
		else if(empty($obj->nextinspection)){
			$error="Next Inspection Date should be provided";
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
