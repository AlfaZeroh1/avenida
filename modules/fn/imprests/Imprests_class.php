<?php 
require_once("ImprestsDBO.php");
class Imprests
{				
	var $id;			
	var $documentno;			
	var $paymentvoucherno;			
	var $imprestaccountid;			
	var $employeeid;
	var $employeename;
	var $issuedon;			
	var $paymentmodeid;			
	var $paymentcategoryid;
	var $bankid;
	var $employeeids;
	var $chequeno;
	var $currencyid;
	var $exchangerate;
	var $exchangerate2;
	var $transactionno;		
	var $amount;			
	var $memo;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $imprestsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->paymentvoucherno=str_replace("'","\'",$obj->paymentvoucherno);
		if(empty($obj->imprestaccountid))
			$obj->imprestaccountid='NULL';
		$this->imprestaccountid=$obj->imprestaccountid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->issuedon=str_replace("'","\'",$obj->issuedon);
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		if(empty($obj->paymentcategoryid))
			$obj->paymentcategoryid='NULL';
		$this->paymentcategoryid=$obj->paymentcategoryid;
		
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		
		if(empty($obj->employeeids))
			$obj->employeeids='NULL';
		$this->employeeids=$obj->employeeids;
		
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->exchangerate2=str_replace("'","\'",$obj->exchangerate2);
		$this->exchangerate=str_replace("'","\'",$obj->exchangerate);
		$this->currencyid=str_replace("'","\'",$obj->currencyid);
		$this->transactionno=str_replace("'","\'",$obj->transactionno);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->employeename=str_replace("'","\'",$obj->employeename);
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

	//get paymentvoucherno
	function getPaymentvoucherno(){
		return $this->paymentvoucherno;
	}
	//set paymentvoucherno
	function setPaymentvoucherno($paymentvoucherno){
		$this->paymentvoucherno=$paymentvoucherno;
	}

	//get imprestaccountid
	function getImprestaccountid(){
		return $this->imprestaccountid;
	}
	//set imprestaccountid
	function setImprestaccountid($imprestaccountid){
		$this->imprestaccountid=$imprestaccountid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get issuedon
	function getIssuedon(){
		return $this->issuedon;
	}
	//set issuedon
	function setIssuedon($issuedon){
		$this->issuedon=$issuedon;
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

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
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
		$imprestsDBO = new ImprestsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='imprests'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;

		$it=0;
		$obj->transactdate=$obj->issuedon;
		$obj->currencyid=$obj->currencyid;
                $obj->rate=$obj->exchangerate;
		$obj->eurorate=$obj->exchangerate2;
		while($i<$num){
			
			$obj->imprestaccountid=$shop[$i]['imprestaccountid'];
			$obj->imprestaccountname=$shop[$i]['imprestaccountname'];
			$obj->employeeid=$shop[$i]['employeeid'];
			$obj->employeename=$shop[$i]['employeename'];
			$obj->amount=$shop[$i]['amount'];
			$obj->remarks=$shop[$i]['remarks'];
			
			$total+=$obj->amount;
			
			$obj = $this->setObject($obj);
			
			if($imprestsDBO->persist($obj)){		
				//$this->id=$imprestsDBO->id;
				$this->sql=$imprestsDBO->sql;
			}
			$i++;
		
			//retrieve account to debit
		if(!empty($obj->imprestaccountid) and $obj->imprestaccountid!=NULL and $obj->imprestaccountid!='NULL'){
		  $generaljournalaccounts = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$obj->imprestaccountid' and acctypeid='24'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts=$generaljournalaccounts->fetchObject;		
		}elseif(!empty($obj->employeeid) and $obj->employeeid!=NULL and $obj->employeeid!='NULL'){
		  $generaljournalaccounts = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$obj->employeeid' and acctypeid='36'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  if($generaljournalaccounts->affectedRows>0){
		    $generaljournalaccounts=$generaljournalaccounts->fetchObject;
		  }else{
		    
		    $gn = new Generaljournalaccounts();
		    $gn->refid=$obj->employeeid;
		    $gn->acctypeid=36;
		    $gn->name=$obj->employeename;
		    $gn->currencyid=5;
		    $gn->createdby=$_SESSION['userid'];
		    $gn->createdon=date("Y-m-d H:i:s");
		    $gn->lasteditedby=$_SESSION['userid'];
		    $gn->lasteditedon=date("Y-m-d H:i:s");
		    $gn->ipaddress=$_SERVER['REMOTE_ADDR'];
		    
		    $gn = $gn->setObject($gn);
		    $gn->add($gn);
		    
		    $generaljournalaccounts->id=$gn->id;
		  }
		}

				//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$imprests->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks=$imprests->remarks;
		$ob->memo=$obj->employeename;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=$obj->amount;
		$ob->credit=0;
		$ob->class="A";
		$generaljournal->setObject($ob);

		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		$it++;
		}

				//Make a journal entry

			
		$paymentmodes = new Paymentmodes();
		  $fields="*";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $where=" where id='$obj->paymentmodeid' ";
		  $paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $paymentmodes=$paymentmodes->fetchObject;

		if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid) and $obj->imprestaccountid>0)
		    $obj->bankid=$obj->imprestaccountid;
		    
		  if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
			  $obj->bankid=1;
		  }
		  
	  
		  if($obj->paymentmodeid==1){
			  $acctype=24;
			  $obj->bankid=1;
		  }
		  if($obj->paymentmodeid==2 or $obj->paymentmodeid==5 or $obj->paymentmodeid==6 or $obj->paymentmodeid==7 or $obj->paymentmodeid==8){
			  $acctype=8;
			  $obj->bankid=$obj->bankid;
		  }
		  if($obj->paymentmodeid==11){
			  $acctype=36;
			  $obj->bankid=$obj->employeeid;
		  }
		

				//retrieve account to credit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->bankid' and acctypeid='$acctype'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts2->sql;
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

				//Get transaction Identity
		


				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$imprests->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks=$imprests->remarks;
		$ob->memo=$obj->employeename;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=0;
		$ob->class="A";
		$ob->credit=$total;
		$generaljournal2->setObject($ob);
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");

		$gn= new Generaljournals();
		$gn->add($obj,$shpgeneraljournals);

		return true;	
	}			
	function edit($obj,$where="",$shop){
		$imprestsDBO = new ImprestsDBO();
		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$imprestsDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->documentno' and transactionid='33'  ";
		$gn->delete($obj,$where); //echo $gn->sql;
		$imprests=new Imprests();
		$imprests->add($obj,$shop);

		return true;	
	}			
	function delete($obj,$where=""){			
		$imprestsDBO = new ImprestsDBO();
		if($imprestsDBO->delete($obj,$where=""))		
			$this->sql=$imprestsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$imprestsDBO = new ImprestsDBO();
		$this->table=$imprestsDBO->table;
		$imprestsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$imprestsDBO->sql;
		$this->result=$imprestsDBO->result;
		$this->fetchObject=$imprestsDBO->fetchObject;
		$this->affectedRows=$imprestsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Imprest No should be provided";
		}
		else if(empty($obj->paymentvoucherno)){
			$error="Payment Voucher No should be provided";
		}
		else if(empty($obj->imprestaccountid) and empty($obj->employeeid)){
			$error="Imprest Account/Employee should be provided";
		}
		else if(empty($obj->issuedon)){
			$error="Issued On should be provided";
		}
		else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Imprest No should be provided";
		}
		else if(empty($obj->issuedon)){
			$error="Issued On should be provided";
		}
		else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
		else if(empty($obj->paymentvoucherno)){
			$error="Payment Voucher No should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
