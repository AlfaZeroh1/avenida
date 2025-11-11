<?php 
require_once("PayablesDBO.php");
class Payables
{				
	var $id;			
	var $documentno;			
	var $patientid;			
	var $transactionid;			
	var $treatmentno;			
	var $amount;			
	var $remarks;			
	var $invoicedon;			
	var $consult;			
	var $paid;	
	var $departmentid;
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $payablesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->patientid))
			$obj->patientid='NULL';
		$this->patientid=$obj->patientid;
		if(empty($obj->transactionid))
			$obj->transactionid='NULL';
		$this->transactionid=$obj->transactionid;
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		$this->treatmentno=str_replace("'","\'",$obj->treatmentno);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->invoicedon=str_replace("'","\'",$obj->invoicedon);
		$this->consult=str_replace("'","\'",$obj->consult);
		$this->paid=str_replace("'","\'",$obj->paid);
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

	//get patientid
	function getPatientid(){
		return $this->patientid;
	}
	//set patientid
	function setPatientid($patientid){
		$this->patientid=$patientid;
	}

	//get transactionid
	function getTransactionid(){
		return $this->transactionid;
	}
	//set transactionid
	function setTransactionid($transactionid){
		$this->transactionid=$transactionid;
	}

	//get treatmentno
	function getTreatmentno(){
		return $this->treatmentno;
	}
	//set treatmentno
	function setTreatmentno($treatmentno){
		$this->treatmentno=$treatmentno;
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

	//get invoicedon
	function getInvoicedon(){
		return $this->invoicedon;
	}
	//set invoicedon
	function setInvoicedon($invoicedon){
		$this->invoicedon=$invoicedon;
	}

	//get consult
	function getConsult(){
		return $this->consult;
	}
	//set consult
	function setConsult($consult){
		$this->consult=$consult;
	}

	//get paid
	function getPaid(){
		return $this->paid;
	}
	//set paid
	function setPaid($paid){
		$this->paid=$paid;
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
	        
	        //Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='outgoinginvoice'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$date=date("Y-m-d");
		
		$payable = new Payables();
		$fields="*";
		$where=" where patientid='$obj->patientid' and invoicedon='$date' ";
		$having="";
		$groupby="";
		$orderby="";
		$join="";
		$payable->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo $payable->sql;		
	        if($payable->affectedRows>0){
	        $payable = $payable->fetchObject;
	        $obj->documentno=$payable->documentno;
	        }
	        else{
		$payables = new Payables();
		$fields="max(documentno) documentno";
		$where="";
		$having="";
		$groupby="";
		$orderby="";
		$join="";
		$payables->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$payables = $payables->fetchObject;
		
		$obj->documentno=$payables->documentno+1;
		}
		$payablesDBO = new PayablesDBO();
		if($payablesDBO->persist($obj)){
		        
		        $query="select * from hos_patients where id='$obj->patientid'";
		        $ress=mysql_fetch_object(mysql_query($query));
		
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields=" * ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where fn_generaljournalaccounts.refid in (select patientclasseid from hos_patients where id='$obj->patientid') and fn_generaljournalaccounts.acctypeid=31 and categoryid is null ";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo mysql_error();//echo $generaljournalaccounts->sql;
			$gna=$generaljournalaccounts->fetchObject;
				
			$generaljournalaccounts2 = new Generaljournalaccounts();
			$fields=" * ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where fn_generaljournalaccounts.refid=1 and fn_generaljournalaccounts.acctypeid=11 ";
			$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$gnas=$generaljournalaccounts2->fetchObject;
				  
				//record amount payable to generaljournal
				//debit Patients A/c and credit Accounts Receivable A/C
			$drgeneraljournals = new Generaljournals();
			$dr = new Generaljournals();
			$crgeneraljournals = new Generaljournals();
			$cr = new Generaljournals();

			//check if record already exists
			$fields=" * ";
			$orderby="";
			$having="";
			$groupby="";
			$join="";
			$where=" where accountid='$gna->id' and transactionid='$obj->transactionid' and documentno='$obj->documentno' ";
			$dr->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$dr=$dr->fetchObject;
	

			$fields=" * ";
			$orderby="";
			$having="";
			$groupby="";
			$join="";
			$where=" where accountid='$gnas->id' and transactionid='$obj->transactionid' and documentno='$obj->documentno' ";
			$cr->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$cr=$cr->fetchObject;

		
			$drgeneraljournals->accountid=$gna->id;
			$drgeneraljournals->tid=$obj->patientid;
			$drgeneraljournals->documentno=$obj->documentno;
			$drgeneraljournals->memo=$ress->surname." ".$ress->othernames;
			$drgeneraljournals->transactionid=$transaction->id;
			$drgeneraljournals->transactdate=$obj->transactdate;
			$drgeneraljournals->debit=$obj->amount;
			$drgeneraljournals->balance=$obj->amount;
			$drgeneraljournals->credit=0;
			$drgeneraljournals->createdby=$_SESSION['userid'];
			$drgeneraljournals->remarks=$obj->remarks;
			$drgeneraljournals->createdon=date("Y-m-d H:i:s");
			$drgeneraljournals->lasteditedby=$_SESSION['userid'];
			$drgeneraljournals->lasteditedon=date("Y-m-d H:i:s");
			
			$drgeneraljournals = $drgeneraljournals->setObject($drgeneraljournals);
			
			
			$it=0;
			$shpgeneraljournals[$it]=array('accountid'=>"$drgeneraljournals->accountid", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$drgeneraljournals->memo", 'debit'=>"$drgeneraljournals->debit", 'credit'=>"$drgeneraljournals->credit",'balance'=>"$drgeneraljournals->balance", 'total'=>"$drgeneraljournals->total",'remarks'=>"$drgeneraljournals->remarks",'transactionid'=>"$drgeneraljournals->transactionid",'documentno'=>"$drgeneraljournals->documentno",'transactdate'=>"$drgeneraljournals->transactdate");
			
			$it++;
			
			$crgeneraljournals->accountid=$gnas->id;
			$crgeneraljournals->daccountid=$gna->id;
			$crgeneraljournals->tid=$obj->patientid;
			$crgeneraljournals->documentno=$obj->documentno;
			$crgeneraljournals->memo=$ress->surname." ".$ress->othernames;
			$crgeneraljournals->transactionid=$transaction->id;
			$crgeneraljournals->transactdate=$obj->transactdate;
			$crgeneraljournals->debit=0;
			$crgeneraljournals->credit=$obj->amount;
			$crgeneraljournals->did=$id;
			$crgeneraljournals->remarks=$obj->remarks;
			$crgeneraljournals->createdby=$_SESSION['userid'];
			$crgeneraljournals->createdon=date("Y-m-d H:i:s");
			$crgeneraljournals->lasteditedby=$_SESSION['userid'];
			$crgeneraljournals->lasteditedon=date("Y-m-d H:i:s");
			
			$crgeneraljournals=$crgeneraljournals->setObject($crgeneraljournals);
			
			$shpgeneraljournals[$it]=array('accountid'=>"$crgeneraljournals->accountid", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$crgeneraljournals->memo", 'debit'=>"$crgeneraljournals->debit", 'credit'=>"$crgeneraljournals->credit", 'total'=>"$crgeneraljournals->total",'remarks'=>"$crgeneraljournals->remarks",'transactionid'=>"$crgeneraljournals->transactionid",'documentno'=>"$crgeneraljournals->documentno",'transactdate'=>"$crgeneraljournals->transactdate");
		
			$gn = new Generaljournals();
			$gn->add($obj, $shpgeneraljournals);
			
			$this->id=$payablesDBO->id;
			$this->sql=$payablesDBO->sql;
			//return true;	
		}
	}			
	function edit($obj,$where=""){
		$payablesDBO = new PayablesDBO();
		if($payablesDBO->update($obj,$where)){
			$this->sql=$payablesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$payablesDBO = new PayablesDBO();
		if($payablesDBO->delete($obj,$where=""))		
			$this->sql=$payablesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$payablesDBO = new PayablesDBO();
		$this->table=$payablesDBO->table;
		$payablesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$payablesDBO->sql;
		$this->result=$payablesDBO->result;
		$this->fetchObject=$payablesDBO->fetchObject;
		$this->affectedRows=$payablesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->patientid)){
			$error="Patient should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->patientid)){
			$error="Patient should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
