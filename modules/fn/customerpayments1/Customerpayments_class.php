<?php 
require_once("CustomerpaymentsDBO.php");
class Customerpayments
{				
	var $id;			
	var $patientid;
	var $amount1;
	var $total;
	var $documentno;			
	var $paidon;	
	var $currencyid;
	var $exchangerate;
	var $exchangerate2;
	var $amount;			
	var $paymentmodeid;			
	var $bankid;
	var $remarks;
	var $customername;
	var $chequeno;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;
	var $patientclasseid;
	var $customerpaymentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->patientid))
			$obj->patientid='NULL';
		$this->patientid=$obj->patientid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		
		$this->patientclasseid=str_replace("'","\'",$obj->patientclasseid);
		
		$this->customername=str_replace("'","\'",$obj->customername);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->amount1=str_replace("'","\'",$obj->amount1);
		$this->total=str_replace("'","\'",$obj->total);
		$this->paidon=str_replace("'","\'",$obj->paidon);
		$this->currencyid=str_replace("'","\'",$obj->currencyid);
		$this->exchangerate=str_replace("'","\'",$obj->exchangerate);
		$this->exchangerate2=str_replace("'","\'",$obj->exchangerate2);
		$this->amount=str_replace("'","\'",$obj->amount);
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
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

	//get patientid
	function getPatientid(){
		return $this->patientid;
	}
	//set patientid
	function setPatientid($patientid){
		$this->patientid=$patientid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
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
		$customerpaymentsDBO = new CustomerpaymentsDBO();
		$spp->patientid=$obj->patientid;
		$spp->documentno=$obj->documentno;
		$spp->paidon=$obj->paidon;
		$spp->remarks="Customer Payments";
		$spp->amount=$obj->amount1;
		$spp->paymentmodeid=$obj->paymentmodeid;
		$spp->bankid=$obj->bankid;
		$spp->chequeno=$obj->chequeno;
		$spp->ipaddress=$obj->ipaddress;
		$spp->createdby=$obj->createdby;
		$spp->createdon=$obj->createdon;      
		$spp->lasteditedby=$obj->lasteditedby;
		$spp->lasteditedon=$obj->lasteditedon;  
		if($customerpaymentsDBO->persist($spp)){
		
			$transaction = new Transactions();
			$fields="*";
			$where=" where lower(replace(name,' ',''))='customerremittance'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $transaction->sql;
			$transaction=$transaction->fetchObject;
			
			$shpgeneraljournals=array();
			$it=0;
			
			$obj->transactdate = $obj->paidon;
			
			
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->patientclasseid' and acctypeid='31'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby); //echo $generaljournalaccounts->sql;
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;
				
			$paymentmodes = new Paymentmodes();
			$fields=" * ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id='$obj->paymentmodeid'";
			$join=" ";
			$paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$paymentmodes = $paymentmodes->fetchObject;
					
			if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid))
			  $obj->bankid=$obj->imprestaccountid;
			  
			if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
				$obj->bankid=1;
			}
			
					//retrieve account to debit
			$generaljournalaccounts2 = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->bankid' and acctypeid='$paymentmodes->acctypeid'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

			$generaljournal = new Generaljournals();
			$ob->tid=$customerpaymentsDBO->id;
			$ob->documentno="$obj->documentno";
			$ob->remarks="Patient Payments";
			$ob->memo=$obj->customername;
			$ob->accountid=$generaljournalaccounts2->id;
			$ob->transactionid=$transaction->id;
			$ob->mode=$obj->paymentmodeid;
			$ob->class="B";	
			$ob->rate=$obj->rate;			
			$ob->eurorate=$obj->eurorate;
			$ob->debit=$obj->amount1;			
			$ob->credit=0;
			$ob->debiteuro=$obj->amount1*$obj->eurorate;
			$ob->crediteuro=0;
			$ob->debitorig=$obj->amount1;
			$ob->creditorig=0;			
			$ob->transactdate=$obj->paidon;
			
			$generaljournal = $generaljournal->setObject($ob);
			//$generaljournal->add($generaljournal);
			
			$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
			
			$it++;
			
			mysql_query("update fn_generaljournals set balance='0' where accountid='$generaljournalaccounts->id'  ");	
					//make credit entry
			$generaljournal2 = new Generaljournals();
			$ob->tid=$customerpaymentsDBO->id;
			$ob->documentno="$obj->documentno";
			$ob->remarks="Patient Payments";
			$ob->memo=$obj->customername;
			$ob->accountid=$generaljournalaccounts->id;
			$ob->transactionid=$transaction->id;
			$ob->mode=$obj->paymentmodeid;
			$ob->class="B";
			$ob->rate=$obj->rate;			
			$ob->eurorate=$obj->eurorate;
			$ob->credit=$obj->amount1;			
			$ob->debit=0;
			$ob->crediteuro=$obj->amount1*$obj->eurorate;
			$ob->debiteuro=0;
			$ob->creditorig=$obj->amount1;
			$ob->debitorig=0;
			if(($obj->total-$obj->amount)>0)		
			$ob->balance=($obj->total-$obj->amount);
			else
			$ob->balance=0;			
			$ob->transactdate=$obj->paidon;
			
			$generaljournal2 = $generaljournal2->setObject($ob);
			//$generaljournal->add($generaljournal);
			
			$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'debiteuro'=>"$generaljournal2->debiteuro",'crediteuro'=>"$generaljournal2->crediteuro",'debitorig'=>"$generaljournal2->debitorig",'creditorig'=>"$generaljournal2->creditorig",'balance'=>"$generaljournal2->balance",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'eurorate'=>"$generaljournal2->eurorate",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");
						
			$gn = new Generaljournals();//print_r($shpgeneraljournals);
			if($gn->add($obj, $shpgeneraljournals)){
			  $i=0;
			  $shop = $_SESSION['shpgeneraljournal'];
			  //print_r($shop);
			  $num = count($shop);
			 foreach($shop as $key => $value){
			     
			     $i++;
			     $query="update fn_generaljournals set balance='$value' where id='$key'";
			     mysql_query($query);
			  }
			}
			
			//$this->id=$customerpaymentsDBO->id;
			$this->sql=$customerpaymentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$customerpaymentsDBO = new CustomerpaymentsDBO();
		if($customerpaymentsDBO->update($obj,$where)){
			$this->sql=$customerpaymentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$customerpaymentsDBO = new CustomerpaymentsDBO();
		if($customerpaymentsDBO->delete($obj,$where=""))		
			$this->sql=$customerpaymentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$customerpaymentsDBO = new CustomerpaymentsDBO();
		$this->table=$customerpaymentsDBO->table;
		$customerpaymentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$customerpaymentsDBO->sql;
		$this->result=$customerpaymentsDBO->result;
		$this->fetchObject=$customerpaymentsDBO->fetchObject;
		$this->affectedRows=$customerpaymentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->patientclasseid)){
			$error="Patient should be provided";
		}else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}else if(($obj->paymentmodeid==5 or $obj->paymentmodeid==2) and empty($obj->bankid)){
			$error="Bank should be provided";
		}else if(($obj->paymentmodeid==2) and empty($obj->chequeno)){
			$error="Cheque No. should be provided";
		
		}else if(empty($obj->paidon)){
			$error="Date Paid should be provided";
		}
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->patientclasseid)){
			$error="Patient should be provided";
		}else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}else if(($obj->paymentmodeid==5 or $obj->paymentmodeid==2) and empty($obj->bankid)){
			$error="Bank should be provided";
		}else if(($obj->paymentmodeid==2) and empty($obj->chequeno)){
			$error="Cheque No. should be provided";
		}else if(empty($obj->paidon)){
			$error="Date Paid should be provided";
		}
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
