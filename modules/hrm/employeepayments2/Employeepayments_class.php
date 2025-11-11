<?php 
require_once("EmployeepaymentsDBO.php");
class Employeepayments
{				
	var $id;			
	var $employeeid;			
	var $assignmentid;			
	var $paymentmodeid;			
	var $bankid;			
	var $employeebankid;			
	var $bankbrancheid;			
	var $bankacc;			
	var $clearingcode;			
	var $ref;			
	var $month;			
	var $year;
	var $fromdate;
	var $todate;
	var $basic;			
	var $allowances;			
	var $deductions;			
	var $netpay;			
	var $paidon;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $employeepaymentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->assignmentid))
			$obj->assignmentid='NULL';
		$this->assignmentid=$obj->assignmentid;
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		if(empty($obj->employeebankid))
			$obj->employeebankid='NULL';
		$this->employeebankid=$obj->employeebankid;
		if(empty($obj->bankbrancheid))
			$obj->bankbrancheid='NULL';
		$this->bankbrancheid=$obj->bankbrancheid;
		$this->bankacc=str_replace("'","\'",$obj->bankacc);
		$this->clearingcode=str_replace("'","\'",$obj->clearingcode);
		$this->ref=str_replace("'","\'",$obj->ref);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->fromdate=str_replace("'","\'",$obj->fromdate);
		$this->todate=str_replace("'","\'",$obj->todate);
		$this->basic=str_replace("'","\'",$obj->basic);
		$this->allowances=str_replace("'","\'",$obj->allowances);
		$this->deductions=str_replace("'","\'",$obj->deductions);
		$this->netpay=str_replace("'","\'",$obj->netpay);
		$this->paidon=str_replace("'","\'",$obj->paidon);
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

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get assignmentid
	function getAssignmentid(){
		return $this->assignmentid;
	}
	//set assignmentid
	function setAssignmentid($assignmentid){
		$this->assignmentid=$assignmentid;
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

	//get employeebankid
	function getEmployeebankid(){
		return $this->employeebankid;
	}
	//set employeebankid
	function setEmployeebankid($employeebankid){
		$this->employeebankid=$employeebankid;
	}

	//get bankbrancheid
	function getBankbrancheid(){
		return $this->bankbrancheid;
	}
	//set bankbrancheid
	function setBankbrancheid($bankbrancheid){
		$this->bankbrancheid=$bankbrancheid;
	}

	//get bankacc
	function getBankacc(){
		return $this->bankacc;
	}
	//set bankacc
	function setBankacc($bankacc){
		$this->bankacc=$bankacc;
	}

	//get clearingcode
	function getClearingcode(){
		return $this->clearingcode;
	}
	//set clearingcode
	function setClearingcode($clearingcode){
		$this->clearingcode=$clearingcode;
	}

	//get ref
	function getRef(){
		return $this->ref;
	}
	//set ref
	function setRef($ref){
		$this->ref=$ref;
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

	//get basic
	function getBasic(){
		return $this->basic;
	}
	//set basic
	function setBasic($basic){
		$this->basic=$basic;
	}

	//get allowances
	function getAllowances(){
		return $this->allowances;
	}
	//set allowances
	function setAllowances($allowances){
		$this->allowances=$allowances;
	}

	//get deductions
	function getDeductions(){
		return $this->deductions;
	}
	//set deductions
	function setDeductions($deductions){
		$this->deductions=$deductions;
	}

	//get netpay
	function getNetpay(){
		return $this->netpay;
	}
	//set netpay
	function setNetpay($netpay){
		$this->netpay=$netpay;
	}

	//get paidon
	function getPaidon(){
		return $this->paidon;
	}
	//set paidon
	function setPaidon($paidon){
		$this->paidon=$paidon;
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
		$employeepaymentsDBO = new EmployeepaymentsDBO();
		if($employeepaymentsDBO->persist($obj)){
			$this->id=$employeepaymentsDBO->id;
			$this->sql=$employeepaymentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$employeepaymentsDBO = new EmployeepaymentsDBO();
		if($employeepaymentsDBO->update($obj,$where)){
			$this->sql=$employeepaymentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$employeepaymentsDBO = new EmployeepaymentsDBO();
		if($employeepaymentsDBO->delete($obj,$where=""))		
			$this->sql=$employeepaymentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$employeepaymentsDBO = new EmployeepaymentsDBO();
		$this->table=$employeepaymentsDBO->table;
		$employeepaymentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$employeepaymentsDBO->sql;
		$this->result=$employeepaymentsDBO->result;
		$this->fetchObject=$employeepaymentsDBO->fetchObject;
		$this->affectedRows=$employeepaymentsDBO->affectedRows;
	}	
	
	//push salary transactions to general journal
	function generalJournal($gn,$obj){
	
	
	$configs = new Configs();
	$fields="hrm_configs.id, hrm_configs.name, hrm_configs.value";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$configs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res=$configs->result;
	while($con = mysql_fetch_object($res)){
	  if($con->id==3){
	    $provid=$con->value;
	  }
	  if($con->id==4){
	    $salariesid=$con->value;
	  }
	}
		
	$it=0;
	  foreach($gn as $key => $value){
	    if($key=='salaries'){
	    
	      foreach($value as $id => $amount){
		  
// 		  if($obj->paymentmodeid==1){
// 			  $acctype=24;
// 			  $refid=1;
// 		  }
// 		  else{
// 			  $acctype=8;
// 			  $refid=$obj->bankid;
// 		  }
// 				  
// 		  $paymentmodes = new Paymentmodes();
// 		  $fields=" * ";
// 		  $having="";
// 		  $groupby="";
// 		  $orderby="";
// 		  $where=" where id='$obj->paymentmodeid'";
// 		  $join=" ";
// 		  $paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 		  $paymentmodes = $paymentmodes->fetchObject;
// 		  
// 		  if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid))
// 		    $obj->bankid=$obj->imprestaccountid;
// 		    
// 		  if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
// 			  $obj->bankid=1;
// 		  }
				  //retrieve account to credit which is provision for salaries liability account as refid=1 acctypeid=35
		  $generaljournalaccounts2 = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$provid' and acctypeid='35'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		  
		  //account to debit
		  $generaljournalaccounts = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$salariesid' and acctypeid='4'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts=$generaljournalaccounts->fetchObject;

				  //make credit entry
		  $generaljournal = new Generaljournals();
		  $ob->remarks="Salaries for ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo="Salaries for ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts2->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->class="B";
		  $ob->debit=0;
		  $ob->credit=$amount;
		  $generaljournal->setObject($ob);
		  //$generaljournal->add($generaljournal);
		  
		  if(!empty($amount)){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal->transactionid");
		    
		    $it++;
		  }
			  //make credit entry
		  $generaljournal2 = new Generaljournals();
		  $ob->remarks="Salaries for ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo="Salaries for ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->debit=$amount;
		  $ob->credit=0;
		  $ob->class="B";
		  $ob->did=$generaljournal->id;
		  $generaljournal2->setObject($ob);
		  //$generaljournal2->add($generaljournal2);

		  if(!empty($amount)){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal2->transactionid");
			    
		    $it++;
		  }
	      }
	      
	    }
	    elseif($key=='allowances'){
	    $amount=0;
		foreach($value as $id => $amount){
		  //retrieve allowances
		  $allowances = new Allowances();
		  $fields="*";
		  $where=" where id='$id'";
		  $groupby="";
		  $orderby="";
		  $having="";
		  $join="";
		  $allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo "<br/>".$allowances->sql."<br/>";
		  $allowances = $allowances->fetchObject;		  
		  
				  //retrieve account to debit
		  $generaljournalaccounts2 = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$allowances->expenseid' and acctypeid='4'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo "<br/>".$generaljournalaccounts2->sql."<br/>";
		  
		  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		  
		  $generaljournalaccounts = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$provid' and acctypeid='35'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts->sql;
		  $generaljournalaccounts=$generaljournalaccounts->fetchObject;

				  //make credit entry
		  $generaljournal = new Generaljournals();
		  $ob->remarks=initialCap($allowances->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($allowances->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->class="B";
		  $ob->debit=0;
		  $ob->credit=$amount;
		  $generaljournal = $generaljournal->setObject($ob);
		  //$generaljournal->add($generaljournal);
		  
		  if($amount>0){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal->transactionid");
		  
		    $it++;
		  }
			  //make credit entry
		  $generaljournal2 = new Generaljournals();
		  $ob->remarks=initialCap($allowances->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($allowances->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts2->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->debit=$amount;
		  $ob->credit=0;
		  $ob->class="B";
		  $ob->did=$generaljournal->id;
		  $generaljournal2 = $generaljournal2->setObject($ob);
		  //$generaljournal2->add($generaljournal2);

		  if($amount>0){//echo $generaljournal2->accountid."<br/>";
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal2->transactionid");
			  
		    $it++;
		  }
	      }
	      
	    }elseif($key=='deductions'){
	      
	      foreach($value as $id => $amount){
		  //retrieve allowances
		  $deductions = new Deductions();
		  $fields="*";
		  $where=" where id='$id'";
		  $groupby="";
		  $orderby="";
		  $having="";
		  $join="";
		  $deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $deductions = $deductions->fetchObject;
		  
		  $acctypeid=35;
		  $refid=$deductions->liabilityid;
		  // NSSF
		  if($deductions->epays=="yes"){
		    //$refid=5;
		    $acctype=4;
		    
		    //debit NSSF Expenses account
		    $generaljournalaccounts = new Generaljournalaccounts();
		    $fields="*";
		    $where=" where refid='$salariesid' and acctypeid='4'";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		    $generaljournalaccounts=$generaljournalaccounts->fetchObject;
		    
		    	  //make debit entry
		    $generaljournal2 = new Generaljournals();
		    $ob->remarks=initialCap($deductions->name)." ".getMonth($obj->month)." ".$obj->year;
		    $ob->memo=initialCap($deductions->name)." ".getMonth($obj->month)." ".$obj->year." - EMPLOYER";
		    $ob->accountid=$generaljournalaccounts->id;
		    $ob->mode=$obj->paymentmodeid;
		    $ob->debit=$amount;
		    $ob->credit=0;
		    $ob->class="B";
		    $ob->did=$generaljournal->id;
		    $generaljournal2 = $generaljournal2->setObject($ob);
		    //$generaljournal2->add($generaljournal2);

		    if($amount>0){
		      $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal2->transactionid");
			    
		      $it++;
		    }
		  }
		  
				  //retrieve account to credit - Retrieve NSSF Account to credit
		  $generaljournalaccounts2 = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$deductions->liabilityid' and acctypeid='$acctypeid'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts2->sql;
		  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		  
		  //retrieve Account to debit - Debit Salries Expense Account
		  $generaljournalaccounts = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$provid' and acctypeid='35'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts->sql;
		  $generaljournalaccounts=$generaljournalaccounts->fetchObject;

				  //make credit entry
		  $generaljournal = new Generaljournals();
		  $ob->remarks=initialCap($deductions->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($deductions->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts2->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->class="B";
		  $ob->debit=0;
		  
		  if($deductions->epays=="yes")
		    $ob->credit=($amount*2);
		  else
		    $ob->credit=$amount;
		    
		  $generalJournal = $generaljournal->setObject($ob);
		  //$generaljournal->add($generaljournal);
		  
		  if($ob->credit>0){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal->transactionid");
		  
		    $it++;
		  }
			  //make debit entry
		  $generaljournal2 = new Generaljournals();
		  $ob->remarks=initialCap($deductions->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($deductions->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->debit=$amount;
		  $ob->credit=0;
		  $ob->class="B";
		  $ob->did=$generaljournal->id;
		  $generalJournal2 = $generaljournal2->setObject($ob);
		  //$generaljournal2->add($generaljournal2);

		  if($amount>0){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal2->transactionid");
			  
		    $it++;
		  }
	      }
	      
	    }elseif($key=='loans'){
	      
	      foreach($value as $id => $amount){
		  //retrieve allowances
		  $loans = new Loans();
		  $fields="*";
		  $where=" where id='$id'";
		  $groupby="";
		  $orderby="";
		  $having="";
		  $join="";
		  $loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $loans = $loans->fetchObject;
		  
		  $acctypeid=35;
		  $refid=$loans->liabilityid;
		  
				  //retrieve account to debit
		  $generaljournalaccounts2 = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$refid' and acctypeid='$acctypeid'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		  
		  $generaljournalaccounts = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$provid' and acctypeid='35'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts=$generaljournalaccounts->fetchObject;

				  //make credit entry
		  $generaljournal = new Generaljournals();
		  $ob->remarks=initialCap($loans->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($loans->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->daccountid=$generaljournalaccounts->id;
		  $ob->accountid=$generaljournalaccounts2->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->class="B";
		  $ob->debit=0;
		  $ob->credit=$amount;
		  $generaljournal->setObject($ob);
		  //$generaljournal->add($generaljournal);
		  
		  if($amount>0){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal->transactionid");
		  
		    $it++;
		  }
			  //make credit entry
		  $generaljournal2 = new Generaljournals();
		  $ob->remarks=initialCap($loans->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($loans->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts->id;
		  $ob->daccountid=$generaljournalaccounts2->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->debit=$amount;
		  $ob->credit=0;
		  $ob->class="B";
		  $ob->did=$generaljournal->id;
		  $generaljournal2->setObject($ob);
		  //$generaljournal2->add($generaljournal2);

		  if($amount>0){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal2->transactionid");
			  
		    $it++;
		  }
	      }
	      }elseif($key=='officeloans'){
	      
	      foreach($value as $id => $amount){//print_r($amount);
		//$id represents loan id
		for($m=0;$m<count($amount);$m++){
		  		 		  
		  $acctypeid=13;
		  $refid=$amount[$m][1];
		  
		  if($amount[$m][0]==1)
		    $refid="";
		  
		  $generaljournalaccounts = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$refid' and acctypeid='$acctypeid'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts=$generaljournalaccounts->fetchObject;

				  //make credit entry
		  $generaljournal = new Generaljournals();
		  $ob->remarks=initialCap($loans->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($loans->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->class="B";
		  $ob->debit=0;
		  $ob->credit=$amount;
		  $generaljournal->setObject($ob);
		  //$generaljournal->add($generaljournal);
		  
		  if(!empty($amount)){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal->transactionid");
		  
		    $it++;
		  }
		}
		  
		  
				  //retrieve account to debit
		  $generaljournalaccounts2 = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$salariesid' and acctypeid='4'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		  
		  
			  //make credit entry$generaljournalaccounts
		  $generaljournal2 = new Generaljournals();
		  $ob->remarks=initialCap($loans->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($loans->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts2->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->debit=$amount;
		  $ob->credit=0;
		  $ob->class="B";
		  $ob->did=$generaljournal->id;
		  $generaljournal2->setObject($ob);
		  //$generaljournal2->add($generaljournal2);

		  if(!empty($amount)){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal2->transactionid");
			  
		    $it++;
		  }
	      }
	      
	    }elseif($key=='interests'){
	      
	      foreach($value as $id => $amount){
		  //retrieve allowances
		  $loans = new Loans();
		  $fields="*";
		  $where=" where id='$id'";
		  $groupby="";
		  $orderby="";
		  $having="";
		  $join="";
		  $loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $loans = $loans->fetchObject;
		  
		  //$acctypeid=12;
		  
				  //retrieve account to debit
		  $generaljournalaccounts2 = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$loans->incomeid' and acctypeid='1'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		  
		  $generaljournalaccounts = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='2' and acctypeid='4'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts=$generaljournalaccounts->fetchObject;

				  //make credit entry
		  $generaljournal = new Generaljournals();
		  $ob->remarks=initialCap($loans->name)." Interest ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($loans->name)." Interest ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts2->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->class="B";
		  $ob->debit=0;
		  $ob->credit=$amount;
		  $generaljournal->setObject($ob);
		  //$generaljournal->add($generaljournal);
		  
		  if(!empty($amount)){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal->transactionid");
		    
		    $it++;
		  }
			  //make credit entry
		  $generaljournal2 = new Generaljournals();
		  $ob->remarks=initialCap($loans->name)." Interest ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($loans->name)." Interest ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->debit=$amount;
		  $ob->credit=0;
		  $ob->class="B";
		  $ob->did=$generaljournal->id;
		  $generaljournal2->setObject($ob);
		  //$generaljournal2->add($generaljournal2);

		  if(!empty($amount)){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal2->transactionid");
			    
		    $it++;
		  }
	      }
	      
	    }elseif($key=='surchages'){
	      
	      foreach($value as $id => $amount){
		  //retrieve allowances
		  $surchages = new Surchages();
		  $fields="*";
		  $where=" where id='$id'";
		  $groupby="";
		  $orderby="";
		  $having="";
		  $join="";
		  $surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $surchages = $surchages->fetchObject;
		  
		  //$acctypeid=12;
		  
				  //retrieve account to debit
		  $generaljournalaccounts2 = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$surchages->expenseid' and acctypeid='4'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		  
		  $generaljournalaccounts = new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$provid' and acctypeid='35'";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournalaccounts=$generaljournalaccounts->fetchObject;

				  //make credit entry
		  $generaljournal = new Generaljournals();
		  $ob->remarks=initialCap($surchages->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($surchages->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts2->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->class="B";
		  $ob->debit=0;
		  $ob->credit=$amount;
		  $generalJournal = $generaljournal->setObject($ob);
		  //$generaljournal->add($generaljournal);
		  
		  if(!empty($amount)){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal->transactionid");
		    
		    $it++;
		  }
			  //make credit entry
		  $generaljournal2 = new Generaljournals();
		  $ob->remarks=initialCap($surchages->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->memo=initialCap($surchages->name)." ".getMonth($obj->month)." ".$obj->year;
		  $ob->accountid=$generaljournalaccounts->id;
		  $ob->mode=$obj->paymentmodeid;
		  $ob->debit=$amount;
		  $ob->credit=0;
		  $ob->class="B";
		  $ob->did=$generaljournal->id;
		  $generalJournal2 = $generaljournal2->setObject($ob);
		  //$generaljournal2->add($generaljournal2);

		  if(!empty($amount)){
		    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'documentno'=>"$generaljournal->documentno", 'class'=>"B", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$obj->paidon",'transactionid'=>"$generaljournal2->transactionid");
			    
		    $it++;
		  }
	      }
	      
	    }
	  }
	  //print_r($shpgeneraljournals);
	  
	  
	  $currencys = new Currencyrates();
	  $fields="* ";
	  $join=" ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where currencyid='5' and fromcurrencydate<='$obj->paidon' and tocurrencydate>='$obj->paidon' ";
	  $currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $currencys = $currencys->fetchObject;
	  
	  $obj->currencyid=5;
	  $obj->exchangerate=$currencys->rate;
	  $obj->exchangerate2=$currencys->eurorate;
	  
	  $obj->transactdate=$obj->paidon;
	  
	  $gn = new Generaljournals();
	  $gn->add($obj, $shpgeneraljournals);
	}
	
	function validate($obj){
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
		else if(empty($obj->assignmentid)){
			$error="Assignment should be provided";
		}
		else if(empty($obj->paymentmodeid)){
			$error=" should be provided";
		}
		else if(empty($obj->month)){
			$error="Month should be provided";
		}
		else if(empty($obj->year)){
			$error="Year should be provided";
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
		if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}/*
		else if(empty($obj->paymentmodeid)){
			$error=" should be provided";
		}*/
		else if(empty($obj->month)){
			$error="Month should be provided";
		}
		else if(empty($obj->year)){
			$error="Year should be provided";
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
