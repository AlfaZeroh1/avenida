<?php 
require_once("EmployeeloansDBO.php");
class Employeeloans
{				
	var $id;			
	var $loanid;			
	var $employeeid;			
	var $principal;			
	var $method;			
	var $initialvalue;			
	var $payable;			
	var $duration;			
	var $interesttype;			
	var $interest;			
	var $month;			
	var $year;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $employeeloansDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->loanid))
			$obj->loanid='NULL';
		$this->loanid=$obj->loanid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->principal=str_replace("'","\'",$obj->principal);
		$this->method=str_replace("'","\'",$obj->method);
		$this->initialvalue=str_replace("'","\'",$obj->initialvalue);
		$this->payable=str_replace("'","\'",$obj->payable);
		$this->duration=str_replace("'","\'",$obj->duration);
		$this->interesttype=str_replace("'","\'",$obj->interesttype);
		$this->interest=str_replace("'","\'",$obj->interest);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
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

	//get principal
	function getPrincipal(){
		return $this->principal;
	}
	//set principal
	function setPrincipal($principal){
		$this->principal=$principal;
	}

	//get method
	function getMethod(){
		return $this->method;
	}
	//set method
	function setMethod($method){
		$this->method=$method;
	}

	//get initialvalue
	function getInitialvalue(){
		return $this->initialvalue;
	}
	//set initialvalue
	function setInitialvalue($initialvalue){
		$this->initialvalue=$initialvalue;
	}

	//get payable
	function getPayable(){
		return $this->payable;
	}
	//set payable
	function setPayable($payable){
		$this->payable=$payable;
	}

	//get duration
	function getDuration(){
		return $this->duration;
	}
	//set duration
	function setDuration($duration){
		$this->duration=$duration;
	}

	//get interesttype
	function getInteresttype(){
		return $this->interesttype;
	}
	//set interesttype
	function setInteresttype($interesttype){
		$this->interesttype=$interesttype;
	}

	//get interest
	function getInterest(){
		return $this->interest;
	}
	//set interest
	function setInterest($interest){
		$this->interest=$interest;
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
		$employeeloansDBO = new EmployeeloansDBO();
		if($employeeloansDBO->persist($obj)){
			$this->id=$employeeloansDBO->id;
			$this->sql=$employeeloansDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeeloansDBO = new EmployeeloansDBO();
		if($employeeloansDBO->update($obj,$where)){
			$this->sql=$employeeloansDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeeloansDBO = new EmployeeloansDBO();
		if($employeeloansDBO->delete($obj,$where=""))		
			$this->sql=$employeeloansDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeeloansDBO = new EmployeeloansDBO();
		$this->table=$employeeloansDBO->table;
		$employeeloansDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeeloansDBO->sql;
		$this->result=$employeeloansDBO->result;
		$this->fetchObject=$employeeloansDBO->fetchObject;
		$this->affectedRows=$employeeloansDBO->affectedRows;
	}			
	function validate($obj){
	        $employeeloans=new Employeeloans();
	        $fields=" * ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where employeeid='$obj->employeeid' and loanid='$obj->loanid' and principal>0 ";
		$employeeloans->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeeloans->sql;
		$res=$employeeloans->affectedRows;//echo $res.'dddddddd';
	        
		if(empty($obj->loanid)){
			$error="Loan should be provided";
		}
		elseif(empty($obj->employeeid)){
			$error="Employee should be provided";
		}elseif(empty($obj->principal)){
			$error="Principal should be provided";
		}elseif(empty($obj->method)){
			$error="Method should be provided";
		}elseif(empty($obj->initialvalue)){
			$error="Initialvalue should be provided";
		}elseif(empty($obj->payable)){
			$error="Payable should be provided";
		}elseif(empty($obj->duration)){
			$error="Duration should be provided";
		}elseif(empty($obj->interesttype)){
			$error="Interesttype should be provided";
		}elseif(empty($obj->interest)){
			$error="Interest should be provided";
		}elseif(empty($obj->month)){
			$error="Month should be provided";
		}elseif(empty($obj->year)){
			$error="Year should be provided";
		}elseif($res>0){
			$error="The employee has a loan not yet fully repaid";
		}
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	$employeeloans=new Employeeloans();
	        
		if(empty($obj->loanid)){
			$error="Loan should be provided";
		}
		elseif(empty($obj->employeeid)){
			$error="Employee should be provided";
		}elseif(empty($obj->principal)){
			$error="Principal should be provided";
		}elseif(empty($obj->method)){
			$error="Method should be provided";
		}elseif(empty($obj->initialvalue)){
			$error="Initialvalue should be provided";
		}elseif(empty($obj->payable)){
			$error="Payable should be provided";
		}elseif(empty($obj->duration)){
			$error="Duration should be provided";
		}elseif(empty($obj->interesttype)){
			$error="Interesttype should be provided";
		}elseif(empty($obj->interest)){
			$error="Interest should be provided";
		}elseif(empty($obj->month)){
			$error="Month should be provided";
		}elseif(empty($obj->year)){
			$error="Year should be provided";
		}
		if(!empty($error))
			return $error;
		else
			return null;
	}
}				
?>
