<?php 
require_once("PaidrentsDBO.php");
class Paidrents
{				
	var $id;			
	var $houseid;			
	var $tenantid;			
	var $month;			
	var $year;			
	var $amount;			
	var $remarks;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $paidrentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->houseid=str_replace("'","\'",$obj->houseid);
		$this->tenantid=str_replace("'","\'",$obj->tenantid);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get tenantid
	function getTenantid(){
		return $this->tenantid;
	}
	//set tenantid
	function setTenantid($tenantid){
		$this->tenantid=$tenantid;
	}

	//get month
	function getMonth(){
		return $this->month;
	}
	//set month
	function setMonth($month){
		$this->month=$month;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
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
		$paidrentsDBO = new PaidrentsDBO();
		if($paidrentsDBO->persist($obj)){
			$this->id=$paidrentsDBO->id;
			$this->sql=$paidrentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$paidrentsDBO = new PaidrentsDBO();
		if($paidrentsDBO->update($obj,$where)){
			$this->sql=$paidrentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$paidrentsDBO = new PaidrentsDBO();
		if($paidrentsDBO->delete($obj,$where=""))		
			$this->sql=$paidrentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$paidrentsDBO = new PaidrentsDBO();
		$this->table=$paidrentsDBO->table;
		$paidrentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$paidrentsDBO->sql;
		$this->result=$paidrentsDBO->result;
		$this->fetchObject=$paidrentsDBO->fetchObject;
		$this->affectedRows=$paidrentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->houseid)){
			$error="House should be provided";
		}
		else if(empty($obj->tenantid)){
			$error="Tenant should be provided";
		}
		else if(empty($obj->month)){
			$error="Month should be provided";
		}
		else if(empty($obj->year)){
			$error="Year should be provided";
		}
		else if(empty($obj->amount)){
			$error="Amount should be provided";
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
