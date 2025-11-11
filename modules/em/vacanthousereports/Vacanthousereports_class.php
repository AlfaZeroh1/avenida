<?php 
require_once("VacanthousereportsDBO.php");
class Vacanthousereports
{				
	var $id;			
	var $houseid;			
	var $vacatedon;			
	var $remarks;			
	var $status;			
	var $remarks2;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $vacanthousereportsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->houseid=str_replace("'","\'",$obj->houseid);
		$this->vacatedon=str_replace("'","\'",$obj->vacatedon);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
		$this->remarks2=str_replace("'","\'",$obj->remarks2);
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

	//get houseid
	function getHouseid(){
		return $this->houseid;
	}
	//set houseid
	function setHouseid($houseid){
		$this->houseid=$houseid;
	}

	//get vacatedon
	function getVacatedon(){
		return $this->vacatedon;
	}
	//set vacatedon
	function setVacatedon($vacatedon){
		$this->vacatedon=$vacatedon;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get remarks2
	function getRemarks2(){
		return $this->remarks2;
	}
	//set remarks2
	function setRemarks2($remarks2){
		$this->remarks2=$remarks2;
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
		$vacanthousereportsDBO = new VacanthousereportsDBO();
		if($vacanthousereportsDBO->persist($obj)){
			$this->id=$vacanthousereportsDBO->id;
			$this->sql=$vacanthousereportsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$vacanthousereportsDBO = new VacanthousereportsDBO();
		if($vacanthousereportsDBO->update($obj,$where)){
			$this->sql=$vacanthousereportsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$vacanthousereportsDBO = new VacanthousereportsDBO();
		if($vacanthousereportsDBO->delete($obj,$where=""))		
			$this->sql=$vacanthousereportsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$vacanthousereportsDBO = new VacanthousereportsDBO();
		$this->table=$vacanthousereportsDBO->table;
		$vacanthousereportsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$vacanthousereportsDBO->sql;
		$this->result=$vacanthousereportsDBO->result;
		$this->fetchObject=$vacanthousereportsDBO->fetchObject;
		$this->affectedRows=$vacanthousereportsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
