<?php 
require_once("EmployeedeductionexemptDBO.php");
class Employeedeductionexempt
{				
	var $id;			
	var $employeeid;			
	var $deductionid;			
	var $frommonth;			
	var $tomonth;			
	var $fromyear;			
	var $toyear;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeedeductionexemptDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->deductionid))
			$obj->deductionid='NULL';
		$this->deductionid=$obj->deductionid;
		$this->frommonth=str_replace("'","\'",$obj->frommonth);
		$this->tomonth=str_replace("'","\'",$obj->tomonth);
		$this->fromyear=str_replace("'","\'",$obj->fromyear);
		$this->toyear=str_replace("'","\'",$obj->toyear);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get deductionid
	function getDeductionid(){
		return $this->deductionid;
	}
	//set deductionid
	function setDeductionid($deductionid){
		$this->deductionid=$deductionid;
	}

	//get frommonth
	function getFrommonth(){
		return $this->frommonth;
	}
	//set frommonth
	function setFrommonth($frommonth){
		$this->frommonth=$frommonth;
	}

	//get tomonth
	function getTomonth(){
		return $this->tomonth;
	}
	//set tomonth
	function setTomonth($tomonth){
		$this->tomonth=$tomonth;
	}

	//get fromyear
	function getFromyear(){
		return $this->fromyear;
	}
	//set fromyear
	function setFromyear($fromyear){
		$this->fromyear=$fromyear;
	}

	//get toyear
	function getToyear(){
		return $this->toyear;
	}
	//set toyear
	function setToyear($toyear){
		$this->toyear=$toyear;
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
		$employeedeductionexemptDBO = new EmployeedeductionexemptDBO();
		if($employeedeductionexemptDBO->persist($obj)){
			$this->id=$employeedeductionexemptDBO->id;
			$this->sql=$employeedeductionexemptDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeedeductionexemptDBO = new EmployeedeductionexemptDBO();
		if($employeedeductionexemptDBO->update($obj,$where)){
			$this->sql=$employeedeductionexemptDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeedeductionexemptDBO = new EmployeedeductionexemptDBO();
		if($employeedeductionexemptDBO->delete($obj,$where=""))		
			$this->sql=$employeedeductionexemptDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeedeductionexemptDBO = new EmployeedeductionexemptDBO();
		$this->table=$employeedeductionexemptDBO->table;
		$employeedeductionexemptDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeedeductionexemptDBO->sql;
		$this->result=$employeedeductionexemptDBO->result;
		$this->fetchObject=$employeedeductionexemptDBO->fetchObject;
		$this->affectedRows=$employeedeductionexemptDBO->affectedRows;
	}
	function checkEmployeeDeductionStatus($deductionid,$employeeid,$month,$year){
	        $date=date("Y-m-d",mktime(0,0,0,$month,1,$year));
		$employeedeductionexempt = new Employeedeductionexempt();
		$where=" where employeeid='$employeeid' and deductionid='$deductionid' ";
		$fields=" concat(fromyear,'-',concat(LPAD(frommonth,2,'0'),'-','01')) fromdate, concat(toyear,'-',concat(LPAD(tomonth,2,0),'-','31')) todate ";
		$having=" having '$date' between fromdate and todate";
		$groupby="";
		$orderby="";
		$employeedeductionexempt->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $employeedeductionexempt->sql;echo "<br/>";
		if($employeedeductionexempt->affectedRows>0)
		      return true;
		else 
		      return false;

	}
	function validate($obj){
	      $fromdate=date("Y-m-d",mktime(0,0,0,$obj->frommonth,1,$obj->fromyear));
	      $todate=date("Y-m-d",mktime(0,0,0,$obj->tomonth,31,$obj->toyear));
	      $employeedeductionexempt=new Employeedeductionexempt();
	      $where=" where employeeid='$obj->employeeid' and deductionid='$obj->deductionid' ";
	      $fields=" concat(fromyear,'-',concat(LPAD(frommonth,2,'0'),'-',01)) fromdate,concat(toyear,'-',concat(LPAD(tomonth,2,0),'-',31)) todate ";
	      $join="";
	      $having=" having fromdate<='$fromdate' and todate>='$todate'  ";
	      $groupby="";
	      $orderby=" order by id desc limit 1 ";
	      $employeedeductionexempt->retrieve($fields,$join,$where,$having,$groupby,$orderby); //echo $employeedeductionexempt->sql;;
	      
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}elseif(empty($obj->frommonth)){
			$error="From Month should be provided";
		}elseif(empty($obj->tomonth)){
			$error="To month should be provided";
		}elseif(empty($obj->toyear)){
			$error="To Year should be provided";
		}elseif(empty($obj->fromyear)){
			$error="From Year should be provided";
		}elseif($employeedeductionexempt->affectedRows>0){		
		        $error="Deduduction Excemption already Exists.";
		}
		
		if(!empty($error))
			return $error;
		else 
			return null;
			
	
	}

	function validates($obj){
	       if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}elseif(empty($obj->deductionid)){
			$error="Deduduction should be provided";
		}elseif(empty($obj->frommonth)){
			$error="From Month should be provided";
		}elseif(empty($obj->tomonth)){
			$error="To month should be provided";
		}elseif(empty($obj->toyear)){
			$error="To Year should be provided";
		}elseif(empty($obj->fromyear)){
			$error="From Year should be provided";
		}
		
		if(!empty($error))
			return $error;
		else 
			return null;
	
	}
}				
?>
