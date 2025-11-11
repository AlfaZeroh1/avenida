<?php 
require_once("FleetschedulesDBO.php");
class Fleetschedules
{				
	var $id;			
	var $assetid;			
	var $employeeid;			
	var $projectid;			
	var $customerid;			
	var $source;			
	var $destination;			
	var $departuretime;			
	var $expectedarrivaltime;			
	var $arrivaltime;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $fleetschedulesDBO;
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
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		$this->source=str_replace("'","\'",$obj->source);
		$this->destination=str_replace("'","\'",$obj->destination);
		$this->departuretime=str_replace("'","\'",$obj->departuretime);
		$this->expectedarrivaltime=str_replace("'","\'",$obj->expectedarrivaltime);
		$this->arrivaltime=str_replace("'","\'",$obj->arrivaltime);
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

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get source
	function getSource(){
		return $this->source;
	}
	//set source
	function setSource($source){
		$this->source=$source;
	}

	//get destination
	function getDestination(){
		return $this->destination;
	}
	//set destination
	function setDestination($destination){
		$this->destination=$destination;
	}

	//get departuretime
	function getDeparturetime(){
		return $this->departuretime;
	}
	//set departuretime
	function setDeparturetime($departuretime){
		$this->departuretime=$departuretime;
	}

	//get expectedarrivaltime
	function getExpectedarrivaltime(){
		return $this->expectedarrivaltime;
	}
	//set expectedarrivaltime
	function setExpectedarrivaltime($expectedarrivaltime){
		$this->expectedarrivaltime=$expectedarrivaltime;
	}

	//get arrivaltime
	function getArrivaltime(){
		return $this->arrivaltime;
	}
	//set arrivaltime
	function setArrivaltime($arrivaltime){
		$this->arrivaltime=$arrivaltime;
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
		$fleetschedulesDBO = new FleetschedulesDBO();
		if($fleetschedulesDBO->persist($obj)){
			$this->id=$fleetschedulesDBO->id;
			$this->sql=$fleetschedulesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$fleetschedulesDBO = new FleetschedulesDBO();
		if($fleetschedulesDBO->update($obj,$where)){
			$this->sql=$fleetschedulesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$fleetschedulesDBO = new FleetschedulesDBO();
		if($fleetschedulesDBO->delete($obj,$where=""))		
			$this->sql=$fleetschedulesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$fleetschedulesDBO = new FleetschedulesDBO();
		$this->table=$fleetschedulesDBO->table;
		$fleetschedulesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$fleetschedulesDBO->sql;
		$this->result=$fleetschedulesDBO->result;
		$this->fetchObject=$fleetschedulesDBO->fetchObject;
		$this->affectedRows=$fleetschedulesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->assetid)){
			$error="Asset should be provided";
		}
		else if(empty($obj->source)){
			$error="Source should be provided";
		}
		else if(empty($obj->destination)){
			$error="Destination should be provided";
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
