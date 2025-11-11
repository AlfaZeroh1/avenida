<?php 
require_once("PotentialcustomervisitsDBO.php");
class Potentialcustomervisits
{				
	var $id;			
	var $potentialcustomerid;			
	var $vistedon;			
	var $employeeid;			
	var $findings;			
	var $recommendations;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $potentialcustomervisitsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->potentialcustomerid))
			$obj->potentialcustomerid='NULL';
		$this->potentialcustomerid=$obj->potentialcustomerid;
		$this->vistedon=str_replace("'","\'",$obj->vistedon);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->findings=str_replace("'","\'",$obj->findings);
		$this->recommendations=str_replace("'","\'",$obj->recommendations);
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

	//get potentialcustomerid
	function getPotentialcustomerid(){
		return $this->potentialcustomerid;
	}
	//set potentialcustomerid
	function setPotentialcustomerid($potentialcustomerid){
		$this->potentialcustomerid=$potentialcustomerid;
	}

	//get vistedon
	function getVistedon(){
		return $this->vistedon;
	}
	//set vistedon
	function setVistedon($vistedon){
		$this->vistedon=$vistedon;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get findings
	function getFindings(){
		return $this->findings;
	}
	//set findings
	function setFindings($findings){
		$this->findings=$findings;
	}

	//get recommendations
	function getRecommendations(){
		return $this->recommendations;
	}
	//set recommendations
	function setRecommendations($recommendations){
		$this->recommendations=$recommendations;
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
		$potentialcustomervisitsDBO = new PotentialcustomervisitsDBO();
		if($potentialcustomervisitsDBO->persist($obj)){
			$this->id=$potentialcustomervisitsDBO->id;
			$this->sql=$potentialcustomervisitsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$potentialcustomervisitsDBO = new PotentialcustomervisitsDBO();
		if($potentialcustomervisitsDBO->update($obj,$where)){
			$this->sql=$potentialcustomervisitsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$potentialcustomervisitsDBO = new PotentialcustomervisitsDBO();
		if($potentialcustomervisitsDBO->delete($obj,$where=""))		
			$this->sql=$potentialcustomervisitsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$potentialcustomervisitsDBO = new PotentialcustomervisitsDBO();
		$this->table=$potentialcustomervisitsDBO->table;
		$potentialcustomervisitsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$potentialcustomervisitsDBO->sql;
		$this->result=$potentialcustomervisitsDBO->result;
		$this->fetchObject=$potentialcustomervisitsDBO->fetchObject;
		$this->affectedRows=$potentialcustomervisitsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->potentialcustomerid)){
			$error="Customer should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Visited By should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->employeeid)){
			$error="Visited By should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
