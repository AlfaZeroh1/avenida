<?php 
require_once("PaymentcategorysDBO.php");
class Paymentcategorys
{				
	var $id;			
	var $paymentmodeid;			
	var $name;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $paymentcategorysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		$this->name=str_replace("'","\'",$obj->name);
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

	//get paymentmodeid
	function getPaymentmodeid(){
		return $this->paymentmodeid;
	}
	//set paymentmodeid
	function setPaymentmodeid($paymentmodeid){
		$this->paymentmodeid=$paymentmodeid;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
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
		$paymentcategorysDBO = new PaymentcategorysDBO();
		if($paymentcategorysDBO->persist($obj)){
			
			$gna = new Generaljournalaccounts();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$where=" where refid='$obj->paymentmodeid' and acctypeid=29";
			$orderby="";
			$gna->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$gna = $gna->fetchObject;
			
			$obj->categoryid=$gna->id;			
			
			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name;
			$obj->id="";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$customers->id;
			$obj->acctypeid=29;			
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
			
			$this->id=$paymentcategorysDBO->id;
			$this->sql=$paymentcategorysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$paymentcategorysDBO = new PaymentcategorysDBO();
		if($paymentcategorysDBO->update($obj,$where)){
			$this->sql=$paymentcategorysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$paymentcategorysDBO = new PaymentcategorysDBO();
		if($paymentcategorysDBO->delete($obj,$where=""))		
			$this->sql=$paymentcategorysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$paymentcategorysDBO = new PaymentcategorysDBO();
		$this->table=$paymentcategorysDBO->table;
		$paymentcategorysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$paymentcategorysDBO->sql;
		$this->result=$paymentcategorysDBO->result;
		$this->fetchObject=$paymentcategorysDBO->fetchObject;
		$this->affectedRows=$paymentcategorysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
		else if(empty($obj->name)){
			$error="Category Name should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
