<?php 
require_once("DepartmentsDBO.php");
class Departments
{				
	var $id;			
	var $name;
	var $remarks;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $departmentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
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

	//get timemethod
	function getTimemethod(){
		return $this->timemethod;
	}
	//set timemethod
	function setTimemethod($timemethod){
		$this->timemethod=$timemethod;
	}

	//get noofdepr
	function getNoofdepr(){
		return $this->noofdepr;
	}
	//set noofdepr
	function setNoofdepr($noofdepr){
		$this->noofdepr=$noofdepr;
	}

	//get endingdate
	function getEndingdate(){
		return $this->endingdate;
	}
	//set endingdate
	function setEndingdate($endingdate){
		$this->endingdate=$endingdate;
	}

	//get periodlength
	function getPeriodlength(){
		return $this->periodlength;
	}
	//set periodlength
	function setPeriodlength($periodlength){
		$this->periodlength=$periodlength;
	}

	//get computationmethod
	function getComputationmethod(){
		return $this->computationmethod;
	}
	//set computationmethod
	function setComputationmethod($computationmethod){
		$this->computationmethod=$computationmethod;
	}

	//get degressivefactor
	function getDegressivefactor(){
		return $this->degressivefactor;
	}
	//set degressivefactor
	function setDegressivefactor($degressivefactor){
		$this->degressivefactor=$degressivefactor;
	}

	//get firstentry
	function getFirstentry(){
		return $this->firstentry;
	}
	//set firstentry
	function setFirstentry($firstentry){
		$this->firstentry=$firstentry;
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
		$departmentsDBO = new DepartmentsDBO();
		if($departmentsDBO->persist($obj)){
			
			//add account to gj
			$gna = new Generaljournalaccounts();
			$gna->refid=$departmentsDBO->id;
			$gna->categoryid="";
			$gna->acctypeid=7;
			$gna->currencyid=5;
			$gna->name=$obj->name;
			$gna = $gna->setObject($gna);
			$gna->add($gna);
			
			$this->id=$departmentsDBO->id;
			$this->sql=$departmentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$departmentsDBO = new DepartmentsDBO();
		if($departmentsDBO->update($obj,$where)){
			$this->sql=$departmentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$departmentsDBO = new DepartmentsDBO();
		if($departmentsDBO->delete($obj,$where=""))		
			$this->sql=$departmentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$departmentsDBO = new DepartmentsDBO();
		$this->table=$departmentsDBO->table;
		$departmentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$departmentsDBO->sql;
		$this->result=$departmentsDBO->result;
		$this->fetchObject=$departmentsDBO->fetchObject;
		$this->affectedRows=$departmentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Asset Department should be provided";
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
