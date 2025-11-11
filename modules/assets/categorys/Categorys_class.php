<?php 
require_once("CategorysDBO.php");
class Categorys
{				
	var $id;			
	var $name;
	var $departmentid;
	var $timemethod;			
	var $noofdepr;			
	var $endingdate;			
	var $periodlength;			
	var $computationmethod;			
	var $degressivefactor;			
	var $firstentry;
	var $type;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $categorysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		$this->timemethod=str_replace("'","\'",$obj->timemethod);
		$this->noofdepr=str_replace("'","\'",$obj->noofdepr);
		$this->endingdate=str_replace("'","\'",$obj->endingdate);
		$this->periodlength=str_replace("'","\'",$obj->periodlength);
		$this->computationmethod=str_replace("'","\'",$obj->computationmethod);
		$this->degressivefactor=str_replace("'","\'",$obj->degressivefactor);
		$this->firstentry=str_replace("'","\'",$obj->firstentry);
		$this->type=str_replace("'","\'",$obj->type);
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
		$categorysDBO = new CategorysDBO();
		if($categorysDBO->persist($obj)){
			
			//get categoryid
			$generaljournalaccounts= new Generaljournalaccounts();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where acctypeid=7 and refid='$obj->departmentid' and categoryid is null ";
			$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$generaljournalaccounts = $generaljournalaccounts->fetchObject;
			
			//add account to gj
			$gna = new Generaljournalaccounts();
			$gna->refid=$categorysDBO->id;
			$gna->categoryid=$generaljournalaccounts->id;
			$gna->acctypeid=7;
			$gna->currencyid=5;
			$gna->name=$obj->name;
			$gna = $gna->setObject($gna);
			$gna->add($gna);
			
			$this->id=$categorysDBO->id;
			$this->sql=$categorysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$categorysDBO = new CategorysDBO();
		if($categorysDBO->update($obj,$where)){
			$this->sql=$categorysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$categorysDBO = new CategorysDBO();
		if($categorysDBO->delete($obj,$where=""))		
			$this->sql=$categorysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$categorysDBO = new CategorysDBO();
		$this->table=$categorysDBO->table;
		$categorysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$categorysDBO->sql;
		$this->result=$categorysDBO->result;
		$this->fetchObject=$categorysDBO->fetchObject;
		$this->affectedRows=$categorysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Asset Category should be provided";
		}
		else if(empty($obj->timemethod)){
			$error="Time Method should be provided";
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
