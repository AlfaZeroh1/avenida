<?php 
require_once("DeductionsDBO.php");
class Deductions
{				
	var $id;			
	var $name;			
	var $deductiontypeid;			
	var $frommonth;			
	var $fromyear;			
	var $tomonth;			
	var $toyear;
	var $deductiontype;
	var $amount;
	var $epays;
	var $statement;
	var $relief;
	var $overall;
	var $taxable;
	var $liabilityid;
	var $expenseid;
	var $status;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $deductionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->deductiontypeid=str_replace("'","\'",$obj->deductiontypeid);
		$this->frommonth=str_replace("'","\'",$obj->frommonth);
		$this->fromyear=str_replace("'","\'",$obj->fromyear);
		$this->tomonth=str_replace("'","\'",$obj->tomonth);
		$this->toyear=str_replace("'","\'",$obj->toyear);
		$this->deductiontype=str_replace("'","\'",$obj->deductiontype);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->epays=str_replace("'","\'",$obj->epays);
		$this->statement=str_replace("'","\'",$obj->statement);
		$this->relief=str_replace("'","\'",$obj->relief);
		$this->taxable=str_replace("'","\'",$obj->taxable);
		
		$this->overall=str_replace("'","\'",$obj->overall);
		$this->liabilityid=str_replace("'","\'",$obj->liabilityid);
		$this->expenseid=str_replace("'","\'",$obj->expenseid);
		$this->acctypeid=str_replace("'","\'",$obj->acctypeid);
		$this->status=str_replace("'","\'",$obj->status);
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
	
	//get epays
	function getEpays(){
		return $this->epays;
	}
	//set epays
	function setEpays($epays){
		$this->epays=$epays;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get deductiontypeid
	function getDeductiontypeid(){
		return $this->deductiontypeid;
	}
	//set deductiontypeid
	function setDeductiontypeid($deductiontypeid){
		$this->deductiontypeid=$deductiontypeid;
	}

	//get frommonth
	function getFrommonth(){
		return $this->frommonth;
	}
	//set frommonth
	function setFrommonth($frommonth){
		$this->frommonth=$frommonth;
	}

	//get fromyear
	function getFromyear(){
		return $this->fromyear;
	}
	//set fromyear
	function setFromyear($fromyear){
		$this->fromyear=$fromyear;
	}

	//get tomonth
	function getTomonth(){
		return $this->tomonth;
	}
	//set tomonth
	function setTomonth($tomonth){
		$this->tomonth=$tomonth;
	}

	//get toyear
	function getToyear(){
		return $this->toyear;
	}
	//set toyear
	function setToyear($toyear){
		$this->toyear=$toyear;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get overall
	function getOverall(){
		return $this->overall;
	}
	//set overall
	function setOverall($overall){
		$this->overall=$overall;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		$deductionsDBO = new DeductionsDBO();
		if($deductionsDBO->persist($obj)){
		
			//Add a liability account
			$liabilitys= new Liabilitys();
			$liabilitys->name=$obj->name;
			$liabilitys = $liabilitys->setObject($incomes);
			$liabilitys->add($liabilitys);
			
			$deductions = new Deductions();
			$fields = "*";
			$fields="*";
			$where=" where id='$loansDBO->id'";
			$groupby="";
			$orderby="";
			$having="";
			$join="";
			$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$deductions = $deductions->fetchObject;
			
			$ded = new Deductions();
			$deductions->liabilityid=$liabilitys->id;
			$deductions->acctypeid=1;
			$ded = $ded->setObject($deductions);
			$ded->edit($ded);
			
			$this->id=$deductionsDBO->id;
			$this->sql=$deductionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$deductionsDBO = new DeductionsDBO();
		if($deductionsDBO->update($obj,$where)){
			$this->sql=$deductionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$deductionsDBO = new DeductionsDBO();
		if($deductionsDBO->delete($obj,$where=""))		
			$this->sql=$deductionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$deductionsDBO = new DeductionsDBO();
		$this->table=$deductionsDBO->table;
		$deductionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$deductionsDBO->sql;
		$this->result=$deductionsDBO->result;
		$this->fetchObject=$deductionsDBO->fetchObject;
		$this->affectedRows=$deductionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Deduction should be provided";
		}
		else if(empty($obj->deductiontypeid)){
			$error="Deduction Type should be provided";
		}
		else if(empty($obj->epays)){
			$error="epays";
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
