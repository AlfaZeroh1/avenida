<?php 
require_once("PaymentrequisitionsDBO.php");
class Paymentrequisitions
{				
	var $id;			
	var $documentno;			
	var $supplierid;			
	var $invoicenos;			
	var $amount;			
	var $requisitiondate;			
	var $remarks;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $paymentrequisitionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		$this->invoicenos=str_replace("'","\'",$obj->invoicenos);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->requisitiondate=str_replace("'","\'",$obj->requisitiondate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get invoicenos
	function getInvoicenos(){
		return $this->invoicenos;
	}
	//set invoicenos
	function setInvoicenos($invoicenos){
		$this->invoicenos=$invoicenos;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get requisitiondate
	function getRequisitiondate(){
		return $this->requisitiondate;
	}
	//set requisitiondate
	function setRequisitiondate($requisitiondate){
		$this->requisitiondate=$requisitiondate;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		$paymentrequisitionsDBO = new PaymentrequisitionsDBO();
		if($paymentrequisitionsDBO->persist($obj)){
			//$this->id=$paymentrequisitionsDBO->id;
			$this->sql=$paymentrequisitionsDBO->sql;
			
			$obj->workflow=1;
			$obj->routeid=3;
			$obj->ownerid=$_SESSION['userid'];
			$obj->name="Payment Requisition Approval #". $obj->documentno." PV No:".$obj->paymentvoucherno;
			$obj->projectid-$obj->projectid;
			$obj->projecttype="Payment Requisition";
			$obj->assignmentid=$obj->assignmentid;
			$obj->employeeid=$obj->employeeid;
			$obj->documenttype="Payment Requisition";
			$obj->documentno=$obj->documentno;
			$obj->tracktime="Yes";
			$obj->reqduration=$routedetails->expectedduration;
			$obj->reqdurationtype=$routedetails->durationtype;
			$obj->createdby=$_SESSION['userid'];
			$obj->createdon=date("Y-m-d H:i:s");
			$obj->lasteditedby=$_SESSION['userid'];
			$obj->lasteditedon=date("Y-m-d H:i:s");
			$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
			$obj->statusid=1;
			$obj->subject="Payment Requisition Approval #". $obj->documentno." PV No:".$obj->paymentvoucherno;
			$obj->body="A Requisition has been raised that requires your attention";
			
			$tasks = new Tasks();
			$tasks->processTask($obj);
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$paymentrequisitionsDBO = new PaymentrequisitionsDBO();
		if($paymentrequisitionsDBO->update($obj,$where)){
			$this->sql=$paymentrequisitionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$paymentrequisitionsDBO = new PaymentrequisitionsDBO();
		if($paymentrequisitionsDBO->delete($obj,$where=""))		
			$this->sql=$paymentrequisitionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$paymentrequisitionsDBO = new PaymentrequisitionsDBO();
		$this->table=$paymentrequisitionsDBO->table;
		$paymentrequisitionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$paymentrequisitionsDBO->sql;
		$this->result=$paymentrequisitionsDBO->result;
		$this->fetchObject=$paymentrequisitionsDBO->fetchObject;
		$this->affectedRows=$paymentrequisitionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Requsition No should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Requsition No should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
