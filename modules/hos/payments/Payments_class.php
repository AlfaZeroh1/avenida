<?php 
require_once("PaymentsDBO.php");
class Payments
{				
	var $id;			
	var $documentno;			
	var $patientid;	
	var $payableid;
	var $transactionid;			
	var $tid;			
	var $treatmentno;			
	var $paymentmodeid;			
	var $bankid;			
	var $payee;			
	var $amount;			
	var $remarks;			
	var $paidon;			
	var $consult;	
	var $departmentid;
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
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->patientid))
			$obj->patientid='NULL';
		$this->patientid=$obj->patientid;
		if(empty($obj->transactionid))
			$obj->transactionid='NULL';
		$this->transactionid=$obj->transactionid;
		$this->tid=str_replace("'","\'",$obj->tid);
		$this->treatmentno=str_replace("'","\'",$obj->treatmentno);
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		$this->payee=str_replace("'","\'",$obj->payee);
		$this->payableid=str_replace("'","\'",$obj->payableid);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->paidon=str_replace("'","\'",$obj->paidon);
		$this->consult=str_replace("'","\'",$obj->consult);
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

	//get tid
	function getTid(){
		return $this->tid;
	}
	//set tid
	function setTid($tid){
		$this->tid=$tid;
	}

	//get treatmentno
	function getTreatmentno(){
		return $this->treatmentno;
	}
	//set treatmentno
	function setTreatmentno($treatmentno){
		$this->treatmentno=$treatmentno;
	}

	//get payee
	function getPayee(){
		return $this->payee;
	}
	//set payee
	function setPayee($payee){
		$this->payee=$payee;
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

	//get paidon
	function getPaidon(){
		return $this->paidon;
	}
	//set paidon
	function setPaidon($paidon){
		$this->paidon=$paidon;
	}

	//get consult
	function getConsult(){
		return $this->consult;
	}
	//set consult
	function setConsult($consult){
		$this->consult=$consult;
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
		$paymentsDBO = new PaymentsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		
		$obj->transactdate=$obj->paidon;
		
		if($obj->paymentmodeid==1){
			//$acctype=24;
			$obj->bankid=1;
		}
		if($obj->paymentmodeid==2 or $obj->paymentmodeid==3 or $obj->paymentmodeid==6){
			//$acctype=24;
			$obj->bankid=$obj->bankid;
		}
		if($obj->paymentmodeid==7){
			//$acctype=24;
			$obj->bankid=$obj->imprestaccountid;
		}
		if($obj->paymentmodeid==5){
			//$acctype=24;
			$suppliers = new Suppliers();
			$fields="*";
			$where=" where id='$obj->insuranceid'";
			$having="";
			$groupby="";
			$orderby="";
			$suppliers->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$suppliers=$suppliers->fetchObject;
					
			$obj->bankid=$suppliers->id;
		}
		
		while($i<$num){
			$obj->transactionid=$shop[$i]['transactionid'];
			$obj->transactionname=$shop[$i]['transactionname'];
			$obj->amount=$shop[$i]['amount'];
			$obj->remarks=$shop[$i]['remarks'];
			$obj->tid=$shop[$i]['tid'];
			$obj->payableid=$shop[$i]['payableid'];
			
			$amount=$obj->amount;
			
			if($obj->status=="creditnote"){
			  $obj->amount=$obj->amount*-1;
			}
			
			$total+=$amount;
			
			if($paymentsDBO->persist($obj)){
			
				//change pay status of payable
				$payables = new Payables();
				$fields="*";
				$where=" where id='$obj->tid'";
				$having="";
				$groupby="";
				$orderby="";
				$payables->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$payables=$payables->fetchObject;
				
				$payables->paid="Yes";
				
				$py = new Payables();
				$py->setObject($payables);
				$py->edit($py);
				
				//$this->id=$paymentsDBO->id;
				//$this->sql=$paymentsDBO->sql;
			}
			$i++;
		}
		$this->id=0;
		$obj->transactionid=4;
		
		$query="select * from hos_patients where id='$obj->patientid'";
		$ress=mysql_fetch_object(mysql_query($query));
		
		//account to credit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields=" * ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where fn_generaljournalaccounts.refid in (select patientclasseid from hos_patients where id='$obj->patientid') and fn_generaljournalaccounts.acctypeid=31 and categoryid is null ";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo mysql_error();
		$gna=$generaljournalaccounts->fetchObject;
		
		//account debit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields=" * ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where fn_generaljournalaccounts.refid=1 and fn_generaljournalaccounts.acctypeid=24 ";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$gnas=$generaljournalaccounts2->fetchObject;
		
		$drgeneraljournals = new Generaljournals();
		$crgeneraljournals = new Generaljournals();
		
		if($obj->status=="creditnote"){
		  $drgeneraljournals->accountid=$gnas->id;
		  $drgeneraljournals->daccountid=$gna->id;
		}
		else{
		  $drgeneraljournals->accountid=$gna->id;
		  $drgeneraljournals->daccountid=$gnas->id;
		}
		$drgeneraljournals->tid=$obj->patientid;
		$drgeneraljournals->documentno=$obj->documentno;
		$drgeneraljournals->memo=$ress->surname." ".$ress->othernames;
		$drgeneraljournals->transactionid=$obj->transactionid;
		$drgeneraljournals->transactdate=$obj->paidon;
		$drgeneraljournals->debit=0;
		$drgeneraljournals->credit=$total;
		$drgeneraljournals->remarks=$obj->transactionname;
		$drgeneraljournals->createdby=$_SESSION['userid'];
		$drgeneraljournals->createdon=date("Y-m-d H:i:s");
		$drgeneraljournals->lasteditedby=$_SESSION['userid'];
		$drgeneraljournals->lasteditedon=date("Y-m-d H:i:s");
		
		$drgeneraljournals->setObject($drgeneraljournals);
		
		//$drgeneraljournals->add($drgeneraljournals);
		//$crgeneraljournals->did=$drgeneraljournals->id;
		
		$it=0;
		$shpgeneraljournals[$it]=array('accountid'=>"$drgeneraljournals->accountid", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$drgeneraljournals->memo", 'debit'=>"$drgeneraljournals->debit", 'credit'=>"$drgeneraljournals->credit", 'total'=>"$drgeneraljournals->total",'remarks'=>"$drgeneraljournals->remarks",'documentno'=>"$drgeneraljournals->documentno",'transactdate'=>"$drgeneraljournals->transactdate");
		
		$it++;
		
		if($obj->status=="creditnote"){
		  $crgeneraljournals->accountid=$gna->id;
		  $crgeneraljournals->daccountid=$gnas->id;
		}
		else{
		  $crgeneraljournals->accountid=$gnas->id;
		  $crgeneraljournals->daccountid=$gna->id;
		}
		$crgeneraljournals->tid=$obj->patientid;
		$crgeneraljournals->documentno=$obj->documentno;
		$crgeneraljournals->memo=$ress->surname." ".$ress->othernames;
		$crgeneraljournals->transactionid=$obj->transactionid;
		$crgeneraljournals->transactdate=$obj->paidon;
		$crgeneraljournals->debit=$total;
		$crgeneraljournals->credit=0;
		$crgeneraljournals->remarks=$obj->transactionname;
		$crgeneraljournals->createdby=$_SESSION['userid'];
		$crgeneraljournals->createdon=date("Y-m-d H:i:s");
		$crgeneraljournals->lasteditedby=$_SESSION['userid'];
		$crgeneraljournals->lasteditedon=date("Y-m-d H:i:s");		
			
		$crgeneraljournals->setObject($crgeneraljournals);
		
		//$crgeneraljournals->add($crgeneraljournals);
		//$drgeneraljournals->did=$crgeneraljournals->id;
		
		//$drgeneraljournals->edit($drgeneraljournals);
		
		$shpgeneraljournals[$it]=array('accountid'=>"$crgeneraljournals->accountid", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$crgeneraljournals->memo", 'debit'=>"$crgeneraljournals->debit", 'credit'=>"$crgeneraljournals->credit", 'total'=>"$crgeneraljournals->total",'remarks'=>"$crgeneraljournals->remarks",'documentno'=>"$crgeneraljournals->documentno",'transactdate'=>"$crgeneraljournals->transactdate");
		
		$gn = new Generaljournals();
		$gn->add($obj, $shpgeneraljournals);
		
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$paymentsDBO = new PaymentsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$paymentsDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->transactionid=$shop['transactionid'];
			$obj->transactionname=$shop['transactionname'];
			$obj->amount=$shop['amount'];
			$obj->remarks=$shop['remarks'];
			
			$total+=$obj->amount;
			
			if($paymentsDBO->update($obj,$where)){
				$this->sql=$paymentsDBO->sql;
			}
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
		if(empty($obj->documentno)){
			$error="Receipt No should be provided";
		}
		else if(empty($obj->patientid)){
			$error="Patient should be provided";
		}
		else if(empty($obj->payee)){
			$error="Payee should be provided";
		}
		else if(empty($obj->paidon)){
			$error="Payment Date should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Receipt No should be provided";
		}
		else if(empty($obj->patientid)){
			$error="Patient should be provided";
		}
		else if(empty($obj->paidon)){
			$error="Payment Date should be provided";
		}
	else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
