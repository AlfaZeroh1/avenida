<?php 
require_once("GreenhousevarietysDBO.php");
class Greenhousevarietys
{				
	var $id;			
	var $greenhouseid;			
	var $varietyid;	
	var $headsize;
	var $employeeid;
	var $breederid;
	var $area;			
	var $plants;	
	var $plantedon;
	var $noofbeds;
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $greenhousevarietysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->greenhouseid))
			$obj->greenhouseid='NULL';
		$this->greenhouseid=$obj->greenhouseid;
		if(empty($obj->varietyid))
			$obj->varietyid='NULL';
		$this->varietyid=$obj->varietyid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->breederid))
			$obj->breederid='NULL';
		$this->breederid=$obj->breederid;
		$this->area=str_replace("'","\'",$obj->area);
		$this->headsize=str_replace("'","\'",$obj->headsize);
		$this->plants=str_replace("'","\'",$obj->plants);
		$this->plantedon=str_replace("'","\'",$obj->plantedon);
		$this->noofbeds=str_replace("'","\'",$obj->noofbeds);
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

	//get greenhouseid
	function getGreenhouseid(){
		return $this->greenhouseid;
	}
	//set greenhouseid
	function setGreenhouseid($greenhouseid){
		$this->greenhouseid=$greenhouseid;
	}

	//get varietyid
	function getVarietyid(){
		return $this->varietyid;
	}
	//set varietyid
	function setVarietyid($varietyid){
		$this->varietyid=$varietyid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}
	//get breederid
	function getBreederid(){
		return $this->breederid;
	}
	//set breederid
	function setBreederid($breederid){
		$this->breederid=$breederid;
	}

	//get area
	function getArea(){
		return $this->area;
	}
	//set area
	function setArea($area){
		$this->area=$area;
	}

	//get plants
	function getPlants(){
		return $this->plants;
	}
	//set plants
	function setPlants($plants){
		$this->plants=$plants;
	}
	//get plantedon
	function getPlantedon(){
		return $this->$plantedon;
	}
	//set plantedon
	function setPlantedon($plantedon){
		$this->plantedon=$plantedon;
	}
	//get noofbeds
	function getNoofbeds(){
		return $this->$noofbeds;
	}
	//set noofbeds
	function setNoofbeds($noofbeds){
		$this->noofbeds=$noofbeds;
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
		$greenhousevarietysDBO = new GreenhousevarietysDBO();
		if($greenhousevarietysDBO->persist($obj)){
			$this->id=$greenhousevarietysDBO->id;
			$this->sql=$greenhousevarietysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$greenhousevarietysDBO = new GreenhousevarietysDBO();
		if($greenhousevarietysDBO->update($obj,$where)){
			$this->sql=$greenhousevarietysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$greenhousevarietysDBO = new GreenhousevarietysDBO();
		if($greenhousevarietysDBO->delete($obj,$where=""))		
			$this->sql=$greenhousevarietysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$greenhousevarietysDBO = new GreenhousevarietysDBO();
		$this->table=$greenhousevarietysDBO->table;
		$greenhousevarietysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$greenhousevarietysDBO->sql;
		$this->result=$greenhousevarietysDBO->result;
		$this->fetchObject=$greenhousevarietysDBO->fetchObject;
		$this->affectedRows=$greenhousevarietysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->greenhouseid)){
			$error="Green House should be provided";
		}
		else if(empty($obj->varietyid)){
			$error="Variety should be provided";
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
