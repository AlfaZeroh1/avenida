<?php 
require_once("FleetsDBO.php");
class Fleets
{				
	var $id;			
	var $assetid;			
	var $fleetmodelid;			
	var $year;			
	var $fleetcolorid;			
	var $vin;			
	var $fleettypeid;			
	var $plateno;			
	var $engine;			
	var $fleetfueltypeid;			
	var $fleetodometertypeid;			
	var $mileage;			
	var $lastservicemileage;			
	var $employeeid;			
	var $departmentid;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $fleetsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->assetid=str_replace("'","\'",$obj->assetid);
		if(empty($obj->fleetmodelid))
			$obj->fleetmodelid='NULL';
		$this->fleetmodelid=$obj->fleetmodelid;
		$this->year=str_replace("'","\'",$obj->year);
		$this->fleetcolorid=str_replace("'","\'",$obj->fleetcolorid);
		$this->vin=str_replace("'","\'",$obj->vin);
		if(empty($obj->fleettypeid))
			$obj->fleettypeid='NULL';
		$this->fleettypeid=$obj->fleettypeid;
		$this->plateno=str_replace("'","\'",$obj->plateno);
		$this->engine=str_replace("'","\'",$obj->engine);
		if(empty($obj->fleetfueltypeid))
			$obj->fleetfueltypeid='NULL';
		$this->fleetfueltypeid=$obj->fleetfueltypeid;
		if(empty($obj->fleetodometertypeid))
			$obj->fleetodometertypeid='NULL';
		$this->fleetodometertypeid=$obj->fleetodometertypeid;
		$this->mileage=str_replace("'","\'",$obj->mileage);
		$this->lastservicemileage=str_replace("'","\'",$obj->lastservicemileage);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
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

	//get fleetmodelid
	function getFleetmodelid(){
		return $this->fleetmodelid;
	}
	//set fleetmodelid
	function setFleetmodelid($fleetmodelid){
		$this->fleetmodelid=$fleetmodelid;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get fleetcolorid
	function getFleetcolorid(){
		return $this->fleetcolorid;
	}
	//set fleetcolorid
	function setFleetcolorid($fleetcolorid){
		$this->fleetcolorid=$fleetcolorid;
	}

	//get vin
	function getVin(){
		return $this->vin;
	}
	//set vin
	function setVin($vin){
		$this->vin=$vin;
	}

	//get fleettypeid
	function getFleettypeid(){
		return $this->fleettypeid;
	}
	//set fleettypeid
	function setFleettypeid($fleettypeid){
		$this->fleettypeid=$fleettypeid;
	}

	//get plateno
	function getPlateno(){
		return $this->plateno;
	}
	//set plateno
	function setPlateno($plateno){
		$this->plateno=$plateno;
	}

	//get engine
	function getEngine(){
		return $this->engine;
	}
	//set engine
	function setEngine($engine){
		$this->engine=$engine;
	}

	//get fleetfueltypeid
	function getFleetfueltypeid(){
		return $this->fleetfueltypeid;
	}
	//set fleetfueltypeid
	function setFleetfueltypeid($fleetfueltypeid){
		$this->fleetfueltypeid=$fleetfueltypeid;
	}

	//get fleetodometertypeid
	function getFleetodometertypeid(){
		return $this->fleetodometertypeid;
	}
	//set fleetodometertypeid
	function setFleetodometertypeid($fleetodometertypeid){
		$this->fleetodometertypeid=$fleetodometertypeid;
	}

	//get mileage
	function getMileage(){
		return $this->mileage;
	}
	//set mileage
	function setMileage($mileage){
		$this->mileage=$mileage;
	}

	//get lastservicemileage
	function getLastservicemileage(){
		return $this->lastservicemileage;
	}
	//set lastservicemileage
	function setLastservicemileage($lastservicemileage){
		$this->lastservicemileage=$lastservicemileage;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
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
		$fleetsDBO = new FleetsDBO();
		if($fleetsDBO->persist($obj)){
			$this->id=$fleetsDBO->id;
			$this->sql=$fleetsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$fleetsDBO = new FleetsDBO();
		if($fleetsDBO->update($obj,$where)){
			$this->sql=$fleetsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$fleetsDBO = new FleetsDBO();
		if($fleetsDBO->delete($obj,$where=""))		
			$this->sql=$fleetsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$fleetsDBO = new FleetsDBO();
		$this->table=$fleetsDBO->table;
		$fleetsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$fleetsDBO->sql;
		$this->result=$fleetsDBO->result;
		$this->fetchObject=$fleetsDBO->fetchObject;
		$this->affectedRows=$fleetsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->assetid)){
			$error="Fleet should be provided";
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
