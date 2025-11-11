<?php 
require_once("PaymentvoucherdetailsDBO.php");
class Paymentvoucherdetails
{				
	var $id;			
	var $paymentvoucherid;			
	var $cashrequisitionid;			
	var $paymentrequisitionid;			
	var $amount;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $paymentvoucherdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->paymentvoucherid))
			$obj->paymentvoucherid='NULL';
		$this->paymentvoucherid=$obj->paymentvoucherid;
		if(empty($obj->cashrequisitionid))
			$obj->cashrequisitionid='NULL';
		$this->cashrequisitionid=$obj->cashrequisitionid;
		if(empty($obj->paymentrequisitionid))
			$obj->paymentrequisitionid='NULL';
		$this->paymentrequisitionid=$obj->paymentrequisitionid;
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

	//get paymentvoucherid
	function getPaymentvoucherid(){
		return $this->paymentvoucherid;
	}
	//set paymentvoucherid
	function setPaymentvoucherid($paymentvoucherid){
		$this->paymentvoucherid=$paymentvoucherid;
	}

	//get cashrequisitionid
	function getCashrequisitionid(){
		return $this->cashrequisitionid;
	}
	//set cashrequisitionid
	function setCashrequisitionid($cashrequisitionid){
		$this->cashrequisitionid=$cashrequisitionid;
	}

	//get paymentrequisitionid
	function getPaymentrequisitionid(){
		return $this->paymentrequisitionid;
	}
	//set paymentrequisitionid
	function setPaymentrequisitionid($paymentrequisitionid){
		$this->paymentrequisitionid=$paymentrequisitionid;
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

	function add($obj,$shop){
		$paymentvoucherdetailsDBO = new PaymentvoucherdetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->cashrequisitionid=$shop[$i]['cashrequisitionid'];
			$obj->cashrequisitionname=$shop[$i]['cashrequisitionname'];
			$obj->paymentrequisitionid=$shop[$i]['paymentrequisitionid'];
			$obj->paymentrequisitionname=$shop[$i]['paymentrequisitionname'];
			$obj->amount=$shop[$i]['amount'];
			$obj->remarks=$shop[$i]['remarks'];
			if($paymentvoucherdetailsDBO->persist($obj)){		
				$this->id=$paymentvoucherdetailsDBO->id;
				$this->sql=$paymentvoucherdetailsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where=""){
		$paymentvoucherdetailsDBO = new PaymentvoucherdetailsDBO();
		if($paymentvoucherdetailsDBO->update($obj,$where)){
			$this->sql=$paymentvoucherdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$paymentvoucherdetailsDBO = new PaymentvoucherdetailsDBO();
		if($paymentvoucherdetailsDBO->delete($obj,$where=""))		
			$this->sql=$paymentvoucherdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$paymentvoucherdetailsDBO = new PaymentvoucherdetailsDBO();
		$this->table=$paymentvoucherdetailsDBO->table;
		$paymentvoucherdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$paymentvoucherdetailsDBO->sql;
		$this->result=$paymentvoucherdetailsDBO->result;
		$this->fetchObject=$paymentvoucherdetailsDBO->fetchObject;
		$this->affectedRows=$paymentvoucherdetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->paymentvoucherid)){
			$error="Payment Voucher should be provided";
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
		if(empty($obj->amount)){
			$error="Amount should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
