<?php 
require_once("SurchagesDBO.php");
class Surchages
{				
	var $id;			
	var $name;			
	var $amount;			
	var $remarks;			
	var $surchagetypeid;
	var $expenseid;	
	var $frommonth;			
	var $fromyear;			
	var $tomonth;			
	var $toyear;			
	var $overall;			
	var $status;
	var $taxable;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $surchagesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->surchagetypeid=str_replace("'","\'",$obj->surchagetypeid);
		$this->expenseid=str_replace("'","\'",$obj->expenseid);
		$this->frommonth=str_replace("'","\'",$obj->frommonth);
		$this->fromyear=str_replace("'","\'",$obj->fromyear);
		$this->tomonth=str_replace("'","\'",$obj->tomonth);
		$this->toyear=str_replace("'","\'",$obj->toyear);
		$this->overall=str_replace("'","\'",$obj->overall);
		$this->status=str_replace("'","\'",$obj->status);
		$this->taxable=str_replace("'","\'",$obj->taxable);
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

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get surchagetypeid
	function getSurchagetypeid(){
		return $this->surchagetypeid;
	}
	//set surchagetypeid
	function setSurchagetypeid($surchagetypeid){
		$this->surchagetypeid=$surchagetypeid;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$surchagesDBO = new SurchagesDBO();
		if($surchagesDBO->persist($obj)){
		
			$incomes = new Incomes();
			$incomes->setObject($obj);
			$incomes->add($incomes);
			
			$surchages = new Surchages();
			$fields="*";
			$where=" where id='$surchagesDBO->id'";
			$groupby="";
			$orderby="";
			$having="";
			$join="";
			$surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$surchages = $surchages->fetchObject;
			
			$all = new Surchages();
			$all->expenseid=$incomes->id;
			$all = $all->setObject($all);
			$all->edit($all);
			
			$this->id=$surchagesDBO->id;
			$this->sql=$surchagesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$surchagesDBO = new SurchagesDBO();
		if($surchagesDBO->update($obj,$where)){
			$this->sql=$surchagesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$surchagesDBO = new SurchagesDBO();
		if($surchagesDBO->delete($obj,$where=""))		
			$this->sql=$surchagesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$surchagesDBO = new SurchagesDBO();
		$this->table=$surchagesDBO->table;
		$surchagesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$surchagesDBO->sql;
		$this->result=$surchagesDBO->result;
		$this->fetchObject=$surchagesDBO->fetchObject;
		$this->affectedRows=$surchagesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
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
