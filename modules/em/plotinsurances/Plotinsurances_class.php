<?php 
require_once("PlotinsurancesDBO.php");
class Plotinsurances
{				
	var $id;			
	var $plotid;			
	var $company;			
	var $startdate;			
	var $expirydate;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $plotinsurancesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->plotid))
			$obj->plotid='NULL';
		$this->plotid=$obj->plotid;
		$this->company=str_replace("'","\'",$obj->company);
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->expirydate=str_replace("'","\'",$obj->expirydate);
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

	//get plotid
	function getPlotid(){
		return $this->plotid;
	}
	//set plotid
	function setPlotid($plotid){
		$this->plotid=$plotid;
	}

	//get company
	function getCompany(){
		return $this->company;
	}
	//set company
	function setCompany($company){
		$this->company=$company;
	}

	//get startdate
	function getStartdate(){
		return $this->startdate;
	}
	//set startdate
	function setStartdate($startdate){
		$this->startdate=$startdate;
	}

	//get expirydate
	function getExpirydate(){
		return $this->expirydate;
	}
	//set expirydate
	function setExpirydate($expirydate){
		$this->expirydate=$expirydate;
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
		$plotinsurancesDBO = new PlotinsurancesDBO();
		if($plotinsurancesDBO->persist($obj)){
			$this->id=$plotinsurancesDBO->id;
			$this->sql=$plotinsurancesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$plotinsurancesDBO = new PlotinsurancesDBO();
		if($plotinsurancesDBO->update($obj,$where)){
			$this->sql=$plotinsurancesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$plotinsurancesDBO = new PlotinsurancesDBO();
		if($plotinsurancesDBO->delete($obj,$where=""))		
			$this->sql=$plotinsurancesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$plotinsurancesDBO = new PlotinsurancesDBO();
		$this->table=$plotinsurancesDBO->table;
		$plotinsurancesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$plotinsurancesDBO->sql;
		$this->result=$plotinsurancesDBO->result;
		$this->fetchObject=$plotinsurancesDBO->fetchObject;
		$this->affectedRows=$plotinsurancesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->plotid)){
			$error="Plot should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->plotid)){
			$error="Plot should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
