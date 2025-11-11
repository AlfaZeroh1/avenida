<?php 
require_once("TenantpaymentsDBO.php");
class Tenantpayments
{				
	var $id;			
	var $tenantid;		
	var $houseid;
	var $documentno;			
	var $paymenttermid;			
	var $paymentmodeid;			
	var $bankid;			
	var $chequeno;			
	var $amount;	
	var $commission;
	var $commissiontype;
	var $paidon;			
	var $month;			
	var $year;			
	var $paidby;			
	var $remarks;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $tenantpaymentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->tenantid=str_replace("'","\'",$obj->tenantid);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->paymenttermid=str_replace("'","\'",$obj->paymenttermid);
		$this->paymentmodeid=str_replace("'","\'",$obj->paymentmodeid);
		$this->bankid=str_replace("'","\'",$obj->bankid);
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->commission=str_replace("'","\'",$obj->commission);
		$this->commissiontype=str_replace("'","\'",$obj->commissiontype);
		$this->paidon=str_replace("'","\'",$obj->paidon);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->paidby=str_replace("'","\'",$obj->paidby);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->houseid=str_replace("'","\'",$obj->houseid);
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

	//get tenantid
	function getTenantid(){
		return $this->tenantid;
	}
	//set tenantid
	function setTenantid($tenantid){
		$this->tenantid=$tenantid;
	}
	
	//get houseid
	function getHouseid(){
		return $this->houseid;
	}
	//set houseid
	function setHouseid($houseid){
		$this->houseid=$houseid;
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

	//get paidby
	function getPaidby(){
		return $this->paidby;
	}
	//set paidby
	function setPaidby($paidby){
		$this->paidby=$paidby;
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

	function add($obj,$shop,$bool=true){//print_r($obj);
		$tenantpaymentsDBO = new TenantpaymentsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		$commission=0;
		$it=0;
		
		$lp = new Landlordpayables();
		$fields="(max(documentno)+1) documentno";
		$where=" ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$lp->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$lp=$lp->fetchObject;
		
		if($lp->documentno==NULL or $lp->documentno=="NULL")
		  $lp->docuemntno=1;
		
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='tenantpayments'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		if(empty($obj->retrieve)){
		  $defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) as documentno from em_tenantpayments"));
		  if($defs->documentno == null){
			  $defs->documentno=1;
		  }
		  $obj->documentno=$defs->documentno;
		}
		
		if(!$bool){
		  $obj->retrieve="";
		}
		
		$hse = new Houses();
		$fields="em_houses.*, em_plots.name plot, em_plots.commission,em_plots.commissiontype";
		$join=" left join em_plots on em_plots.id=em_houses.plotid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_houses.id='$obj->houseid' ";
		$hse->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$hse=$hse->fetchObject;
		
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
					
			$obj->bankid=$obj->lplotid;
		}
		
		
		      
		$shpgeneraljournals=array();
		$ex=0;
		while($i<$num){

			$obj->paymenttermid=$shop[$i]['paymenttermid'];
			
			$paymentterms = new Paymentterms();
			$fields="*";
			$where=" where id='$obj->paymenttermid' ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$paymentterms=$paymentterms->fetchObject;
			
			
			$obj->paymenttermname=$shop[$i]['paymenttermname'];
			$obj->amount=$shop[$i]['amount'];
			$obj->remarks=$shop[$i]['remarks'];
			$obj->month=$shop[$i]['month'];
			$obj->year=$shop[$i]['year'];
			$obj->houseid=$shop[$i]['houseid'];
			$obj->commission=$shop[$i]['commission'];
			$obj->commissiontype=$shop[$i]['commissiontype'];
			
			if(!empty($shop[$i]['createdon'])){
			  $obj->createdon=$shop[$i]['createdon'];
			  $obj->createdby=$shop[$i]['createdby'];
			}
			
			if($obj->paymentmodeid==5){
				//$acctype=24;
				
				$shpexptransactions[$ex]=array('expenseid'=>"2", 'expensename'=>"Offset Expense", 'paymentid'=>"", 'paymentname'=>"",'plotid'=>"$obj->lplotid",'plotname'=>"$obj->lplotname", 'tenantid'=>"$obj->tenantid",'tenantname'=>"$obj->tenantname",'paymenttermid'=>"$obj->paymenttermid" ,'paymenttermname'=>"$paymentterms->name", 'quantity'=>"1", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'amount'=>"$obj->amount", 'memo'=>"$obj->memo (Offset Payment)", 'total'=>"$obj->amount",'month'=>"$obj->month",'year'=>"$obj->year");
				
				$ex++;				
				
				$obj->bankid=$obj->lplotid;
			}
						
			$total+=$obj->amount;		
			
			$obj->transactdate=$obj->paidon;
						
			if($tenantpaymentsDBO->persist($obj,$bool)){
				//$this->id=$tenantpaymentsDBO->id;
				$this->sql=$tenantpaymentsDBO->sql;			
				
				
				//record tenant deposits
				if($paymentterms->type=="Special Deposit"){
				  $tenantdeposits = new Tenantdeposits();
				  $tenantdeposits->tenantid=$obj->tenantid;
				  $tenantdeposits->houseid=$obj->houseid;
				  $tenantdeposits->tenantpaymentid=$tenantpaymentsDBO->id;
				  $tenantdeposits->paymenttermid=$paymentterms->id;
				  $tenantdeposits->paidon=$obj->paidon;
				  $tenantdeposits->remarks=$obj->remarks;
				  $tenantdeposits->status=2;
				  $tenantdeposits->amount=$obj->amount;
				  
				  //retrieve houserenting record
				  $houserentings = new Houserentings();
				  $fields="*";
				  $join=" ";
				  $having="";
				  $groupby="";
				  $orderby=" order by id desc";
				  $where=" where houseid='$obj->houseid' and tenantid='$obj->tenantid'";
				  $houserentings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				  $houserentings = $houserentings->fetchObject;
				  
				  $tenantdeposits->houserentingid=$houserentings->id;
				}
				
				//if($paymentterms->payabletolandlord=="Yes"){
				    //record commission income transaction
				    
				    $inc->amount=0;
				    //if special deposit and its payable to landlord, push it bila mgt fee
				    if($paymentterms->payabletolandlord=="Yes"){
					if($paymentterms->type=="Special Deposit"){	
					  $tenantdeposits->status=1;
					}
				      
				      //if we charge management fee, recognize it first
					if($paymentterms->chargemgtfee=="Yes"){
					    
					    //retrieve house landlord
					    $houses = new Houses();
					    $fields=" em_plots.id plotid, em_plots.landlordid,em_plots.commission,em_plots.commissiontype,em_plots.deductcommission ";
					    $having="";
					    $groupby="";
					    $orderby="";
					    $where=" where em_houses.id='$obj->houseid'";
					    $join=" left join em_plots on em_plots.id=em_houses.plotid ";
					    $houses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
					    $houses = $houses->fetchObject;
					    
					    if($houses->deductcommission=="Yes"){
						    
						    //record income
						    $inctransaction = new Inctransactions();
						    $inc->incomeid=1;
						    if($houses->commissiontype==1)
							    $inc->amount=$obj->amount*$houses->commission/100;			
						    else
							    $inc->amount=$houses->commission;
						    
						    if($paymentterms->type=="Special Deposit"){	
						      $tenantdeposits->amount=($obj->amount-$inc->amount);
						    }
					  
						    $inc->ref=$tenantpaymentsDBO->id;
						    $inc->paymentmodeid=5;
						    $inc->bankid=$houses->plotid;
						    $inc->documentno=$obj->documentno;
						    $inc->incomedate=$obj->paidon;
						    $inc->remarks="Management Fee ".$hse->plot." # ".$hse->hseno;
						    $inc->remarks="Mgt Fee on $obj->houseid for ".getMonth($obj->month)." $obj->year";
						    $inc = $inctransaction->setObject($inc);
						    
						    if($inc->amount!=0){
							    $inctransactionDBO = new InctransactionsDBO();
							    $inctransactionDBO->persist($inc,true);
							    $generaljournal0 = new Generaljournals();
							    $ob->tid=$tenantpayments->id;
							    $ob->documentno="$obj->documentno";
							    $ob->remarks="Management Fee ".$hse->plot." # ".$hse->hseno;
							    $ob->memo=$tenantpayments->remarks;
							    $ob->accountid=8;
							    $ob->transactionid=$transaction->id;
							    $ob->mode=$obj->paymentmodeid;
							    $ob->class="B";
							    $ob->debit=0;
							    $ob->credit=$inc->amount;
							    $generaljournal0->setObject($ob);
							    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal0->accountid", 'documentno'=>"$generaljournal0->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts0->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal0->remarks", 'debit'=>"$generaljournal0->debit", 'credit'=>"$generaljournal0->credit", 'total'=>"$generaljournal0->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal0->transactionid",'memo'=>"$generaljournal0->memo");
		    
							    $it++;
						    }
					    }
					    
					    //make a journal entry for it
					    //debit landlord account as an expense
					    
					    //credit mgt fee income account
				    }
				      
				      //retrieve Landlord and credit
				      $plots = new Plots();
				      $fields="em_plots.landlordid, em_plots.id";
				      $join=" left join em_houses on em_houses.plotid=em_plots.id";
				      $where=" where em_houses.id='$obj->houseid' ";
				      $having="";
				      $groupby="";
				      $orderby="";
				      $plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				      $plots = $plots->fetchObject;
				      
				      
				      //add a landlord payable transaction
				      $landlordpayables = new Landlordpayables();
				      $landlordpayables->documentno=$lp->documentno;
				      $landlordpayables->receiptno=$obj->documentno;
				      $landlordpayables->landlordid=$plots->landlordid;
				      $landlordpayables->plotid=$plots->id;
				      $landlordpayables->paymenttermid=$obj->paymenttermid;
				      $landlordpayables->invoicedon=$obj->paidon;
				      $landlordpayables->month=$obj->month;
				      $landlordpayables->year=$obj->year;
				      $landlordpayables->quantity=1;
				      $landlordpayables->amount=$obj->amount-$inc->amount;
				      $landlordpayables->remarks="Payment from ".$obj->tenantname." ".$hse->plot." # ".$hse->hseno;
				      $landlordpayables->memo=$tenantpayments->remarks;
				      $landlordpayables->createdby=$_SESSION['userid'];
				      $landlordpayables->createdon=date("Y-m-d H:i:s");
				      $landlordpayables->lasteditedby=$_SESSION['userid'];
				      $landlordpayables->lasteditedon=date("Y-m-d H:i:s");
				      $lp = $landlordpayables->setObject($landlordpayables);
				      
				      $landlordpayablesDBO = new LandlordpayablesDBO();
				      $landlordpayablesDBO->persist($lp);
				      
					    //retrieve account to debit
				      $generaljournalaccounts2 = new Generaljournalaccounts();
				      $fields="*";
				      $where=" where refid='$plots->landlordid' and acctypeid='33'";
				      $join="";
				      $having="";
				      $groupby="";
				      $orderby="";
				      $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				      $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
				      
				      $generaljournal0 = new Generaljournals();
				      $ob->tid=$tenantpayments->id;
				      $ob->documentno="$obj->documentno";
				      $ob->remarks="Payment from $obj->tenantname ".$hse->plot." # ".$hse->hseno;
				      $ob->memo=$tenantpayments->remarks;
				      $ob->accountid=$generaljournalaccounts2->id;
				      $ob->transactionid=$transaction->id;
				      $ob->mode=$obj->paymentmodeid;
				      $ob->class="B";
				      $ob->debit=0;
				      $ob->credit=$obj->amount-$inc->amount;
				      $generaljournal0->setObject($ob);
				      $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal0->accountid", 'documentno'=>"$generaljournal0->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts0->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal0->remarks", 'debit'=>"$generaljournal0->debit", 'credit'=>"$generaljournal0->credit", 'total'=>"$generaljournal0->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal0->transactionid",'memo'=>"$generaljournal0->memo");

				      $it++;
				    }
				    //if its income
				    else if($paymentterms->type=="Income"){
				      $generaljournalaccounts2 = new Generaljournalaccounts();
				      $fields="*";
				      $where=" where id='$paymentterms->generaljournalaccountid' and acctypeid='1'";
				      $join="";
				      $having="";
				      $groupby="";
				      $orderby="";
				      $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				      $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
				      $generaljournalaccounts2->id=$paymentterms->generaljournalaccountid;
				      
				      $inctransaction = new Inctransactions();
				      $inc->incomeid=$generaljournalaccounts->refid;
				      $inc->ref=$tenantpaymentsDBO->id;
				      $inc->paymentmodeid=$obj->paymentmodeid;
				      $inc->bankid=$obj->bankid;
				      $inc->documentno=$obj->documentno;
				      $inc->incomedate=$obj->paidon;
				      $inc->remarks=initialCap($paymentterms->name)." for ".getMonth($obj->month)." $obj->year ".$hse->plot." # ".$hse->hseno;
				      $inc->amount=$obj->amount;
				      //$inc->remarks="Mgt Fee on $obj->houseid for ".getMonth($obj->month)." $obj->year ".$hse->plot." # ".$hse->hseno;
				      $inc = $inctransaction->setObject($inc);
				      
				      if($inc->amount!=0){
					      $inctransactionDBO = new InctransactionsDBO();
					      $inctransactionDBO->persist($inc);
					      $generaljournal0 = new Generaljournals();
					      $ob->tid=$tenantpayments->id;
					      $ob->documentno="$obj->documentno";
					      $ob->remarks=$inc->remarks;
					      $ob->memo=$tenantpayments->remarks;
					      $ob->accountid=$generaljournalaccounts2->id;
					      $ob->transactionid=$transaction->id;
					      $ob->mode=$obj->paymentmodeid;
					      $ob->class="B";
					      $ob->debit=0;
					      $ob->credit=$inc->amount;
					      $generaljournal0->setObject($ob);
					      $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal0->accountid", 'documentno'=>"$generaljournal0->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts0->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal0->remarks", 'debit'=>"$generaljournal0->debit", 'credit'=>"$generaljournal0->credit", 'total'=>"$generaljournal0->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal0->transactionid",'memo'=>"$generaljournal0->memo");
      
					      $it++;
				      }
				    }
				    
				     else{ //if($paymentterms->type="Special Deposit"){
					    $generaljournal0 = new Generaljournals();
					      $ob->tid=$tenantpayments->id;
					      $ob->documentno="$obj->documentno";
					      $ob->remarks="Special Deposit";
					      $ob->memo=$tenantpayments->remarks;
					      $ob->accountid=$paymentterms->generaljournalaccountid;
					      $ob->transactionid=$transaction->id;
					      $ob->mode=$obj->paymentmodeid;
					      $ob->class="B";
					      $ob->debit=0;
					      $ob->credit=$obj->amount;
					      $generaljournal0->setObject($ob);
					      $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal0->accountid", 'documentno'=>"$generaljournal0->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts0->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal0->remarks", 'debit'=>"$generaljournal0->debit", 'credit'=>"$generaljournal0->credit", 'total'=>"$generaljournal0->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal0->transactionid",'memo'=>"$generaljournal0->memo");
      
					      $it++;
				     }
				    
				   if($paymentterms->type=="Special Deposit"){	
					  $tenantdeposits = $tenantdeposits->setObject($tenantdeposits);
					  $tenantdeposits->add($tenantdeposits);
					} 
				//}
			}
			
			$i++;
		}
		
		//debit receivable account
		$generaljournal0 = new Generaljournals();
		$ob->tid=$tenantpayments->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Tenant Payment ".$hse->plot." # ".$hse->hseno;
		$ob->memo=$tenantpayments->remarks;
		$ob->accountid=6;
		$ob->transactionid=$transaction->id;
		$ob->mode=$obj->paymentmodeid;
		$ob->class="B";
		$ob->debit=$total;
		$ob->credit=0;
		$generaljournal0->setObject($ob);
		$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal0->accountid", 'documentno'=>"$generaljournal0->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts0->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal0->remarks", 'debit'=>"$generaljournal0->debit", 'credit'=>"$generaljournal0->credit", 'total'=>"$generaljournal0->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal0->transactionid");

		$it++;
		//Make a journal entry
		//debit client acc bank and credit account receivable
				//retrieve account to credit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->tenantid' and acctypeid='32'";
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
				
// 		if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid))
// 		  $obj->bankid=$obj->imprestaccountid;
// 		  
// 		if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
// 			$obj->bankid=1;
// 		}
		
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

				//make credit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$tenantpayments->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Payment for the month ".getMonth($obj->month)." ".$obj->year." ".$hse->plot." # ".$hse->hseno;
		$ob->memo=$tenantpayments->remarks;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode=$obj->paymentmodeid;
		$ob->class="B";
		$ob->debit=0;
		$ob->credit=$total;
		$generaljournal->setObject($ob);
		//$generaljournal->add($generaljournal);
		
		$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal->transactionid");
		
		$it++;
		
				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$tenantpayments->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks="Receipt from ".$obj->tenantname." ".$hse->plot." # ".$hse->hseno;
		$ob->memo=$tenantpayments->remarks;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode=$obj->paymentmodeid;
		$ob->debit=$total;
		$ob->credit=0;
		$ob->class="B";
		$ob->did=$generaljournal->id;
		$generaljournal2->setObject($ob);
		//$generaljournal2->add($generaljournal2);

		$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal2->transactionid");
			
		$it++;
		
		$exptransactions = new Exptransactions();
		$exptransactions->expensedate=$obj->paidon;
		$exptransactions->documentno=$obj->documentno;
		
		$exptransactions->add($exptransactions,$shpexptransactions,true);

		$gn = new Generaljournals();
		$gn->add($obj, $shpgeneraljournals);		
		
		return $obj->documentno;	
	}			
	function edit($obj,$where="",$shop){
		$tenantpaymentsDBO = new TenantpaymentsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$tenantpaymentsDBO->delete($obj,$where);
		
		$landlordpayables = new Landlordpayables();
		$where=" where receiptno='$obj->documentno' ";
		$landlordpayables->delete($obj,$where);
		
		$exptransactions = new Exptransactions();
		$where=" where voucherno='$obj->documentno' and expenseid=2 ";
		$exptransactions->delete($obj,$where,true);

		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='tenantpayments'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$gn = new GeneralJournals();
		$where=" where documentno='$obj->documentno' and transactionid='$transaction->id' ";
		$gn->delete($obj,$where);
		
		$tenantpayments = new Tenantpayments();

		$tenantpayments->add($obj,$shop);

		return true;	
	}			
	function delete($obj,$where=""){			
		$tenantpaymentsDBO = new TenantpaymentsDBO();
		if($tenantpaymentsDBO->delete($obj,$where=""))		
			$this->sql=$tenantpaymentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$tenantpaymentsDBO = new TenantpaymentsDBO();
		$this->table=$tenantpaymentsDBO->table;
		$tenantpaymentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$tenantpaymentsDBO->sql;
		$this->result=$tenantpaymentsDBO->result;
		$this->fetchObject=$tenantpaymentsDBO->fetchObject;
		$this->affectedRows=$tenantpaymentsDBO->affectedRows;
	}			
	function validate($obj){
	
		
		
		if(empty($obj->tenantid)){
			$error="Tenant should be provided";
		}
		else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
		else if($obj->paymentmodeid==2 and empty($obj->chequeno)){
			$error="Cheque No should be provided";
		}
		else if(empty($obj->paidon)){
			$error="Paid On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->tenantid)){
			$error="Tenant should be provided";
		}
		else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
		else if(empty($obj->paidon)){
			$error="Paid On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
