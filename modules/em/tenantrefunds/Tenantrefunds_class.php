<?php 
require_once("TenantrefundsDBO.php");
class Tenantrefunds
{				
	var $id;			
	var $documentno;			
	var $tenantid;			
	var $houseid;			
	var $paymenttermid;			
	var $amount;			
	var $refundedon;			
	var $paymentmodeid;			
	var $bankid;			
	var $chequeno;			
	var $month;			
	var $year;			
	var $receivedby;			
	var $remarks;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $tenantrefundsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->tenantid=str_replace("'","\'",$obj->tenantid);
		$this->houseid=str_replace("'","\'",$obj->houseid);
		$this->paymenttermid=str_replace("'","\'",$obj->paymenttermid);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->refundedon=str_replace("'","\'",$obj->refundedon);
		$this->paymentmodeid=str_replace("'","\'",$obj->paymentmodeid);
		$this->bankid=str_replace("'","\'",$obj->bankid);
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->receivedby=str_replace("'","\'",$obj->receivedby);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get tenantid
	function getTenantid(){
		return $this->tenantid;
	}
	//set tenantid
	function setTenantid($tenantid){
		$this->tenantid=$tenantid;
	}

	//get houseid
	function getHouseid(){
		return $this->houseid;
	}
	//set houseid
	function setHouseid($houseid){
		$this->houseid=$houseid;
	}

	//get paymenttermid
	function getPaymenttermid(){
		return $this->paymenttermid;
	}
	//set paymenttermid
	function setPaymenttermid($paymenttermid){
		$this->paymenttermid=$paymenttermid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get refundedon
	function getRefundedon(){
		return $this->refundedon;
	}
	//set refundedon
	function setRefundedon($refundedon){
		$this->refundedon=$refundedon;
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

	//get receivedby
	function getReceivedby(){
		return $this->receivedby;
	}
	//set receivedby
	function setReceivedby($receivedby){
		$this->receivedby=$receivedby;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$tenantrefundsDBO = new TenantrefundsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){

			$total+=$obj->total;

			$obj->paymenttermid=$shop[$i]['paymenttermid'];
			$obj->paymenttermname=$shop[$i]['paymenttermname'];
			$obj->amount=$shop[$i]['amount'];
			$obj->houseid=$shop[$i]['houseid'];
			$obj->housename=$shop[$i]['housename'];
			$obj->month=$shop[$i]['month'];
			$obj->year=$shop[$i]['year'];
			$obj->remarks=$shop[$i]['remarks'];
			if($tenantrefundsDBO->persist($obj)){		
				$this->id=$tenantrefundsDBO->id;
				$this->sql=$tenantrefundsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$tenantrefundsDBO = new TenantrefundsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$tenantrefundsDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){

			$total+=$obj->total;

			$obj->paymenttermid=$shop['paymenttermid'];
			$obj->paymenttermname=$shop['paymenttermname'];
			$obj->amount=$shop['amount'];
			$obj->houseid=$shop['houseid'];
			$obj->housename=$shop['housename'];
			$obj->month=$shop['month'];
			$obj->year=$shop['year'];
			$obj->remarks=$shop['remarks'];
			if($tenantrefundsDBO->update($obj,$where)){
				$this->sql=$tenantrefundsDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$tenantrefundsDBO = new TenantrefundsDBO();
		if($tenantrefundsDBO->delete($obj,$where=""))		
			$this->sql=$tenantrefundsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$tenantrefundsDBO = new TenantrefundsDBO();
		$this->table=$tenantrefundsDBO->table;
		$tenantrefundsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$tenantrefundsDBO->sql;
		$this->result=$tenantrefundsDBO->result;
		$this->fetchObject=$tenantrefundsDBO->fetchObject;
		$this->affectedRows=$tenantrefundsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
