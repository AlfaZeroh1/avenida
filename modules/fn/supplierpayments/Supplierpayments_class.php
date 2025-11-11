<?php 
require_once("SupplierpaymentsDBO.php");
class Supplierpayments
{				
	var $id;			
	var $supplierid;
	var $suppliername;
	var $documentno;			
	var $paidon;
	var $amount1;
	var $total;
	var $currencyid;
	var $exchangerate;
	var $exchangerate2;
	var $amount;			
	var $paymentmodeid;			
	var $bankid;
	var $remarks;
	var $chequeno;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $supplierpaymentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->paidon=str_replace("'","\'",$obj->paidon);
		$this->exchangerate=str_replace("'","\'",$obj->exchangerate);
		$this->exchangerate2=str_replace("'","\'",$obj->exchangerate2);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->amount1=str_replace("'","\'",$obj->amount1);
		$this->total=str_replace("'","\'",$obj->total);
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		
		if(empty($obj->currencyid))
			$obj->currencyid='NULL';
		$this->currencyid=$obj->currencyid;
		
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->suppliername=str_replace("'","\'",$obj->suppliername);
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

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
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

	function add($obj,$shop){
// 		$obj->amount=$obj->total;
		$supplierpaymentsDBO = new SupplierpaymentsDBO();
		$spp->supplierid=$obj->supplierid;
		$spp->documentno=$obj->documentno;
		$spp->paidon=$obj->paidon;
		$spp->amount=$obj->amount;
		$spp->paymentmodeid=$obj->paymentmodeid;
		$spp->bankid=$obj->bankid;
		$spp->currencyid=$obj->currencyid;
		$spp->exchangerate=$obj->exchangerate;
		$spp->exchangerate2=$obj->exchangerate2;
		$spp->remarks=$obj->remarks;
		$spp->chequeno=$obj->chequeno;
		$spp->ipaddress=$obj->ipaddress;
		$spp->createdby=$obj->createdby;
		$spp->createdon=$obj->createdon;      
		$spp->lasteditedby=$obj->lasteditedby;
		$spp->lasteditedon=$obj->lasteditedon;  /*
		$sp = $this->setObject($spp);*/
		if($supplierpaymentsDBO->persist($spp)){
		        $transaction = new Transactions();
			$fields="*";
			$where=" where lower(replace(name,' ',''))='supplierpayments'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$transaction=$transaction->fetchObject;
			
			$shpgeneraljournals=array();
			$it=0;
			
			$obj->rate=$obj->exchangerate;
			$obj->eurorate=$obj->exchangerate2;
			$obj->transactdate = $obj->paidon;
			$obj->currencyid=$obj->currencyid;
			
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->supplierid' and acctypeid='30'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
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
			$ob->tid=$supplierpaymentsDBO->id;
			$ob->documentno="$obj->documentno";
			$ob->remarks=$obj->remarks;
			$ob->memo=$obj->suppliername;
			$ob->accountid=$generaljournalaccounts2->id;
			$ob->transactionid=$transaction->id;
			$ob->mode=$obj->paymentmodeid;
			$ob->class="B";	
			$ob->currencyid=$obj->currencyid;
			$ob->rate=$obj->rate;			
			$ob->eurorate=$obj->eurorate;
			$ob->credit=$obj->amount;			
			$ob->debit=0;
			$ob->crediteuro=$obj->amount*$obj->eurorate;
			$ob->debiteuro=0;
			$ob->creditorig=$obj->amount;
			$ob->debitorig=0;
			$ob->transactdate=$obj->paidon;			
			
			
			$generaljournal = $generaljournal->setObject($ob);
// 			$generaljournal->add($generaljournal);
			
			$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
			
			$it++;
			
// 			mysql_query("update fn_generaljournals set balance='0' where accountid='$generaljournalaccounts->id' and transactionid='$transaction->id' ");
						
					
			
			$i=0;
			$shop = $_SESSION['shpinvoices'];
			$num = count($shop);
			$averagerate=0;
			while($i<$num){
			  
			    //make entries to fn_supplierpaidinvoices
			    $invoiceno=$shop[$i]['invoiceno'];
			    $amount=$shop[$i]['amount'];
			    $obj->diff=$shop[$i]['diff'];
			    $id = $shop[$i]['id'];			    
			    $rate = $shop[$i]['rate'];
			    
			    $averagerate+=$rate;
			    
			    
			    $obj->createdby=$_SESSION['userid'];
			    $obj->createdon=date("Y-m-d H:i:s");
			    $obj->lasteditedby=$_SESSION['userid'];
			    $obj->lasteditedon=date("Y-m-d H:i:s");
			    $obj->ipaddress=$_SERVER['REMOTE_ADDR'];
			    
			    $query="insert into fn_supplierpaidinvoices (supplierpaymentid,invoiceno, amount, ipaddress, createdby, createdon, lasteditedby, lasteditedon) values('$supplierpaymentsDBO->id','$invoiceno','$amount','$obj->ipaddress','$obj->createdby','$obj->createdon', '$obj->lasteditedby','$obj->lasteditedon')";
			    mysql_query($query);
			    
			    $query="update fn_generaljournals set balance=balance-$amount where id='$id'";
			    mysql_query($query);
			    if($obj->diff<>0){
			      $gna =new Generaljournalaccounts();
			      $fields="*";
			      $where=" where id='6368'";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $gna->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			      $gna=$gna->fetchObject;
			    
			      
			      $generaljournal3= new Generaljournals();
			      $generaljournal3->accountid=$gna->id;
			      $generaljournal3->daccountid=$gna2->id;
			      $generaljournal3->transactdate=$obj->depositdate;			    
			      $generaljournal3->debit=$obj->diff;
			      if($obj->diff>0){			      
				  $generaljournal3->remarks="Exchange Loss Supplier Payment PV:$obj->documentno";
				}else{
				  $generaljournal3->remarks="Exchange Gain Supplier Payment PV:$obj->documentno";
				}
			      $generaljournal3->credit=0;
			      $generaljournal3->currencyid=5;
			      $generaljournal3->rate=1;
			      $generaljournal3->eurorate=$obj->eurate;
			      $generaljournal3->documentno=$obj->documentno;
			      $generaljournal3->transactionid=$transaction->id;
			      
			      $shpgeneraljournals[$it]=array('tid'=>"$generaljournal3->tid",'documentno'=>"$generaljournal3->documentno",'remarks'=>"$generaljournal3->remarks",'memo'=>"$generaljournal3->memo",'accountid'=>"$generaljournal3->accountid",'transactionid'=>"$generaljournal3->transactionid",'mode'=>"$generaljournal3->mode",'debit'=>"$generaljournal3->debit",'credit'=>"$generaljournal3->credit",'transactdate'=>"$generaljournal3->transactdate",'currencyid'=>"$generaljournal3->currencyid",'rate'=>"$generaljournal3->rate",'eurorate'=>"$generaljournal3->eurorate",'class'=>"$generaljournal3->class",'jvno'=>"$generaljournal3->jvno");
			      
			      $it++;
			    
			    } 
			  $i++;
			}
			
			unset($_SESSION['shpinvoices']);
			
			if($obj->undistributed>0){
			  $num++;
			  $averagerate+=$obj->exchangerate;
			  $query="insert into fn_supplierpaidinvoices (supplierpaymentid,invoiceno, amount, ipaddress, createdby, createdon, lasteditedby, lasteditedon) values('$supplierpaymentsDBO->id','undistributed','$obj->undistributed','$obj->ipaddress','$obj->createdby','$obj->createdon', '$obj->lasteditedby','$obj->lasteditedon')";
			  mysql_query($query);
			}
			
			if($num==0)
			  $averagerate=$obj->rate;
			else
			  $averagerate=$averagerate/$num;
			
		      }
		      
		      
		      //make debit entry
			$generaljournal2 = new Generaljournals();
			$ob->tid=$supplierpaymentsDBO->id;
			$ob->documentno="$obj->documentno";
			$ob->remarks=$obj->remarks;
			$ob->memo=$obj->suppliername;
			$ob->accountid=$generaljournalaccounts->id;
			$ob->transactionid=$transaction->id;
			$ob->mode=$obj->paymentmodeid;
			$ob->class="B";	
			$ob->currencyid=$obj->currencyid;
			$ob->rate=$averagerate;			
			$ob->eurorate=$obj->eurorate;
			$ob->debit=$obj->amount;			
			$ob->credit=0;
			$ob->debiteuro=$obj->amount*$obj->eurorate;
			$ob->crediteuro=0;
			$ob->debitorig=$obj->amount;
			$ob->creditorig=0;
			if(($obj->total>$obj->amount)){	
			$ob->balance=($obj->total-$obj->amount);
			}
			else
			$ob->balance=0;	
			
			$ob->transactdate=$obj->paidon;
			
			$generaljournal2 = $generaljournal2->setObject($ob);
			//$generaljournal->add($generaljournal);
			
			$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'debiteuro'=>"$generaljournal2->debiteuro",'crediteuro'=>"$generaljournal2->crediteuro",'debitorig'=>"$generaljournal2->debitorig",'creditorig'=>"$generaljournal2->creditorig",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'balance'=>"$generaljournal2->balance",'eurorate'=>"$generaljournal2->eurorate",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");
			$it++;
			$gn = new Generaljournals();
			if($gn->add($obj, $shpgeneraljournals,false)){
			  
						
			//$this->id=$supplierpaymentsDBO->id;
			$this->sql=$supplierpaymentsDBO->sql;
			return true;	
		}	
	}			
	function edit($obj,$where="",$shop){
		
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='supplierpayments'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$supplierpaymentsDBO = new SupplierpaymentsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$supplierpaymentsDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->documentno' and transactionid='$transaction->id' ";
		$gn->delete($obj,$where);

		if($this->add($obj, $shop))
		  return true;	
	}			
	function delete($obj,$where=""){			
		$supplierpaymentsDBO = new SupplierpaymentsDBO();
		if($supplierpaymentsDBO->delete($obj,$where=""))		
			$this->sql=$supplierpaymentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$supplierpaymentsDBO = new SupplierpaymentsDBO();
		$this->table=$supplierpaymentsDBO->table;
		$supplierpaymentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$supplierpaymentsDBO->sql;
		$this->result=$supplierpaymentsDBO->result;
		$this->fetchObject=$supplierpaymentsDBO->fetchObject;
		$this->affectedRows=$supplierpaymentsDBO->affectedRows;
	}			
	function validate($obj){
	       if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}else if(($obj->paymentmodeid==5 or $obj->paymentmodeid==2) and empty($obj->bankid)){
			$error="Bank should be provided";
		}else if(($obj->paymentmodeid==5 or $obj->paymentmodeid==2) and empty($obj->chequeno)){
			$error="Cheque No. should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->exchangerate)){
			$error="Rate should be provided";
		}else if(empty($obj->exchangerate2)){
			$error="Euro Rate should be provided";
		}else if(empty($obj->paidon)){
			$error="Date Paid should be provided";
		}
// 		else if(empty($obj->remarks)){
// 			$error="Remarks should be provided";
// 		}
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
		if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}else if(($obj->paymentmodeid==5 or $obj->paymentmodeid==2) and empty($obj->bankid)){
			$error="Bank should be provided";
		}else if(($obj->paymentmodeid==5 or $obj->paymentmodeid==2) and empty($obj->chequeno)){
			$error="Cheque No. should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->exchangerate)){
			$error="Rate should be provided";
		}else if(empty($obj->exchangerate2)){
			$error="Euro Rate should be provided";
		}else if(empty($obj->paidon)){
			$error="Date Paid should be provided";
		}
// 		else if(empty($obj->remarks)){
// 			$error="Remarks should be provided";
// 		}
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
