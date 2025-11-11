<?php 
require_once("EmployeepaiddeductionsDBO.php");
class Employeepaiddeductions
{				
	var $id;			
	var $employeepaymentid;			
	var $deductionid;			
	var $loanid;			
	var $employeeid;			
	var $amount;
	var $employeramount;
	var $month;			
	var $year;	
	var $reducing;
	var $paidon;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $employeepaiddeductionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeepaymentid=str_replace("'","\'",$obj->employeepaymentid);
		if(empty($obj->deductionid))
			$obj->deductionid='NULL';
		$this->deductionid=$obj->deductionid;
		if(empty($obj->loanid))
			$obj->loanid='NULL';
		$this->loanid=$obj->loanid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->reducing))
			$obj->reducing='No';
		$this->reducing=$obj->reducing;
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->employeramount=str_replace("'","\'",$obj->employeramount);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->paidon=str_replace("'","\'",$obj->paidon);
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

	//get employeepaymentid
	function getEmployeepaymentid(){
		return $this->employeepaymentid;
	}
	//set employeepaymentid
	function setEmployeepaymentid($employeepaymentid){
		$this->employeepaymentid=$employeepaymentid;
	}

	//get deductionid
	function getDeductionid(){
		return $this->deductionid;
	}
	//set deductionid
	function setDeductionid($deductionid){
		$this->deductionid=$deductionid;
	}

	//get loanid
	function getLoanid(){
		return $this->loanid;
	}
	//set loanid
	function setLoanid($loanid){
		$this->loanid=$loanid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
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

	//get paidon
	function getPaidon(){
		return $this->paidon;
	}
	//set paidon
	function setPaidon($paidon){
		$this->paidon=$paidon;
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
		$employeepaiddeductionsDBO = new EmployeepaiddeductionsDBO();
		
		
		  if($employeepaiddeductionsDBO->persist($obj)){
		  
			  //make journal entries
			  
			  $this->id=$employeepaiddeductionsDBO->id;
			  $this->sql=$employeepaiddeductionsDBO->sql;
			  return true;	
		  }
		 
	}			
	function edit($obj,$where=""){
		$employeepaiddeductionsDBO = new EmployeepaiddeductionsDBO();
		if($employeepaiddeductionsDBO->update($obj,$where)){
			$this->sql=$employeepaiddeductionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeepaiddeductionsDBO = new EmployeepaiddeductionsDBO();
		if($employeepaiddeductionsDBO->delete($obj,$where=""))		
			$this->sql=$employeepaiddeductionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeepaiddeductionsDBO = new EmployeepaiddeductionsDBO();
		$this->table=$employeepaiddeductionsDBO->table;
		$employeepaiddeductionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeepaiddeductionsDBO->sql;
		$this->result=$employeepaiddeductionsDBO->result;
		$this->fetchObject=$employeepaiddeductionsDBO->fetchObject;
		$this->affectedRows=$employeepaiddeductionsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
