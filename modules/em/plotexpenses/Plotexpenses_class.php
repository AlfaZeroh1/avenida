<?php 
require_once("PlotexpensesDBO.php");
class Plotexpenses
{				
	var $id;			
	var $plotid;			
	var $expenseid;			
	var $quantity;			
	var $amount;			
	var $total;			
	var $expensedate;			
	var $documentno;			
	var $pcvno;			
	var $month;			
	var $year;			
	var $paymentmodeid;			
	var $bankid;			
	var $imprestaccountid;			
	var $chequeno;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $plotexpensesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->plotid))
			$obj->plotid='NULL';
		$this->plotid=$obj->plotid;
		if(empty($obj->expenseid))
			$obj->expenseid='NULL';
		$this->expenseid=$obj->expenseid;
		$this->paymenttermid=$obj->paymenttermid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->total=str_replace("'","\'",$obj->total);
		$this->expensedate=str_replace("'","\'",$obj->expensedate);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->pcvno=str_replace("'","\'",$obj->pcvno);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
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
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get plotid
	function getPlotid(){
		return $this->plotid;
	}
	//set plotid
	function setPlotid($plotid){
		$this->plotid=$plotid;
	}

	//get expenseid
	function getExpenseid(){
		return $this->expenseid;
	}
	//set expenseid
	function setExpenseid($expenseid){
		$this->expenseid=$expenseid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get pcvno
	function getPcvno(){
		return $this->pcvno;
	}
	//set pcvno
	function setPcvno($pcvno){
		$this->pcvno=$pcvno;
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
		$plotexpensesDBO = new PlotexpensesDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		$shpgeneraljournals=array();
		$it=0;
		
		//Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='plotexpenses'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
				
		while($i<$num){
			$obj->expenseid=$shop[$i]['expenseid'];
			$obj->expensename=$shop[$i]['expensename'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->amount=$shop[$i]['amount'];
			$obj->total=$shop[$i]['total'];
			$obj->remarks=$shop[$i]['remarks'];
			if($plotexpensesDBO->persist($obj)){		
				//$this->id=$plotexpensesDBO->id;
				$this->sql=$plotexpensesDBO->sql;				
				
				
				$ob->transactdate=$obj->expensedate;
				
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
				
				
				//make credit entry
				$generaljournal = new Generaljournals();
				$ob->tid=$tenantpayments->id;
				$ob->documentno="$obj->documentno";
				$ob->remarks="Payment for ".$obj->month." ".$obj->year;
				$ob->memo=$tenantpayments->remarks;
				$ob->accountid=$generaljournalaccounts->id;
				$ob->daccountid=$generaljournalaccounts2->id;
				$ob->transactionid=$transaction->id;
				$ob->mode=$obj->paymentmodeid;
				$ob->debit=$obj->ttotal;
				$ob->credit=0;
				
				$ob->class="B";
				$generaljournal->setObject($ob);echo $generaljournal->accountid;
				//$generaljournal->add($generaljournal);
				
				$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'documentno'=>"$generaljournal->documentno", 'remarks'=>"$generaljournal->remarks", 'class'=>"B", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->expensedate",'class'=>"$generaljournal->class",'transactionid'=>"$generaljournal->transactionid");
				
				$it++;				
			}
			
			$i++;
		}
		$paymentmodes = new Paymentmodes();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id='$obj->paymentmodeid' ";
		$paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$paymentmodes=$paymentmodes->fetchObject;
		
		if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid))
		  $obj->bankid=$obj->imprestaccountid;
		  
		if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
			$obj->bankid=1;
		}
		
		
		//retrieve account to credit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->bankid' and acctypeid='$paymentmodes->acctypeid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo $generaljournalaccounts2->sql;
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		
		$expenses=new Expenses();
		$where="  ";
		$fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id='$obj->expenseid' ";
		$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$expenses = $expenses->fetchObject;
		
		//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$tenantpayments->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks="Payment for $expenses->name on behalf of $obj->plotname";
		$ob->memo=$tenantpayments->remarks;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode=$obj->paymentmodeid;
		$ob->debit=0;
		$ob->class="B";
		$ob->credit=$obj->ttotal;
		$ob->did=$generaljournal->id;
		$generaljournal2->setObject($ob);
		//$generaljournal2->add($generaljournal2);
		
		$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'accountname'=>"$generaljournalaccounts2->name",  'documentno'=>"$generaljournal2->documentno", 'class'=>"B", 'remarks'=>"$generaljournal2->remarks", 'memo'=>"$generaljournal2->memo", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->expensedate",'class'=>"$generaljournal->class",'transactionid'=>"$generaljournal2->transactionid");
			
		$gn = new Generaljournals();
		$gn->add($obj, $shpgeneraljournals);
		
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$plotexpensesDBO = new PlotexpensesDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$plotexpensesDBO->delete($obj,$where);

		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='plotexpenses'";
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
		
		return true;	
	}			
	function delete($obj,$where=""){			
		$plotexpensesDBO = new PlotexpensesDBO();
		if($plotexpensesDBO->delete($obj,$where=""))		
			$this->sql=$plotexpensesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$plotexpensesDBO = new PlotexpensesDBO();
		$this->table=$plotexpensesDBO->table;
		$plotexpensesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$plotexpensesDBO->sql;
		$this->result=$plotexpensesDBO->result;
		$this->fetchObject=$plotexpensesDBO->fetchObject;
		$this->affectedRows=$plotexpensesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
		elseif(empty($obj->paymenttermid)){
			$error="Payment Term should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
		elseif(empty($obj->paymenttermid)){
			$error="Payment Term should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
