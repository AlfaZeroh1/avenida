<?php 
require_once("SpecialemployeesDBO.php");
class Specialemployees
{				
	var $id;			
	var $employeeid;			
	var $paye;			
	var $nhif;			
	var $nssf;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $specialemployeesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->paye=str_replace("'","\'",$obj->paye);
		$this->nhif=str_replace("'","\'",$obj->nhif);
		$this->nssf=str_replace("'","\'",$obj->nssf);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get paye
	function getPaye(){
		return $this->paye;
	}
	//set paye
	function setPaye($paye){
		$this->paye=$paye;
	}

	//get nhif
	function getNhif(){
		return $this->nhif;
	}
	//set nhif
	function setNhif($nhif){
		$this->nhif=$nhif;
	}

	//get nssf
	function getNssf(){
		return $this->nssf;
	}
	//set nssf
	function setNssf($nssf){
		$this->nssf=$nssf;
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
		$specialemployeesDBO = new SpecialemployeesDBO();
		if($specialemployeesDBO->persist($obj)){
			$this->id=$specialemployeesDBO->id;
			$this->sql=$specialemployeesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$specialemployeesDBO = new SpecialemployeesDBO();
		if($specialemployeesDBO->update($obj,$where)){
			$this->sql=$specialemployeesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$specialemployeesDBO = new SpecialemployeesDBO();
		if($specialemployeesDBO->delete($obj,$where=""))		
			$this->sql=$specialemployeesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$specialemployeesDBO = new SpecialemployeesDBO();
		$this->table=$specialemployeesDBO->table;
		$specialemployeesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$specialemployeesDBO->sql;
		$this->result=$specialemployeesDBO->result;
		$this->fetchObject=$specialemployeesDBO->fetchObject;
		$this->affectedRows=$specialemployeesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
