<?php 
require_once("PayablesDBO.php");
class Payables
{				
	var $id;			
	var $documentno;			
	var $paymenttermid;			
	var $houseid;			
	var $tenantid;			
	var $month;			
	var $year;			
	var $invoicedon;			
	var $quantity;			
	var $amount;		
	var $total;	
	var $remarks;									
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
		$this->paymenttermid=str_replace("'","\'",$obj->paymenttermid);
		$this->houseid=str_replace("'","\'",$obj->houseid);
		$this->tenantid=str_replace("'","\'",$obj->tenantid);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->invoicedon=str_replace("'","\'",$obj->invoicedon);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->total=str_replace("'","\'",$obj->total);
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

	//get paymenttermid
	function getPaymenttermid(){
		return $this->paymenttermid;
	}
	//set paymenttermid
	function setPaymenttermid($paymenttermid){
		$this->paymenttermid=$paymenttermid;
	}

	//get houseid
	function getHouseid(){
		return $this->houseid;
	}
	//set houseid
	function setHouseid($houseid){
		$this->houseid=$houseid;
	}

	//get tenantid
	function getTenantid(){
		return $this->tenantid;
	}
	//set tenantid
	function setTenantid($tenantid){
		$this->tenantid=$tenantid;
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

	//get invoicedon
	function getInvoicedon(){
		return $this->invoicedon;
	}
	//set invoicedon
	function setInvoicedon($invoicedon){
		$this->invoicedon=$invoicedon;
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

	function add($obj,$shop,$bool=true){
		$payablesDBO = new PayablesDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		$drtotal=0;
		$crtotal=0;
		$totalmgtfee=0;
		$totalvatamount=0;
		$totalmgtfeevatamount=0;
		
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
		
		if(empty($obj->retrieve)){
		  $payables = new Payables();
		  $fields="max(documentno)+1 documentno";
		  $where="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $join="";
		  $payables->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $payables = $payables->fetchObject;
		  
		  $obj->documentno=$payables->documentno;
		}
		
		if(!$bool){
		  $obj->retrieve="";
		}
		
		$obj->transactdate=$obj->invoicedon;
		
		$total=0;
		$it=0;
		
			
			$shpgeneraljournals=array();
			
		while($i<$num){
			
			$obj->houseid = $shop[$i]['houseid'];
			
			$houses = new Houses();
			$fields="em_houses.*, em_plots.name plot";
			$join=" left join em_plots on em_plots.id=em_houses.plotid ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where em_houses.id='$obj->houseid' ";
			$houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$houses=$houses->fetchObject;
			
			$obj->vatclasseid=$shop[$i]['vatclasseid'];
			$obj->mgtfee=$shop[$i]['mgtfee'];
			$obj->mgtfeevatclasseid=$shop[$i]['mgtfeevatclasseid'];
			$obj->mgtfeeamount=$shop[$i]['mgtfeeamount'];
			$obj->vatamount=$shop[$i]['vatamount'];
			$obj->mgtfeevatamount=$shop[$i]['mgtfeevatamount'];
			$obj->housename=$houses->hseno;
			$obj->paymenttermid=$shop[$i]['paymenttermid'];
			$obj->paymenttermname=$shop[$i]['paymenttermname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->amount=$shop[$i]['amount'];
			$obj->remarks=$shop[$i]['remarks'];
			$obj->total=$shop[$i]['total'];	
			if(!empty($shop[$i]['createdon'])){
			  $obj->createdon=$shop[$i]['createdon'];
			  $obj->createdby=$shop[$i]['createdby'];
			}
			
			$total+=$obj->total;
			
			if($payablesDBO->persist($obj,$bool)){		
				//$this->id=$payablesDBO->id;
				//$this->sql=$payablesDBO->sql;	
				
				$paymentterms = new Paymentterms();
				$fields="*";
				$where=" where id='$obj->paymenttermid' ";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$paymentterms=$paymentterms->fetchObject;
				
				$generaljournal2 = new Generaljournals();
				$ob->tid=$payablesDBO->id;
				$ob->documentno=$obj->documentno;
				$ob->remarks="Invoice for ".getMonth($obj->month)." ".$obj->year." ".$houses->plot." # ".$houses->hseno;
				$ob->memo=$obj->remarks;
				$ob->accountid=$paymentterms->generaljournalaccountid;
				$ob->daccountid=$generaljournalaccounts2->id;
				$ob->transactionid=$transaction->id;
				$ob->mode=4;
				$ob->class="B";
				$ob->debit=0;
				$ob->credit=$obj->total;
				$ob->did=$generaljournal->id;
				$generaljournal2->setObject($ob);
				//$generaljournal2->add($generaljournal2);
			
				$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->transactdate",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'transactionid'=>"$generaljournal2->transactionid");
				$it++;
			}
			
			$i++;
		}
		
		//make payable journal entry here
		//retrieve account to debit to tenants A/C (subsidiary of Rent receivable A/C)
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->tenantid' and acctypeid='32'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts=$generaljournalaccounts->fetchObject;
		
		$ob->chequeno="";
		$ob->reconstatus="No";
		$ob->recondate=date("Y-m-d");
		$ob->createdby=1;
		$ob->createdon=date("Y-m-d");
		$ob->lasteditedby=1;
		$ob->lasteditedon=date("Y-m-d");
		$ob->jvno="";
		$ob->id="";
		$ob->did="";
		
		//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$payablesDBO->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Invoice for ".getMonth($obj->month)." ".$obj->year." ".$houses->plot." # ".$houses->hseno;
		$ob->memo=$obj->remarks;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode=4;
		$ob->class="B";
		$ob->debit=$total;
		$ob->credit=0;
		$generaljournal->setObject($ob);
		//$generaljournal->add($generaljournal);
		
		$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->transactdate",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'transactionid'=>"$generaljournal->transactionid");
		
		$it++;		
		
		$gn = new Generaljournals();
		$gn->add($obj, $shpgeneraljournals);
		      
		$saved="Yes";
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$payablesDBO = new PayablesDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$payablesDBO->delete($obj,$where);

		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='outgoinginvoice'";
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
		if(empty($obj->documentno)){
			$error="Invoice No should be provided";
		}
		else if(empty($obj->houseid)){
			$error="House should be provided";
		}
		else if(empty($obj->tenantid)){
			$error="Tenant should be provided";
		}
		else if(empty($obj->month)){
			$error="Month should be provided";
		}
		else if(empty($obj->year)){
			$error="Year should be provided";
		}
		else if(empty($obj->invoicedon)){
			$error="Invoiced On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Invoice No should be provided";
		}
		else if(empty($obj->tenantid)){
			$error="Tenant should be provided";
		}
		else if(empty($obj->month)){
			$error="Month should be provided";
		}
		else if(empty($obj->year)){
			$error="Year should be provided";
		}
		else if(empty($obj->invoicedon)){
			$error="Invoiced On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
