<?php 
require_once("LandlordpaymentsDBO.php");
class Landlordpayments
{				
	var $id;			
	var $documentno;			
	var $landlordid;			
	var $plotid;			
	var $paymenttermid;			
	var $paymentmodeid;			
	var $bankid;			
	var $chequeno;			
	var $amount;			
	var $paidon;			
	var $month;			
	var $year;			
	var $receivedby;			
	var $remarks;									
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;
	var $landlordpaymentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->landlordid=str_replace("'","\'",$obj->landlordid);
		$this->plotid=str_replace("'","\'",$obj->plotid);
		$this->paymenttermid=str_replace("'","\'",$obj->paymenttermid);
		$this->paymentmodeid=str_replace("'","\'",$obj->paymentmodeid);
		$this->bankid=str_replace("'","\'",$obj->bankid);
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->paidon=str_replace("'","\'",$obj->paidon);
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

	//get landlordid
	function getLandlordid(){
		return $this->landlordid;
	}
	//set landlordid
	function setLandlordid($landlordid){
		$this->landlordid=$landlordid;
	}

	//get plotid
	function getPlotid(){
		return $this->plotid;
	}
	//set plotid
	function setPlotid($plotid){
		$this->plotid=$plotid;
	}

	//get paymenttermid
	function getPaymenttermid(){
		return $this->paymenttermid;
	}
	//set paymenttermid
	function setPaymenttermid($paymenttermid){
		$this->paymenttermid=$paymenttermid;
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

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get paidon
	function getPaidon(){
		return $this->paidon;
	}
	//set paidon
	function setPaidon($paidon){
		$this->paidon=$paidon;
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

	function add($obj,$shop,$bool="",$bl=true){
		$landlordpaymentsDBO = new LandlordpaymentsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		
		while($i<$num){

			$shpgeneraljournals=array();
			
			$total+=$shop[$i]['amount'];
			$obj->total=$total;

			if($bool){
				$obj->landlordid=$shop[$i]['landlordid'];
			}
			$obj->paymenttermid=$shop[$i]['paymenttermid'];
			$obj->paymenttermname=$shop[$i]['paymenttermname'];
			$obj->amount=$shop[$i]['amount'];
			$obj->plotid=$shop[$i]['plotid'];
			$obj->plotname=$shop[$i]['plotname'];
			$obj->month=$shop[$i]['month'];
			$obj->year=$shop[$i]['year'];
			$obj->remarks=$shop[$i]['remarks'];
			
			
			  $obj->landlordname=$shop[$i]['landlordname'];
			  
			if($landlordpaymentsDBO->persist($obj,$bl)){		
				//$this->id=$landlordpaymentsDBO->id;
				$this->sql=$landlordpaymentsDBO->sql;
				
				//Make a journal entry
					
				if($bool){
				  $this->addToGeneralJournal($obj);
				}
				
				
				//$generaljournal->did=$generaljournal2->id;
				//$generaljournal->edit($generaljournal);
			}
			$i++;
		}
		
		if(!$bool){
		  $this->addToGeneralJournal($obj);
		}
		$saved="Yes";
		return true;	
	}	
	function addToGeneralJournal($obj){
	  //Get transaction Identity
	  $transaction = new Transactions();
	  $fields="*";
	  $where=" where lower(replace(name,' ',''))='LandlordPayments'";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $transaction=$transaction->fetchObject;
	  
	  $obj->transactdate=$obj->paidon;
	  
	  //retrieve account to debit
	  $generaljournalaccounts = new Generaljournalaccounts();
	  $fields="*";
	  $where=" where refid='$obj->landlordid' and acctypeid='33'";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $generaljournalaccounts=$generaljournalaccounts->fetchObject;
	  
	  $paymentmodes = new Paymentmodes();
	  $fields="*";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where id='$obj->paymentmodeid' ";
	  $paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $paymentmodes=$paymentmodes->fetchObject;
	  
// 	  if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid))
// 	    $obj->bankid=$obj->imprestaccountid;
// 	    
// 	  if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
// 		  $obj->bankid=1;
// 	  }
// 	  
// 	  if($obj->paymentmodeid==1)
// 	    $obj->bankid=1;
	  
	  $it=0;
	  
	  //retrieve account to credit
	  $generaljournalaccounts2 = new Generaljournalaccounts();
	  $fields="*";
	  $where=" where refid='$obj->bankid' and acctypeid='$paymentmodes->acctypeid'";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
	  
	  //make credit entry
	  $generaljournal = new Generaljournals();
	  $ob->tid=$tenantpayments->id;
	  $ob->documentno=$obj->documentno;
	  $ob->remarks="Payment for ".getMonth($obj->month)." ".$obj->year;
	  $ob->memo=$obj->remarks;
	  $ob->accountid=$generaljournalaccounts->id;
	  $ob->daccountid=$generaljournalaccounts2->id;
	  $ob->transactionid=$transaction->id;
	  $ob->mode=$obj->paymentmodeid;
	  $ob->debit=$obj->total;
	  $ob->credit=0;
	  $ob->class="B";
	  $generaljournal->setObject($ob);
	  //$generaljournal->add($generaljournal);
	  
	  $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'documentno'=>"$generaljournal->documentno", 'remarks'=>"$generaljournal->remarks", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'class'=>"B", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'remarks'=>"$generaljournal->remarks",'transactionid'=>"$generaljournal->transactionid");
	  
	  $it++;
	  
	  //make credit entry
	  $generaljournal2 = new Generaljournals();
	  $ob->tid=$tenantpayments->id;
	  $ob->documentno=$obj->documentno;
	  $ob->remarks="Payment to ".$obj->landlordname;
	  $ob->memo=$obj->remarks;
	  $ob->daccountid=$generaljournalaccounts->id;
	  $ob->accountid=$generaljournalaccounts2->id;
	  $ob->transactionid=$transaction->id;
	  $ob->mode=$obj->paymentmodeid;
	  $ob->debit=0;
	  $ob->class="B";
	  $ob->credit=$obj->total;
	  $ob->did=$generaljournal->id;
	  $generaljournal2->setObject($ob);
	  //$generaljournal2->add($generaljournal2);
	  
	  $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'accountname'=>"$generaljournalaccounts2->name", 'documentno'=>"$generaljournal2->documentno", 'remarks'=>"$generaljournal2->remarks", 'memo'=>"$generaljournal2->memo", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'class'=>"B", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon",'remarks'=>"$generaljournal2->remarks",'transactionid'=>"$generaljournal2->transactionid");
		  
	  $gn = new Generaljournals();
	  $gn->add($obj, $shpgeneraljournals);
	}
	function edit($obj,$where="",$shop,$bool=""){
		$landlordpaymentsDBO = new LandlordpaymentsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$landlordpaymentsDBO->delete($obj,$where);

		
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='landlordpayments'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$gn = new GeneralJournals();
		$where=" where documentno='$obj->documentno' and transactionid='$transaction->id' ";
		$gn->delete($obj,$where);
		

		$this->add($obj,$shop);
		
		$saved="Yes";
		
		return true;	
	}			
	function delete($obj,$where=""){			
		$landlordpaymentsDBO = new LandlordpaymentsDBO();
		if($landlordpaymentsDBO->delete($obj,$where))		
			$this->sql=$landlordpaymentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$landlordpaymentsDBO = new LandlordpaymentsDBO();
		$this->table=$landlordpaymentsDBO->table;
		$landlordpaymentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$landlordpaymentsDBO->sql;
		$this->result=$landlordpaymentsDBO->result;
		$this->fetchObject=$landlordpaymentsDBO->fetchObject;
		$this->affectedRows=$landlordpaymentsDBO->affectedRows;
	}			
	function validate($obj){
	
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
