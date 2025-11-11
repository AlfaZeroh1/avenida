<?php 
require_once("PaymentvouchersDBO.php");
require_once("../paymentvoucherdetails/PaymentvoucherdetailsDBO.php");
class Paymentvouchers
{				
	var $id;			
	var $documentno;			
	var $voucherno;			
	var $voucherdate;			
	var $payee;			
	var $paymentmodeid;			
	var $bankid;			
	var $chequeno;			
	var $chequedate;			
	var $remarks;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $paymentvouchersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->voucherno=str_replace("'","\'",$obj->voucherno);
		$this->voucherdate=str_replace("'","\'",$obj->voucherdate);
		$this->payee=str_replace("'","\'",$obj->payee);
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->chequedate=str_replace("'","\'",$obj->chequedate);
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

	//get voucherno
	function getVoucherno(){
		return $this->voucherno;
	}
	//set voucherno
	function setVoucherno($voucherno){
		$this->voucherno=$voucherno;
	}

	//get voucherdate
	function getVoucherdate(){
		return $this->voucherdate;
	}
	//set voucherdate
	function setVoucherdate($voucherdate){
		$this->voucherdate=$voucherdate;
	}

	//get payee
	function getPayee(){
		return $this->payee;
	}
	//set payee
	function setPayee($payee){
		$this->payee=$payee;
	}

	//get paymentmodeid
	function getPaymentmodeid(){
		return $this->paymentmodeid;
	}
	//set paymentmodeid
	function setPaymentmodeid($paymentmodeid){
		$this->paymentmodeid=$paymentmodeid;
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

	//get chequedate
	function getChequedate(){
		return $this->chequedate;
	}
	//set chequedate
	function setChequedate($chequedate){
		$this->chequedate=$chequedate;
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

	function add($obj,$shop){
		$paymentvouchersDBO = new PaymentvouchersDBO();
			if($paymentvouchersDBO->persist($obj)){		
				$paymentvoucherdetails = new Paymentvoucherdetails();
				$obj->paymentvoucherid=$paymentvouchersDBO->id;
				$paymentvoucherdetails->add($obj,$shop);

				$this->id=$paymentvouchersDBO->id;
				$this->sql=$paymentvouchersDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$paymentvouchersDBO = new PaymentvouchersDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$paymentvouchersDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->cashrequisitionid=$shop['cashrequisitionid'];
			$obj->paymentrequisitionid=$shop['paymentrequisitionid'];
			$obj->amount=$shop['amount'];
			$obj->remarks=$shop['remarks'];
			if($paymentvouchersDBO->update($obj,$where)){
				$this->sql=$paymentvouchersDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$paymentvouchersDBO = new PaymentvouchersDBO();
		if($paymentvouchersDBO->delete($obj,$where=""))		
			$this->sql=$paymentvouchersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$paymentvouchersDBO = new PaymentvouchersDBO();
		$this->table=$paymentvouchersDBO->table;
		$paymentvouchersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$paymentvouchersDBO->sql;
		$this->result=$paymentvouchersDBO->result;
		$this->fetchObject=$paymentvouchersDBO->fetchObject;
		$this->affectedRows=$paymentvouchersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Document No should be provided";
		}
		else if(empty($obj->voucherno)){
			$error="Payment Voucher No should be provided";
		}
		else if(empty($obj->voucherdate)){
			$error="Voucher Date should be provided";
		}
		else if(empty($obj->payee)){
			$error="Payee should be provided";
		}
		else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
		else if(empty($obj->status)){
			$error="Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Document No should be provided";
		}
		else if(empty($obj->voucherno)){
			$error="Payment Voucher No should be provided";
		}
		else if(empty($obj->voucherdate)){
			$error="Voucher Date should be provided";
		}
		else if(empty($obj->payee)){
			$error="Payee should be provided";
		}
		else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
		else if(empty($obj->status)){
			$error="Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
