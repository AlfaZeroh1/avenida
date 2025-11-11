<?php 
require_once("OrderpaymentsDBO.php");
class Orderpayments
{				
	var $id;
	var $documentno;
	var $orderid;	
	var $billno;
	var $paidon;			
	var $amount;			
	var $amountgiven;
	var $paymentmodeid;
	var $imprestaccountid;
	var $paymentcategoryid;
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $orderpaymentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=$obj->documentno;
		$this->orderid=str_replace("'","\'",$obj->orderid);
		$this->billno=str_replace("'","\'",$obj->billno);
		$this->paidon=str_replace("'","\'",$obj->paidon);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->amountgiven=str_replace("'","\'",$obj->amountgiven);
		
		if($this->amountgiven<$this->amount)
		  $this->amount=$this->amountgiven;
		
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		
		if(empty($obj->imprestaccountid))
			$obj->imprestaccountid='NULL';
		$this->imprestaccountid=$obj->imprestaccountid;
		
		if(empty($obj->paymentcategoryid))
			$obj->paymentcategoryid='NULL';
		$this->paymentcategoryid=$obj->paymentcategoryid;
		
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

	//get orderid
	function getOrderid(){
		return $this->orderid;
	}
	//set orderid
	function setOrderid($orderid){
		$this->orderid=$orderid;
	}

	//get paidon
	function getPaidon(){
		return $this->paidon;
	}
	//set paidon
	function setPaidon($paidon){
		$this->paidon=$paidon;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get amountgiven
	function getAmountgiven(){
		return $this->amountgiven;
	}
	//set amountgiven
	function setAmountgiven($amountgiven){
		$this->amountgiven=$amountgiven;
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
		$orderpaymentsDBO = new OrderpaymentsDBO();
		if($orderpaymentsDBO->persist($obj)){
			$this->id=$orderpaymentsDBO->id;
			$this->sql=$orderpaymentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$orderpaymentsDBO = new OrderpaymentsDBO();
		if($orderpaymentsDBO->update($obj,$where)){
			$this->sql=$orderpaymentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$orderpaymentsDBO = new OrderpaymentsDBO();
		if($orderpaymentsDBO->delete($obj,$where=""))		
			$this->sql=$orderpaymentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$orderpaymentsDBO = new OrderpaymentsDBO();
		$this->table=$orderpaymentsDBO->table;
		$orderpaymentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$orderpaymentsDBO->sql;
		$this->result=$orderpaymentsDBO->result;
		$this->fetchObject=$orderpaymentsDBO->fetchObject;
		$this->affectedRows=$orderpaymentsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
