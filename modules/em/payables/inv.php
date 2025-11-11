<?php
session_start();

require_once("../../../DB.php");
//require_once("../../../lib.php");
require_once("Payables_class.php");
require_once("../../em/housetenants/Housetenants_class.php");
require_once("../../em/rentaltypes/Rentaltypes_class.php");
require_once("../../em/plotutilitys/Plotutilitys_class.php");
require_once '../../fn/generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../../fn/generaljournals/Generaljournals_class.php';
require_once '../../sys/transactions/Transactions_class.php';
require_once '../../em/houseutilitys/Houseutilitys_class.php';
require_once '../../em/houses/Houses_class.php';
require_once '../../sys/config/Config_class.php';
require_once ("../../em/paymentterms/Paymentterms_class.php");
require_once("../../fn/loans/Loans_class.php");
require_once("../../fn/payments/Payments_class.php");
require_once("../../fn/loanpayments/Loanpayments_class.php");
require_once("../../fn/expenses/Expenses_class.php");
require_once("../../fn/incomes/Incomes_class.php");
require_once("../../em/plots/Plots_class.php");
require_once("../../fn/exptransactions/Exptransactions_class.php");
require_once("../../fn/inctransactions/Inctransactions_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../crm/customers/Customers_class.php");

function logg($str){
	$fd=fopen("statuss.txt","w");
	fwrite($fd,$str."\n");
	fclose($fd);
}

function initialCap($val)
{
	$str = explode(" ",$val);
	$len = count($str);
	$i=$len;
	$strn="";
	$j=0;
	while($i>0)
	{
		$strn.=strtoupper(substr($str[$j],0,1))."".strtolower(substr($str[$j],1))." ";
		$j++;
		$i--;
	}
	return $strn;
}

function getMonth($month){
	if(!empty($month))
		return date('F', mktime(0, 0, 0, $month, 1, 2000));
}

//connect to db
$db=new DB();
$obj=(object)$_POST;

if(empty($obj->action)){
	$obj->action="Batch Invoice";
	$obj->invoicedon=@date("Y-m-d");
	$obj->year=@date("Y");
	$obj->month=@date("m");
	//$obj->month=12;
}

if($obj->action=="Batch Invoice"){
	if(empty($obj->month)){
		$error="Must select Month";
	}
	elseif(empty($obj->year)){
		$error="Must select Year";
	}
	else{
		//retrieve all housetenants
		$housetenants=new Housetenants();
		$fields="em_housetenants.id,em_housetenants.tenantid, em_plots.landlordid,concat(concat(em_landlords.firstname,' ',em_landlords.middlename),' ',em_landlords.lastname) landlordname,concat(concat(em_tenants.firstname,' ', em_tenants.middlename),em_tenants.lastname) tenantname,em_houses.amount,em_houses.hseno, em_rentaltypes.name rentaltypeid, em_rentaltypes.months, em_housetenants.houseid, em_housetenants.rentaltypeid, em_housetenants.occupiedon, em_housetenants.leasestarts, em_housetenants.renewevery, em_housetenants.leaseends, em_housetenants.increasetype, em_housetenants.increaseby, em_housetenants.increaseevery, em_housetenants.rentduedate, em_housetenants.lastmonthinvoiced, em_housetenants.lastyearinvoiced";
		$join=" left join em_houses on em_housetenants.houseid=em_houses.id left join em_plots on em_plots.id=em_houses.plotid left join em_landlords on em_plots.landlordid=em_landlords.id left join em_tenants on em_housetenants.tenantid=em_tenants.id left join em_rentaltypes on em_housetenants.rentaltypeid=em_rentaltypes.id";
		$having="";
		$groupby="";
		$orderby="";
		//to ensure that not already done invoices are repeated
		$where=" where em_housetenants.houseid not in(select houseid from em_payables where paymenttermid=1 and month='$obj->month' and year='$obj->year') and em_housetenants.payable='Yes'";
		$housetenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$housetenants->result;
		$num = $housetenants->affectedRows;
		$total=0;
		$is=0;
		$perc=0;
		
		
		while($row=mysql_fetch_object($res)){$is++;
		
			$config = new Config();
			$fields=" * ";
			$join="  ";
			$where=" where name='rentduedate' ";
			$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$config=$config->fetchObject;
			$config->rentduedate=$config->value;
			
			if(empty($row->lastmonthinvoiced))
				$row->lastmonthinvoiced=date("m",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
			
			if(empty($row->lastyearinvoiced))
				$row->lastyearinvoiced=date("Y",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
			
			//date of last payment
			@$lastpayment=date("Y-m-d",mktime(0,0,0,$row->lastmonthinvoiced,$config->rentduedate,$row->lastyearinvoiced));
		
			//expected next payment
			@$nextpayment=date("Y-m-d",mktime(0,0,0,$row->lastmonthinvoiced + $row->months,$config->rentduedate,$row->lastyearinvoiced));
			@$month=date("m",mktime(0,0,0,$row->lastmonthinvoiced + $row->months,$config->rentduedate,$row->lastyearinvoiced));
			@$year=date("Y",mktime(0,0,0,$row->lastmonthinvoiced + $row->months,$config->rentduedate,$row->lastyearinvoiced));
		
			//if todays date >=expected next payment, do an invoice
			if($nextpayment<=date("Y-m-d")){
				// record rent payable
				$payables = new Payables();
				
				$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from em_payables"));
				if($defs->documentno == null){
					$defs->documentno=1;
				}
				$payables->documentno=$defs->documentno;
				$obj->documentno=$defs->documentno;
				
				$payables->setHouseid($row->houseid);
				$payables->setTenantid($row->tenantid);
				$payables->setPaymenttermid(1);
				$payables->setMonth($obj->month);
				$payables->setQuantity(1);
				$payables->setTotal($row->amount);
				$payables->setYear($obj->year);
				$payables->setInvoicedon($obj->invoicedon);
				$payables->setAmount($row->amount);
				$payables->setRemarks("Rent for $obj->month $obj->year");
				
				$total+=$payables->total;
				
				$shppayables=array();
				
				$it=0;
				
				if($payables->amount>0){
					@$shppayables[$it]=array('vatclasseid'=>"$payables->vatclasseid", 'mgtfee'=>"$payables->mgtfee", 'mgtfeevatclasseid'=>"$payables->mgtfeevatclasseid", 'houseid'=>"$payables->houseid", 'housename'=>"$houses->hseno", 'mgtfeeamount'=>"$payables->mgtfeeamount", 'vatamount'=>"$payables->vatamount", 'mgtfeevatamount'=>"$payables->mgtfeevatamount", 'paymenttermid'=>"$payables->paymenttermid", 'paymenttermname'=>"$paymentterms->name", 'quantity'=>"$payables->quantity", 'amount'=>"$payables->amount", 'remarks'=>"$payables->remarks", 'total'=>"$payables->total",'documentno'=>"$payable->documentno",'transctdate'=>"$obj->invoicedon");
					
					$it++;
				}
				
				//record utilities payable
				//plot utilitys
				$plotutilitys=new Plotutilitys();
				$fields="em_plotutilitys.id, em_plots.name as plotid, em_utilitys.name utilityname, em_utilitys.id as utilityid, em_plotutilitys.amount, em_plotutilitys.showinst";
				$join=" left join em_plots on em_plotutilitys.plotid=em_plots.id  left join em_utilitys on em_plotutilitys.paymenttermid=em_utilitys.id ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where em_utilitys.id not in (select utilityid from em_houseutilityexemptions, em_houses where em_houseutilityexemptions.houseid=em_houses.id and em_houses.plotid=em_plots.id) ";
				$plotutilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				$rs=$plotutilitys->result;
				while($rw=mysql_fetch_object($rs)){
					//check if the utility is attached to the house
					$houseutilitys=new Houseutilitys();
					$fields="em_houseutilitys.id, em_houseutilitys.paymenttermid, em_utilitys.name utilityname, concat(em_houses.hseno,' - ',em_houses.hsecode) as housename, em_houseutilitys.houseid, em_utilitys.name as utilityid, em_houseutilitys.amount, em_houseutilitys.showinst, em_houseutilitys.remarks";
					$join=" left join em_houses on em_houseutilitys.houseid=em_houses.id  left join em_utilitys on em_houseutilitys.paymenttermid=em_utilitys.id ";
					$having="";
					$groupby="";
					$orderby="";
					$where =" where em_houseutilitys.paymenttermid='$rw->utilityid'";
					$houseutilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
					$rw=$houseutilitys->fetchObject;
						
					$payables = new Payables();
					$payables->setHouseid($rw->houseid);
					$payables->setTenantid($housetenants->tenantid);
					$payables->setDocumentno($obj->documentno);
					$payables->setPaymenttermid($rw->paymenttermid);
					$payables->setQuantity(1);
					$payables->setMonth($obj->month);
					$payables->setYear($obj->year);
					$payables->setInvoicedon($obj->invoicedon);
					$payables->setAmount($rw->amount);
					$payables->setTotal($rw->amount);
					$payables->setRemarks(initialCap($rw->utilityname)." for $obj->month $obj->year");
					
					$total+=$payables->total;
					
					@$shppayables[$it]=array('vatclasseid'=>"$payables->vatclasseid", 'mgtfee'=>"$payables->mgtfee", 'mgtfeevatclasseid'=>"$payables->mgtfeevatclasseid", 'houseid'=>"$payables->houseid", 'housename'=>"$houses->hseno", 'mgtfeeamount'=>"$payables->mgtfeeamount", 'vatamount'=>"$payables->vatamount", 'mgtfeevatamount'=>"$payables->mgtfeevatamount", 'paymenttermid'=>"$payables->paymenttermid", 'paymenttermname'=>"$paymentterms->name", 'quantity'=>"$payables->quantity", 'amount'=>"$payables->amount", 'remarks'=>"$payables->remarks", 'total'=>"$payables->total");
					$it++;			
					
				}
				
				$payables->tenantid=$row->tenantid;
				$sql="update em_housetenants set lastmonthinvoiced='$month' , lastyearinvoiced='$year' where id='$row->id'";
				mysql_query($sql);
				
				if($payables->add($payables, $shppayables)){
				  $perc = $is/$num*100;
				  if(!empty($perc))
				    logg($perc);
				}
				
							
			}	
			
			echo "Invoiced: ".$row->tenantname."\n";
		}		
	}
	
	//plot expenses of landlord loans
	$loans = new Loans();
	$fields="*";
	$join=" ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where plotid>0 and id not in(select loanid from fn_loanpayments where month='$obj->month' and year='$obj->year') and principal>0 ";
	$loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res=$loans->result;
	$it=0;
	
	$shpexptransactions=array();
	$shpinctransactions=array();
	
	
	while($obj=mysql_fetch_object($res)){	$it=0;
	
	  if($obj->interesttype=="%"){
	    if($obj->type=="straight line")
		  $obj->interest=($obj->rate)/100*$obj->initialvalue*$obj->duration/12;
	    elseif(trim($obj->type)=="reducing balance")
		  $obj->interest=($obj->rate)/100*$obj->principal*$obj->duration/12;
	 }
	 else{
	    $obj->interest=$obj->rate;
	 }
	  if($obj->principal<$obj->payable)
	    $obj->payable=$obj->principal;
	  
	  $obj->paymenttermid=1;
	  $obj->expenseid=1;
	  $obj->incomeid=9;
	  $obj->month=date("m");
	  $obj->year=date("Y");
	
	  $paymentterms = new Paymentterms();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where=" where id='$obj->paymenttermid'";
	  $paymentterms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $paymentterms=$paymentterms->fetchObject;
	  
	  $expenses = new Expenses();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where=" where id='$obj->expenseid'";
	  $expenses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $expenses=$expenses->fetchObject;
	  
	  $incomes = new Incomes();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where=" where id='$obj->incomeid'";
	  $incomes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $incomes=$incomes->fetchObject;
	  
	  $plots = new Plots();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where=" where id='$obj->plotid'";
	  $plots->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $plots=$plots->fetchObject;
	  
	  $customers = new Customers();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where=" where refid='$plots->id' and acctypeid=33";
	  $customers->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $customers=$customers->fetchObject;
	
	  $shpexptransactions[$it]=array('expenseid'=>"$obj->expenseid", 'expensename'=>"$expenses->name",'plotid'=>"$obj->plotid",'plotname'=>"$plots->name",'paymenttermid'=>"$obj->paymenttermid" ,'paymenttermname'=>"$paymentterms->name", 'quantity'=>"1", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'amount'=>"$obj->payable", 'memo'=>"Landlord Loan", 'total'=>"$obj->payable",'month'=>"$obj->month",'year'=>"$obj->year");
	  $shpinctransactions[$it]=array('incomeid'=>"$obj->incomeid", 'incomename'=>"$incomes->name",'plotid'=>"$obj->plotid",'plotname'=>"$plots->name",'paymenttermid'=>"$obj->paymenttermid" ,'paymenttermname'=>"$paymentterms->name", 'quantity'=>"1", 'tax'=>"$obj->tax", 'discount'=>"$obj->discount", 'amount'=>"$obj->interest", 'memo'=>"Landlord Loan Interest", 'total'=>"$obj->interest",'month'=>"$obj->month",'year'=>"$obj->year");
	 
	  
	  $pay = new Loanpayments();
	  $pay->plotid=$obj->plotid;
	  $pay->loanid=$obj->id;
	  $pay->amount=$obj->payable;
	  $obj->interest=$obj->interest;
	  $pay->paidon=date("Y-m-d");
	  $pay->paidby="Landlord";
	  $pay->paymentmodeid=8;
	  $pay->bankid=$customers->id;
	  $pay->month=date("m");
	  $pay->year=date("Y");
	  $pay->createdby=$_SESSION['userid'];
	  $pay->createdon=date("Y-m-d H:i:s");
	  $pay->lasteditedby=$_SESSION['userid'];
	  $pay->lasteditedon=date("Y-m-d H:i:s");
	  $pay->ipaddress=$_SERVER['REMOTE_ADDR'];
	  
	  if($pay->amount>0){
	    $loanpayments = new Loanpayments();
	    $loanpayments = $loanpayments->setObject($pay);
	    $loanpayments->add($pay);
	    
	    echo "Landlord Loans: ".$plots->name."\n";
	    
	    $obj->lastpaymentmonth=date("m");
	    $obj->lastpaymentyear=date("Y");
	    
	    $loans = new Loans();
	    $obj->principal-=$obj->payable;
	    $loans = $loans->setObject($obj);
	    $loans->edit($loans);
	    
	    $exptransactions=new Exptransactions();
	    $inctransactions=new Inctransactions();
	    $obj->createdby=$_SESSION['userid'];
	    $obj->createdon=date("Y-m-d H:i:s");
	    $obj->lasteditedby=$_SESSION['userid'];
	    $obj->lasteditedon=date("Y-m-d H:i:s");
	    $obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	    $obj->expensedate=date("Y-m-d");
	    $obj->incomedate=date("Y-m-d");
	    $obj->month=$month;
	    $obj->year=$year;
	    $obj->paymentmodeid=5;
	    $obj->purchasemodeid=1;
	    
	    $error=$exptransactions->validates($obj);
	    $error = $inctransactions->validates($obj);
	    if(!empty($error)){
		    $error=$error;
	    }
	    elseif(empty($shpexptransactions)){
		    $error="No items in the expenses list!";
	    }	
	    elseif(empty($shpinctransactions)){
		    $error="No items in the incomes list!";
	    }
	    else{$obj->id="";
		    $exptransactions=$exptransactions->setObject($obj);
		    $inctransactions=$inctransactions->setObject($obj);
		    if($exptransactions->add($exptransactions,$shpexptransactions)){
		      if($inctransactions->add($inctransactions,$shpinctransactions)){
			    $error=SUCCESS;
			    $saved="Yes";
			    $_SESSION['shpexptransactions']="";
			    $_SESSION['shpinctransactions']="";
			    //redirect("addexptransactions_proc.php?id=".$exptransactions->id."&error=".$error);
		      }
		    }
		    else{
			    $error=FAILURE;
		    }
	    }
	   }
	  //$it++;
	}
}
?>
