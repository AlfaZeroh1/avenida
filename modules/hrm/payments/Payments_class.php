<?php 
require_once("PaymentsDBO.php");
class Payments
{				
	var $id;			
	var $employeeid;			
	var $paymentmodeid;			
	var $assignmentid;			
	var $bank;			
	var $bankacc;			
	var $year;			
	var $month;			
	var $gross;			
	var $paye;			
	var $paydate;			
	var $days;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $paymentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->paymentmodeid=str_replace("'","\'",$obj->paymentmodeid);
		$this->assignmentid=str_replace("'","\'",$obj->assignmentid);
		$this->bank=str_replace("'","\'",$obj->bank);
		$this->bankacc=str_replace("'","\'",$obj->bankacc);
		$this->year=str_replace("'","\'",$obj->year);
		$this->month=str_replace("'","\'",$obj->month);
		$this->gross=str_replace("'","\'",$obj->gross);
		$this->paye=str_replace("'","\'",$obj->paye);
		$this->paydate=str_replace("'","\'",$obj->paydate);
		$this->days=str_replace("'","\'",$obj->days);
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

	//get paymentmodeid
	function getPaymentmodeid(){
		return $this->paymentmodeid;
	}
	//set paymentmodeid
	function setPaymentmodeid($paymentmodeid){
		$this->paymentmodeid=$paymentmodeid;
	}

	//get assignmentid
	function getAssignmentid(){
		return $this->assignmentid;
	}
	//set assignmentid
	function setAssignmentid($assignmentid){
		$this->assignmentid=$assignmentid;
	}

	//get bank
	function getBank(){
		return $this->bank;
	}
	//set bank
	function setBank($bank){
		$this->bank=$bank;
	}

	//get bankacc
	function getBankacc(){
		return $this->bankacc;
	}
	//set bankacc
	function setBankacc($bankacc){
		$this->bankacc=$bankacc;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get month
	function getMonth(){
		return $this->month;
	}
	//set month
	function setMonth($month){
		$this->month=$month;
	}

	//get gross
	function getGross(){
		return $this->gross;
	}
	//set gross
	function setGross($gross){
		$this->gross=$gross;
	}

	//get paye
	function getPaye(){
		return $this->paye;
	}
	//set paye
	function setPaye($paye){
		$this->paye=$paye;
	}

	//get paydate
	function getPaydate(){
		return $this->paydate;
	}
	//set paydate
	function setPaydate($paydate){
		$this->paydate=$paydate;
	}

	//get days
	function getDays(){
		return $this->days;
	}
	//set days
	function setDays($days){
		$this->days=$days;
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
		$paymentsDBO = new PaymentsDBO();
		if($paymentsDBO->persist($obj)){
			$this->id=$paymentsDBO->id;
			$this->sql=$paymentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$paymentsDBO = new PaymentsDBO();
		if($paymentsDBO->update($obj,$where)){
			$this->sql=$paymentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$paymentsDBO = new PaymentsDBO();
		if($paymentsDBO->delete($obj,$where=""))		
			$this->sql=$paymentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$paymentsDBO = new PaymentsDBO();
		$this->table=$paymentsDBO->table;
		$paymentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$paymentsDBO->sql;
		$this->result=$paymentsDBO->result;
		$this->fetchObject=$paymentsDBO->fetchObject;
		$this->affectedRows=$paymentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->paymentmodeid)){
			$error="Mode Of Payment should be provided";
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
