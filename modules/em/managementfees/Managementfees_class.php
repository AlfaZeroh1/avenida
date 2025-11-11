<?php 
require_once("ManagementfeesDBO.php");
class Managementfees
{				
	var $id;			
	var $clientid;			
	var $clienttype;			
	var $paymenttermid;			
	var $perc;			
	var $vatclasseid;			
	var $vatamount;			
	var $amount;			
	var $total;			
	var $month;			
	var $year;			
	var $chargedon;			
	var $remarks;							
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;		
	var $managementfeesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->clientid=str_replace("'","\'",$obj->clientid);
		$this->clienttype=str_replace("'","\'",$obj->clienttype);
		$this->paymenttermid=str_replace("'","\'",$obj->paymenttermid);
		$this->perc=str_replace("'","\'",$obj->perc);
		$this->vatclasseid=str_replace("'","\'",$obj->vatclasseid);
		$this->vatamount=str_replace("'","\'",$obj->vatamount);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->total=str_replace("'","\'",$obj->total);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->chargedon=str_replace("'","\'",$obj->chargedon);
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

	//get clientid
	function getClientid(){
		return $this->clientid;
	}
	//set clientid
	function setClientid($clientid){
		$this->clientid=$clientid;
	}

	//get clienttype
	function getClienttype(){
		return $this->clienttype;
	}
	//set clienttype
	function setClienttype($clienttype){
		$this->clienttype=$clienttype;
	}

	//get paymenttermid
	function getPaymenttermid(){
		return $this->paymenttermid;
	}
	//set paymenttermid
	function setPaymenttermid($paymenttermid){
		$this->paymenttermid=$paymenttermid;
	}

	//get perc
	function getPerc(){
		return $this->perc;
	}
	//set perc
	function setPerc($perc){
		$this->perc=$perc;
	}

	//get vatclasseid
	function getVatclasseid(){
		return $this->vatclasseid;
	}
	//set vatclasseid
	function setVatclasseid($vatclasseid){
		$this->vatclasseid=$vatclasseid;
	}

	//get vatamount
	function getVatamount(){
		return $this->vatamount;
	}
	//set vatamount
	function setVatamount($vatamount){
		$this->vatamount=$vatamount;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
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

	//get chargedon
	function getChargedon(){
		return $this->chargedon;
	}
	//set chargedon
	function setChargedon($chargedon){
		$this->chargedon=$chargedon;
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
		$managementfeesDBO = new ManagementfeesDBO();
		if($managementfeesDBO->persist($obj)){
			$this->id=$managementfeesDBO->id;
			$this->sql=$managementfeesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$managementfeesDBO = new ManagementfeesDBO();
		if($managementfeesDBO->update($obj,$where)){
			$this->sql=$managementfeesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$managementfeesDBO = new ManagementfeesDBO();
		if($managementfeesDBO->delete($obj,$where=""))		
			$this->sql=$managementfeesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$managementfeesDBO = new ManagementfeesDBO();
		$this->table=$managementfeesDBO->table;
		$managementfeesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$managementfeesDBO->sql;
		$this->result=$managementfeesDBO->result;
		$this->fetchObject=$managementfeesDBO->fetchObject;
		$this->affectedRows=$managementfeesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
