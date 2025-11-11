<?php 
require_once("TschedulesexpensesDBO.php");
class Tschedulesexpenses
{				
	var $id;			
	var $tscheduleid;			
	var $expenseid;			
	var $paidthru;			
	var $bankid;			
	var $chequeno;			
	var $amount;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $tschedulesexpensesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->tscheduleid=str_replace("'","\'",$obj->tscheduleid);
		$this->expenseid=str_replace("'","\'",$obj->expenseid);
		$this->paidthru=str_replace("'","\'",$obj->paidthru);
		$this->bankid=str_replace("'","\'",$obj->bankid);
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->amount=str_replace("'","\'",$obj->amount);
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

	//get tscheduleid
	function getTscheduleid(){
		return $this->tscheduleid;
	}
	//set tscheduleid
	function setTscheduleid($tscheduleid){
		$this->tscheduleid=$tscheduleid;
	}

	//get expenseid
	function getExpenseid(){
		return $this->expenseid;
	}
	//set expenseid
	function setExpenseid($expenseid){
		$this->expenseid=$expenseid;
	}

	//get paidthru
	function getPaidthru(){
		return $this->paidthru;
	}
	//set paidthru
	function setPaidthru($paidthru){
		$this->paidthru=$paidthru;
	}

	//get bankid
	function getBankid(){
		return $this->bankid;
	}
	//set bankid
	function setBankid($bankid){
		$this->bankid=$bankid;
	}

	//get chequeno
	function getChequeno(){
		return $this->chequeno;
	}
	//set chequeno
	function setChequeno($chequeno){
		$this->chequeno=$chequeno;
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
		$tschedulesexpensesDBO = new TschedulesexpensesDBO();
		if($tschedulesexpensesDBO->persist($obj)){
			$this->id=$tschedulesexpensesDBO->id;
			$this->sql=$tschedulesexpensesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$tschedulesexpensesDBO = new TschedulesexpensesDBO();
		if($tschedulesexpensesDBO->update($obj,$where)){
			$this->sql=$tschedulesexpensesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$tschedulesexpensesDBO = new TschedulesexpensesDBO();
		if($tschedulesexpensesDBO->delete($obj,$where=""))		
			$this->sql=$tschedulesexpensesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$tschedulesexpensesDBO = new TschedulesexpensesDBO();
		$this->table=$tschedulesexpensesDBO->table;
		$tschedulesexpensesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$tschedulesexpensesDBO->sql;
		$this->result=$tschedulesexpensesDBO->result;
		$this->fetchObject=$tschedulesexpensesDBO->fetchObject;
		$this->affectedRows=$tschedulesexpensesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->id)){
			$error=" should be provided";
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
