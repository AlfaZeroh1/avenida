<?php 
require_once("AllowancesDBO.php");
class Allowances
{				
	var $id;			
	var $name;			
	var $amount;			
	var $percentaxable;			
	var $allowancetypeid;			
	var $expenseid;			
	var $overall;			
	var $frommonth;			
	var $fromyear;			
	var $tomonth;			
	var $toyear;			
	var $status;	
	var $noncashbenefit;
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $allowancesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->percentaxable=str_replace("'","\'",$obj->percentaxable);
		if(empty($obj->allowancetypeid))
			$obj->allowancetypeid='NULL';
		$this->allowancetypeid=$obj->allowancetypeid;
		if(empty($obj->expenseid))
			$obj->expenseid='NULL';
		$this->expenseid=$obj->expenseid;
		$this->overall=str_replace("'","\'",$obj->overall);
		$this->noncashbenefit=str_replace("'","\'",$obj->noncashbenefit);
		$this->frommonth=str_replace("'","\'",$obj->frommonth);
		$this->fromyear=str_replace("'","\'",$obj->fromyear);
		$this->tomonth=str_replace("'","\'",$obj->tomonth);
		$this->toyear=str_replace("'","\'",$obj->toyear);
		$this->status=str_replace("'","\'",$obj->status);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get percentaxable
	function getPercentaxable(){
		return $this->percentaxable;
	}
	//set percentaxable
	function setPercentaxable($percentaxable){
		$this->percentaxable=$percentaxable;
	}

	//get allowancetypeid
	function getAllowancetypeid(){
		return $this->allowancetypeid;
	}
	//set allowancetypeid
	function setAllowancetypeid($allowancetypeid){
		$this->allowancetypeid=$allowancetypeid;
	}

	//get expenseid
	function getExpenseid(){
		return $this->expenseid;
	}
	//set expenseid
	function setExpenseid($expenseid){
		$this->expenseid=$expenseid;
	}

	//get overall
	function getOverall(){
		return $this->overall;
	}
	//set overall
	function setOverall($overall){
		$this->overall=$overall;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$allowancesDBO = new AllowancesDBO();
		if($allowancesDBO->persist($obj)){
		
			$expenses = new Expenses();
			$expenses->expensetypeid=3;
			$expenses->setObject($expenses);
			$expenses->add($expenses);
			
			$allowances = new Allowances();
			$fields="*";
			$where=" where id='$allowancesDBO->id'";
			$groupby="";
			$orderby="";
			$having="";
			$join="";
			$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$allowances = $allowances->fetchObject;
			
			$all = new Allowances();
			$all->expenseid=$expenses->id;
			$all = $all->setObject($all);
			$all->edit($all);
			
			$this->id=$allowancesDBO->id;
			$this->sql=$allowancesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$allowancesDBO = new AllowancesDBO();
		if($allowancesDBO->update($obj,$where)){
			$this->sql=$allowancesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$allowancesDBO = new AllowancesDBO();
		if($allowancesDBO->delete($obj,$where=""))		
			$this->sql=$allowancesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$allowancesDBO = new AllowancesDBO();
		$this->table=$allowancesDBO->table;
		$allowancesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$allowancesDBO->sql;
		$this->result=$allowancesDBO->result;
		$this->fetchObject=$allowancesDBO->fetchObject;
		$this->affectedRows=$allowancesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Allowance should be provided";
		}
		else if(empty($obj->expenseid)){
			$error="Expense Account should be provided";
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
