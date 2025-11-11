<?php 
require_once("MaintenancesDBO.php");
class Maintenances
{				
	var $id;			
	var $maintenancetypeid;			
	var $assetid;			
	var $maintainedon;			
	var $doneby;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $maintenancesDBO;
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
		$this->maintainedon=str_replace("'","\'",$obj->maintainedon);
		$this->doneby=str_replace("'","\'",$obj->doneby);
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

	//get maintainedon
	function getMaintainedon(){
		return $this->maintainedon;
	}
	//set maintainedon
	function setMaintainedon($maintainedon){
		$this->maintainedon=$maintainedon;
	}

	//get doneby
	function getDoneby(){
		return $this->doneby;
	}
	//set doneby
	function setDoneby($doneby){
		$this->doneby=$doneby;
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
		$maintenancesDBO = new MaintenancesDBO();
		if($maintenancesDBO->persist($obj)){
			$this->id=$maintenancesDBO->id;
			$this->sql=$maintenancesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$maintenancesDBO = new MaintenancesDBO();
		if($maintenancesDBO->update($obj,$where)){
			$this->sql=$maintenancesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$maintenancesDBO = new MaintenancesDBO();
		if($maintenancesDBO->delete($obj,$where=""))		
			$this->sql=$maintenancesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$maintenancesDBO = new MaintenancesDBO();
		$this->table=$maintenancesDBO->table;
		$maintenancesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$maintenancesDBO->sql;
		$this->result=$maintenancesDBO->result;
		$this->fetchObject=$maintenancesDBO->fetchObject;
		$this->affectedRows=$maintenancesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->maintenancetypeid)){
			$error="Maintenance Types should be provided";
		}
		else if(empty($obj->assetid)){
			$error="Asset should be provided";
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
