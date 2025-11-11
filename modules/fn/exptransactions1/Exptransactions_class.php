<?php 
require_once("ExptransactionsDBO.php");
class Exptransactions
{				
	var $id;			
	var $expenseid;	
	var $itemid;
	var $plotid;			
	var $paymenttermid;			
	var $supplierid;			
	var $purchasemodeid;			
	var $quantity;			
	var $tax;			
	var $discount;			
	var $amount;			
	var $total;			
	var $expensedate;			
	var $paid;			
	var $month;
	var $year;
	var $remarks;			
	var $memo;			
	var $documentno;
	var $voucherno;
	var $paymentmodeid;			
	var $bankid;			
	var $imprestaccountid;			
	var $chequeno;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $exptransactionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->expenseid))
			$obj->expenseid='NULL';
		$this->expenseid=$obj->expenseid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->plotid))
			$obj->plotid='NULL';
		$this->plotid=$obj->plotid;
		if(empty($obj->paymenttermid))
			$obj->paymenttermid='NULL';
		$this->paymenttermid=$obj->paymenttermid;
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		if(empty($obj->purchasemodeid))
			$obj->purchasemodeid='NULL';
		$this->purchasemodeid=$obj->purchasemodeid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->total=str_replace("'","\'",$obj->total);
		$this->expensedate=str_replace("'","\'",$obj->expensedate);
		$this->paid=str_replace("'","\'",$obj->paid);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->voucherno=str_replace("'","\'",$obj->voucherno);
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		if(empty($obj->imprestaccountid))
			$obj->imprestaccountid='NULL';
		$this->imprestaccountid=$obj->imprestaccountid;
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

	//get expenseid
	function getExpenseid(){
		return $this->expenseid;
	}
	//set expenseid
	function setExpenseid($expenseid){
		$this->expenseid=$expenseid;
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

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get purchasemodeid
	function getPurchasemodeid(){
		return $this->purchasemodeid;
	}
	//set purchasemodeid
	function setPurchasemodeid($purchasemodeid){
		$this->purchasemodeid=$purchasemodeid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
	}

	//get expensedate
	function getExpensedate(){
		return $this->expensedate;
	}
	//set expensedate
	function setExpensedate($expensedate){
		$this->expensedate=$expensedate;
	}

	//get paid
	function getPaid(){
		return $this->paid;
	}
	//set paid
	function setPaid($paid){
		$this->paid=$paid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
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

	//get imprestaccountid
	function getImprestaccountid(){
		return $this->imprestaccountid;
	}
	//set imprestaccountid
	function setImprestaccountid($imprestaccountid){
		$this->imprestaccountid=$imprestaccountid;
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
		$exptransactionsDBO = new ExptransactionsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		$it=0;
		/*$rw = mysql_fetch_object(mysql_query("select (max(voucherno)+1) voucherno from fn_exptransactions"));
		if(empty($rw->voucherno))
		  $rw->voucherno=1;
		$obj->voucherno=$rw->voucherno;*/
		
		//Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='Expenses'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		while($i<$num){
			$obj->expenseid=$shop[$i]['expenseid'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->plotid=$shop[$i]['plotid'];
			$obj->paymenttermid=$shop[$i]['paymenttermid'];
			$obj->month=$shop[$i]['month'];
			$obj->year=$shop[$i]['year'];
			$obj->expensename=$shop[$i]['expensename'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->tax=$shop[$i]['tax'];
			$obj->discount=$shop[$i]['discount'];
			$obj->amount=$shop[$i]['amount'];
			$obj->remarks=$shop[$i]['memo'];
			$obj->total = $shop[$i]['total'];
			$total+=$obj->total;
			
			$exptransactions = new Exptransactions();
			$exptransactions = $exptransactions->setObject($obj);
			if($exptransactionsDBO->persist($exptransactions)){		
				//$this->id=$exptransactionsDBO->id;
				$this->sql=$exptransactionsDBO->sql;
				
				$ob->transactdate=$obj->expensedate;
					
				}
				else if(!empty($obj->plotid) and $obj->plotid!=NULL and $obj->plotid!='NULL'){
				  $plots = new Plots();
				  $fields="*";
				  $where=" where id='$obj->plotid'";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $plots=$plots->fetchObject;
				  
				  //retrieve account to debit
				  $generaljournalaccounts = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid='$plots->landlordid' and acctypeid='33'";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $generaljournalaccounts=$generaljournalaccounts->fetchObject;
				  $ob->remarks="$obj->expensename for $plots->name in ".getMonth($obj->month)." ".$obj->year;
				}
				else{
				  //retrieve account to debit
				  $generaljournalaccounts = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid='$obj->expenseid' and acctypeid='4'";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $generaljournalaccounts=$generaljournalaccounts->fetchObject;
				  $ob->remarks="Payment for $obj->expensename ";
				}
				
				//make credit entry
				$generaljournal = new Generaljournals();
				$ob->tid=$tenantpayments->id;
				$ob->documentno="$obj->voucherno";
				$ob->memo=$obj->memo;
				$ob->accountid=$generaljournalaccounts->id;
				$ob->daccountid=$generaljournalaccounts2->id;
				$ob->transactionid=$transaction->id;
				$ob->mode=$obj->paymentmodeid;
				$ob->debit=$obj->total;
				$ob->credit=0;
				
				$ob->class="B";
				$generaljournal->setObject($ob);echo $generaljournal->accountid;
				//$generaljournal->add($generaljournal);
				
				$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'documentno'=>"$generaljournal->documentno", 'remarks'=>"$generaljournal->remarks", 'class'=>"B", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->expensedate",'class'=>"$generaljournal->class",'transactionid'=>"$generaljournal->transactionid");
				
				$it++;		
			}
			$i++;
		}

		if($obj->purchasemodeid==1){
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
		}
		elseif($obj->purchasemodeid==3){
	           $paymentmodes->acctypeid=32;
	           $obj->bankid='1';
		
		}
		else{
		  $paymentmodes->acctypeid=30;
		  $obj->bankid=$obj->supplierid;
		}
				//retrieve account to credit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->bankid' and acctypeid='$paymentmodes->acctypeid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts2->sql;
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

				

		$ob->transactdate=$obj->expensedate;

				
				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$exptransactions->id;
		$ob->documentno=$obj->voucherno;
		$ob->remarks="Expenses on Voucher No $obj->voucherno";
		$ob->memo=$exptransactions->remarks;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=0;
		$ob->credit=$total;
		$ob->did=$generaljournal->id;
		$generaljournal2->setObject($ob);
		
		$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'accountname'=>"$generaljournalaccounts2->name",  'documentno'=>"$generaljournal2->documentno", 'class'=>"B", 'remarks'=>"$generaljournal2->remarks", 'memo'=>"$generaljournal2->memo", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->expensedate",'class'=>"$generaljournal->class",'transactionid'=>"$generaljournal2->transactionid");
			
		$gn = new Generaljournals();//print_r($shpgeneraljournals);
		$gn->add($obj, $shpgeneraljournals);

		return true;	
	}			
	function edit($obj,$where="",$shop){
		$exptransactionsDBO = new ExptransactionsDBO();

		//first delete all records under old documentno
		$where=" where voucherno='$obj->voucherno'";
		$exptransactionsDBO->delete($obj,$where);

		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='expenses'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$gn = new GeneralJournals();
		$where=" where documentno='$obj->voucherno' and transactionid='$transaction->id' ";
		$gn->delete($obj,$where);
		
		$exptransactions = new Exptransactions();

		$exptransactions->add($obj,$shop);

		return true;	
	}			
	function delete($obj,$where=""){			
		$exptransactionsDBO = new ExptransactionsDBO();
		if($exptransactionsDBO->delete($obj,$where=""))		
			$this->sql=$exptransactionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$exptransactionsDBO = new ExptransactionsDBO();
		$this->table=$exptransactionsDBO->table;
		$exptransactionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$exptransactionsDBO->sql;
		$this->result=$exptransactionsDBO->result;
		$this->fetchObject=$exptransactionsDBO->fetchObject;
		$this->affectedRows=$exptransactionsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
