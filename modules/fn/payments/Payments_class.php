<?php 
require_once("PaymentsDBO.php");
class Payments
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $acctypeid;			
	var $ipaddress;			
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
		$this->name=str_replace("'","\'",$obj->name);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		if(empty($obj->acctypeid))
			$obj->acctypeid='NULL';
		$this->acctypeid=$obj->acctypeid;
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

	//get acctypeid
	function getAcctypeid(){
		return $this->acctypeid;
	}
	//set acctypeid
	function setAcctypeid($acctypeid){
		$this->acctypeid=$acctypeid;
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
		if(empty($obj->name)){
			$error="Other Payment should be provided";
		}
		else if(empty($obj->acctypeid)){
			$error="Other Payments should be provided";
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
