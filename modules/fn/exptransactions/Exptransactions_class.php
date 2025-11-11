<?php 
require_once("ExptransactionsDBO.php");
class Exptransactions
{				
	var $id;			
	var $expenseid;
	var $assetid;
	var $liabilityid;
	var $typeid;
	var $employeeid;
	var $employeename;
	var $projectid;			
	var $supplierid;
	var $requisitionno;
	var $purchasemodeid;			
	var $quantity;	
	var $vatclasseid;
	var $tax;
	var $taxamount;
	var $discount;	
	var $exchangerate;
	var $exchangerate2;
	var $amount;			
	var $total;			
	var $expensedate;			
	var $paid;			
	var $remarks;			
	var $memo;			
	var $documentno;
	var $receiptno;
	var $paymentmodeid;	
	var $paymentcategoryid;
	var $bankid;
	var $imprestaccountid;
	var $currencyid;
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

		if(empty($obj->liabilityid))
			$obj->liabilityid='NULL';
		$this->liabilityid=$obj->liabilityid;
		
		if(empty($obj->assetid))
			$obj->assetid='NULL';
		$this->assetid=$obj->assetid; 
		
		if(empty($obj->imprestaccountid))
			$obj->imprestaccountid='NULL';
		$this->imprestaccountid=$obj->imprestaccountid; 
		
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		if(empty($obj->purchasemodeid))
			$obj->purchasemodeid='NULL';
		$this->purchasemodeid=$obj->purchasemodeid;
		$this->receiptno=$obj->receiptno;
		$this->requisitionno=$obj->requisitionno;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->taxamount=str_replace("'","\'",$obj->taxamount);
		$this->typeid=str_replace("'","\'",$obj->typeid);
		$this->vatclasseid=str_replace("'","\'",$obj->vatclasseid);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->exchangerate=str_replace("'","\'",$obj->exchangerate);
		$this->currencyid=str_replace("'","\'",$obj->currencyid);
		$this->exchangerate2=str_replace("'","\'",$obj->exchangerate2);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->total=str_replace("'","\'",$obj->total);
		$this->expensedate=str_replace("'","\'",$obj->expensedate);
		$this->paid=str_replace("'","\'",$obj->paid);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		
		if(empty($obj->paymentcategoryid))
			$obj->paymentcategoryid='NULL';
		$this->paymentcategoryid=$obj->paymentcategoryid;
		
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		
		$this->transactionno=str_replace("'","\'",$obj->transactionno);
		
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->employeename=str_replace("'","\'",$obj->employeename);
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

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
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

	function add($obj,$shop){print_r($obj);
		$exptransactionsDBO = new ExptransactionsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
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
                
                $obj->currencyid=$obj->currencyid;
                $obj->rate=$obj->exchangerate;
		$obj->eurorate=$obj->exchangerate2;
		$obj->transactdate=$obj->expensedate;
		
		$it=0;
		while($i<$num){
		
			$obj->expenseid=$shop[$i]['expenseid'];
			$obj->expensename=$shop[$i]['expensename'];
			$obj->assetid=$shop[$i]['assetid'];
			$obj->assetname=$shop[$i]['assetname'];
			$obj->liabilityid=$shop[$i]['liabilityid'];
			$obj->liabilityname=$shop[$i]['liabilityname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->vatclasseid=$shop[$i]['vatclasseid'];
			$obj->taxamount=$shop[$i]['taxamount'];
			$obj->tax=$shop[$i]['tax'];
			$obj->discount=$shop[$i]['discount'];
			$obj->amount=$shop[$i]['amount'];
			$obj->total=$shop[$i]['total'];
			$obj->memo=$shop[$i]['memo'];
			$total+=$obj->total;
			
			$exptransactions=new Exptransactions();
			$objs=$exptransactions->setObject($obj);
			if($exptransactionsDBO->persist($objs)){		
				//$this->id=$exptransactionsDBO->id;
				$this->sql=$exptransactionsDBO->sql;
			}
			$i++;
			
					//retrieve account to debit
					//retrieve account to debit
		        if($obj->expenseid!='NULL'){
			  $generaljournalaccounts = new Generaljournalaccounts();
			  $jaguarfields="*";
			  $where=" where refid='$obj->expenseid' and acctypeid='4'";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			  $generaljournalaccounts=$generaljournalaccounts->fetchObject;
			}
			elseif($obj->assetid!='NULL'){
			  $generaljournalaccounts = new Generaljournalaccounts();
			  $fields="*";
			  $where=" where refid='$obj->assetid' and acctypeid='7'";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			  $generaljournalaccounts=$generaljournalaccounts->fetchObject;
			}
			elseif($obj->liabilityid!='NULL'){
			  $generaljournalaccounts = new Generaljournalaccounts();
			  $fields="*";
			  $where=" where refid='$obj->liabilityid' and acctypeid='35'";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			  $generaljournalaccounts=$generaljournalaccounts->fetchObject;
			}
			
			//make debit entry
			$generaljournal = new Generaljournals();
			$ob->tid=$exptransactions->id;
			$ob->documentno="$obj->documentno";
			$ob->remarks=$exptransactions->remarks;
			if($obj->expenseid!='NULL'){
			$ob->memo='Expense '.$obj->expensename.' documentno '.$obj->documentno;
			}
			elseif($obj->assetid!='NULL'){
			$ob->memo='Expense '.$obj->assetname.' documentno '.$obj->documentno;
			}
			elseif($obj->liabilityid!='NULL'){
			$ob->memo='Expense '.$obj->liabilityname.' documentno '.$obj->documentno;
			}
			$ob->accountid=$generaljournalaccounts->id;
			$ob->daccountid=$generaljournalaccounts2->id;
			$ob->transactionid=$transaction->id;
			$ob->mode="$obj->purchasemodeid";
			
			$ob->rate=$obj->exchangerate;
			$ob->eurorate=$obj->exchangerate2;
			$ob->debit=($obj->amount*$obj->quantity);			
			$ob->credit=0;
			$ob->debiteuro=($obj->amount*$obj->quantity);
			$ob->crediteuro=0;
			$ob->debitorig=($obj->amount*$obj->quantity);
		
			$ob->class=$obj->projectid;
			$ob->credit=0;
			$generaljournal = $generaljournal->setObject($ob);
		
			$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		
			$it++;
			
			if($obj->taxamount>0){
				  
				  $vatclasses = new Vatclasses();
				  $fields="*";
				  $where=" where id='$obj->vatclasseid'";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $vatclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $vatclasses->sql;
				  $vatclasses=$vatclasses->fetchObject;
				  
				  $generaljournalaccounts2 = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid ='$vatclasses->liabilityid' and acctypeid=35 ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts2->sql;
				  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
				  
				  //make debit entry
				  $generaljournal = new Generaljournals();
				  $ob->tid=$purchasedetails->id;
				  $ob->documentno="$obj->documentno";
				  $ob->remarks="Expense on Document $obj->documentno";
				  $ob->memo=$purchasedetails->remarks;
				  $ob->accountid=$generaljournalaccounts2->id;
				  $ob->daccountid=$generaljournalaccounts->id;
				  $ob->transactionid=$transaction->id;
				  $ob->mode="credit";
				  $ob->rate=$obj->rate;
				  $ob->eurorate=$obj->eurorate;
				  $ob->debit=$obj->taxamount;
				  $ob->credit=0;
				  $ob->class=$obj->projectid;
				  $generaljournal = $generaljournal->setObject($ob);

				  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
				  $it++;
				}
		}

				//Make a journal entry

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
		  
		  if($obj->paymentmodeid==1 or $obj->paymentmodeid==5)
		      $obj->bankid=$obj->imprestaccountid;
		      
		      
		  if($obj->paymentmodeid==1){
			  $acctype=24;
			  $obj->bankid=$obj->imprestaccountid;
		  }
		  if($obj->paymentmodeid==2 or $obj->paymentmodeid==5){
			  $acctype=8;
			  $obj->bankid=$obj->bankid;
		  }
		  if($obj->paymentmodeid==7){
			  $acctype=24;
			  $obj->bankid=$obj->imprestaccountid;
		  }
		  if($obj->paymentmodeid==11){
			  $acctype=36;
			  $obj->bankid=$obj->employeeid;
			  $obj->names=$obj->employeename;
		  }
		}
		else{
		  $acctype=30;
		  $obj->bankid=$obj->supplierid;
		}

				//retrieve account to credit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->bankid' and acctypeid='$acctype'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts->sql.'g2';
		$generaljournalaccounts=$generaljournalaccounts->fetchObject;

				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$exptransactions->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks="Expenses on Document No $obj->documentno";		
		if($obj->expenseid!='NULL'){
		$ob->memo=$generaljournalaccounts->name.' for Expense '.$obj->expensename;
		}
		elseif($obj->assetid!='NULL'){
		$ob->memo=$generaljournalaccounts->name.' for Expense '.$obj->assetname;
		}
		elseif($obj->liabilityid!='NULL'){
		$ob->memo=$generaljournalaccounts->name.' for Expense '.$obj->liabilityname;
		}		
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="$obj->purchasemodeid";		
		$ob->rate=$obj->exchangerate;
		$ob->eurorate=$obj->exchangerate2;
		$ob->credit=$total;	
		$ob->balance = $total;
		$ob->debit=0;
		$ob->crediteuro=$total;
		$ob->debiteuro=0;
		$ob->creditorig=$total;
		$ob->debitorig=0;
		
		$ob->class=$obj->projectid;
		$ob->did=$generaljournal->id;
		$generaljournal2 = $generaljournal2->setObject($ob);
		
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'balance'=>"$generaljournal2->balance",'credit'=>"$generaljournal2->credit",'debiteuro'=>"$generaljournal2->debiteuro",'crediteuro'=>"$generaljournal2->crediteuro",'debitorig'=>"$generaljournal2->debitorig",'creditorig'=>"$generaljournal2->creditorig",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'eurorate'=>"$generaljournal2->eurorate",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");

		$gn= new Generaljournals();//print_r($shpgeneraljournals);
		$gn->add($obj,$shpgeneraljournals);

		return true;	
	}			
	function edit($obj,$shop){
		$exptransactionsDBO = new ExptransactionsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
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
                
                $obj->currencyid=$obj->currencyid;
                $obj->rate=$obj->exchangerate;
		$obj->eurorate=$obj->exchangerate2;
		$obj->transactdate=$obj->expensedate;
		
		$it=0;
		$id="'-1',";
		while($i<$num){		
			$obj->expenseid=$shop[$i]['expenseid'];
			$obj->expensename=$shop[$i]['expensename'];
			$obj->assetid=$shop[$i]['assetid'];
			$obj->assetname=$shop[$i]['assetname'];
			$obj->liabilityid=$shop[$i]['liabilityid'];
			$obj->liabilityname=$shop[$i]['liabilityname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->vatclasseid=$shop[$i]['vatclasseid'];
			$obj->taxamount=$shop[$i]['taxamount'];
			$obj->tax=$shop[$i]['tax'];
			$obj->discount=$shop[$i]['discount'];
			$obj->amount=$shop[$i]['amount'];
			$obj->total=$shop[$i]['total'];
			$obj->memo=$shop[$i]['memo'];
			$obj->id=$shop[$i]['id'];
			$total+=$obj->total;
			
			if(!empty($shop[$i]['id']))
			{ 			    
			    $exptransactions=new Exptransactions();
			    $objs=$exptransactions->setObject($obj);
			    $where=" id='$objs->id' ";
			    if($exptransactionsDBO->update($objs,$where)){		
			      $id.=$shop[$i]['id'].",";
			    }
			
			}
			else{
			    $exptransactions=new Exptransactions();
			    $objs=$exptransactions->setObject($obj);
			    if($exptransactionsDBO->persist($objs)){		
			      $id.=$exptransactionsDBO->id.",";
			      $this->sql=$exptransactionsDBO->sql;
			     }
			}		
			$i++;
			
					//retrieve account to debit
					//retrieve account to debit
		        if($obj->expenseid!='NULL'){
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->expenseid' and acctypeid='4'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;
			}
			elseif($obj->assetid!='NULL'){
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->assetid' and acctypeid='7'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;
			}
			 elseif($obj->liabilityid!='NULL'){
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->liabilityid' and acctypeid='35'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;
			}
			
			//make debit entry
			$generaljournal = new Generaljournals();
			$ob->tid=$exptransactions->id;
			$ob->documentno="$obj->documentno";
			$ob->remarks=$exptransactions->remarks;
			if($obj->expenseid!='NULL'){
			$ob->memo='Expense '.$obj->expensename.' documentno '.$obj->documentno;
			}
			elseif($obj->assetid!='NULL'){
			$ob->memo='Expense '.$obj->assetname.' documentno '.$obj->documentno;
			}
			elseif($obj->liabilityid!='NULL'){
			$ob->memo='Expense '.$obj->liabilityname.' documentno '.$obj->documentno;
			}
			$ob->accountid=$generaljournalaccounts->id;
			$ob->daccountid=$generaljournalaccounts2->id;
			$ob->transactionid=$transaction->id;
			$ob->mode="$obj->purchasemodeid";
			
			$ob->rate=$obj->exchangerate;
			$ob->eurorate=$obj->exchangerate2;
			$ob->debit=($obj->amount*$obj->quantity);			
			$ob->credit=0;
			$ob->debiteuro=($obj->amount*$obj->quantity);
			$ob->crediteuro=0;
			$ob->debitorig=($obj->amount*$obj->quantity);
			$ob->creditorig=0;
		
			$ob->class=$obj->projectid;
			$ob->credit=0;
			$generaljournal = $generaljournal->setObject($ob);
		
			$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'debiteuro'=>"$generaljournal->debiteuro",'crediteuro'=>"$generaljournal->crediteuro",'debitorig'=>"$generaljournal->debitorig",'creditorig'=>"$generaljournal->creditorig",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		
			$it++;
			
			if($obj->taxamount>0){
				  
				  $vatclasses = new Vatclasses();
				  $fields="*";
				  $where=" where id='$obj->vatclasseid'";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $vatclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $vatclasses->sql;
				  $vatclasses=$vatclasses->fetchObject;
				  
				  $generaljournalaccounts2 = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid ='$vatclasses->liabilityid' and acctypeid=35 ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts2->sql;
				  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
				  
				  //make debit entry
				  $generaljournal = new Generaljournals();
				  $ob->tid=$purchasedetails->id;
				  $ob->documentno="$obj->documentno";
				  $ob->remarks="Expense on Document $obj->documentno";
				  $ob->memo=$purchasedetails->remarks;
				  $ob->accountid=$generaljournalaccounts2->id;
				  $ob->daccountid=$generaljournalaccounts->id;
				  $ob->transactionid=$transaction->id;
				  $ob->mode="credit";
				  $ob->rate=$obj->rate;
				  $ob->eurorate=$obj->eurorate;
				  $ob->debit=$obj->taxamount;
				  $ob->credit=0;
				  $ob->class=$obj->projectid;
				  $generaljournal = $generaljournal->setObject($ob);

				  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
				  $it++;
				}
		}
                $wid=substr($id,0,-1);		
		$exptransactionsDBO = new ExptransactionsDBO();
		$where=" where id not in ($wid) and documentno='$obj->documentno' ";
		$exptransactionsDBO->delete($obj,$where);
				//Make a journal entry

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
		  
		  if($obj->paymentmodeid==1 or $obj->paymentmodeid==5)
		      $obj->bankid=1;
		      
		      
		  if($obj->paymentmodeid==1){
			  $acctype=24;
			  $obj->bankid=1;
		  }
		  if($obj->paymentmodeid==2 or $obj->paymentmodeid==5){
			  $acctype=8;
			  $obj->bankid=$obj->bankid;
		  }
		  if($obj->paymentmodeid==7){
			  $acctype=24;
			  $obj->bankid=$obj->imprestaccountid;
		  }
		  if($obj->paymentmodeid==11){
			  $acctype=36;
			  $obj->bankid=$obj->employeeid;
			  $obj->names=$obj->employeename;
		  }
		}
		else{
		  $acctype=30;
		  $obj->bankid=$obj->supplierid;
		}

				//retrieve account to credit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->bankid' and acctypeid='$acctype'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);/*echo $generaljournalaccounts->sql.'g2';*/
		$generaljournalaccounts=$generaljournalaccounts->fetchObject;

				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$exptransactions->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks="Expenses on Document No $obj->documentno";		
		if(!empty($obj->expenseid)){
		$ob->memo=$generaljournalaccounts->name.' for Expense '.$obj->expensename;
		}
		elseif(!empty($obj->assetid)){
		$ob->memo=$generaljournalaccounts->name.' for Expense '.$obj->assetname;
		}
		elseif(!empty($obj->liabilityid)){
		$ob->memo=$generaljournalaccounts->name.' for Expense '.$obj->liabilityname;
		}		
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="$obj->purchasemodeid";		
		$ob->rate=$obj->exchangerate;
		$ob->eurorate=$obj->exchangerate2;
		$ob->credit=$total;	
		$ob->debit=0;
		$ob->crediteuro=$total;
		$ob->debiteuro=0;
		$ob->creditorig=$total;
		$ob->debitorig=0;
		
		$ob->class=$obj->projectid;
		$ob->did=$generaljournal->id;
		$generaljournal2 = $generaljournal2->setObject($ob);
		
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'debiteuro'=>"$generaljournal2->debiteuro",'crediteuro'=>"$generaljournal2->crediteuro",'debitorig'=>"$generaljournal2->debitorig",'creditorig'=>"$generaljournal2->creditorig",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'eurorate'=>"$generaljournal2->eurorate",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");

		$gn= new Generaljournals();
		$gn->edit($obj,$where="",$shpgeneraljournals);

		
                 
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
	
	  if(empty($obj->currencyid)){
			$error="exchange rate must be provided";
		}
	 if ($obj->purchasemodeid==2 and empty($obj->supplierid) ){
			$error="Supplier should be provided";
		}
	 if ($obj->purchasemodeid==1 and empty($obj->paymentmodeid) ){
			$error="Payment Mode should be provided";
		}
	elseif(empty($obj->purchasemodeid))	{
	  $error="Purchase Mode should be provided";
	}
	else if(($obj->paymentmodeid==2 or $obj->paymentmodeid==5 or $obj->paymentmodeid==6) and empty($obj->bankid)){
	      $error="Bank must be provided";
	}
	else if($obj->paymentmodeid==11 and empty($obj->employeeid)){
	    $error="Imprest Account must be provided";
	}
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	  if(empty($obj->currencyid)){
			$error="exchange rate must be provided";
		}
	if ($obj->purchasemodeid==2 and empty($obj->supplierid) ){
			$error="Supplier should be provided";
		}
	 if ($obj->purchasemodeid==1 and empty($obj->paymentmodeid) ){
			$error="Payment Mode should be provided";
		}
	elseif(empty($obj->purchasemodeid))	{
	  $error="Purchase Mode should be provided";
	}
	else if(($obj->paymentmodeid==2 or $obj->paymentmodeid==5 or $obj->paymentmodeid==6) and empty($obj->bankid)){
	      $error="Bank must be provided";
	}
	else if($obj->paymentmodeid==11 and empty($obj->employeeid)){
	    $error="Imprest Account must be provided";
	}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
