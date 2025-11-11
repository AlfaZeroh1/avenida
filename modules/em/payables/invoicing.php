<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payables_class.php");
require_once("../../em/housetenants/Housetenants_class.php");
require_once("../../em/rentaltypes/Rentaltypes_class.php");
require_once("../../em/plotutilitys/Plotutilitys_class.php");
require_once '../../fn/generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../../fn/generaljournals/Generaljournals_class.php';
require_once '../../sys/transactions/Transactions_class.php';
require_once '../../em/houseutilitys/Houseutilitys_class.php';
require_once '../../em/houses/Houses_class.php';

$page_title="Batch Invoicing";

if(empty($_SESSION['userid'])){;
redirect("../../auth/users/login.php");
}

include "../../../head.php";

//connect to db
$db=new DB();
$obj=(object)$_POST;

if(empty($obj->action)){
	$obj->invoicedon=date("Y-m-d");
	$obj->year=date("Y");
	$obj->month=date("m");
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
		$where=" ";
		$housetenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$housetenants->result;
		
		$total=0;
		
		while($row=mysql_fetch_object($res)){
			
			if(empty($row->lastmonthinvoiced))
				$row->lastmonthinvoiced=date("m");
			
			if(empty($row->lastyearinvoiced))
				$row->lastyearinvoiced=date("Y");
			
			//date of last payment
			$lastpayment=date("Y-m-d",mktime(0,0,0,$row->lastmonthinvoiced,$row->rentduedate,$row->lastyearinvoiced));
		
			//expected next payment
			$nextpayment=date("Y-m-d",mktime(0,0,0,$row->lastmonthinvoiced + $row->months,$row->rentduedate,$row->lastyearinvoiced));echo $nextpayment."\n";
			$month=date("m",mktime(0,0,0,$row->lastmonthinvoiced + $row->months,$row->rentduedate,$row->lastyearinvoiced));
			$year=date("Y",mktime(0,0,0,$row->lastmonthinvoiced + $row->months,$row->rentduedate,$row->lastyearinvoiced));
		
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
				$shppayables[$it]=array('vatclasseid'=>"$payables->vatclasseid", 'mgtfee'=>"$payables->mgtfee", 'mgtfeevatclasseid'=>"$payables->mgtfeevatclasseid", 'houseid'=>"$payables->houseid", 'housename'=>"$houses->hseno", 'mgtfeeamount'=>"$payables->mgtfeeamount", 'vatamount'=>"$payables->vatamount", 'mgtfeevatamount'=>"$payables->mgtfeevatamount", 'paymenttermid'=>"$payables->paymenttermid", 'paymenttermname'=>"$paymentterms->name", 'quantity'=>"$payables->quantity", 'amount'=>"$payables->amount", 'remarks'=>"$payables->remarks", 'total'=>"$payables->total");
				
				$it++;
		
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
					
					$shppayables[$it]=array('vatclasseid'=>"$payables->vatclasseid", 'mgtfee'=>"$payables->mgtfee", 'mgtfeevatclasseid'=>"$payables->mgtfeevatclasseid", 'houseid'=>"$payables->houseid", 'housename'=>"$houses->hseno", 'mgtfeeamount'=>"$payables->mgtfeeamount", 'vatamount'=>"$payables->vatamount", 'mgtfeevatamount'=>"$payables->mgtfeevatamount", 'paymenttermid'=>"$payables->paymenttermid", 'paymenttermname'=>"$paymentterms->name", 'quantity'=>"$payables->quantity", 'amount'=>"$payables->amount", 'remarks'=>"$payables->remarks", 'total'=>"$payables->total");
					$it++;			
					
				}
				
				$payables->tenantid=$row->tenantid;
				$sql="update em_housetenants set lastmonthinvoiced='$month' , lastyearinvoiced='$year' where id='$row->id'";
				mysql_query($sql);
				
				$payables->add($payables, $shppayables);
							
			}		
			
		}		
	}
}
?>
<table>
	<tr>
		<th colspan="2">Invoices Due Dates</th>
	</tr>
	<?php 
	$housetenants = new Housetenants();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where="";
	$housetenants->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	?>
</table>
<form class="forms" action="invoicing.php" method="post">
	<table align='center'>
		<tr>
			<td colspan="3"><font color="red"><?php echo $error; ?></font></td>
		</tr>
		<tr>
			<td><strong>Month</strong>:<select class="selectbox" name="month">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->month==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->month==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->month==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->month==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->month==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->month==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->month==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->month==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->month==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->month==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->month==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->month==12){echo"selected";}?>>December</option>
      </select></td>
			<td><strong>Year</strong>:<select class="selectbox" name="year">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select></td>
        	<td><strong>Invoice Date</strong>: <input type="text" size="12" name="invoicedon" readonly="readonly" class="date_input" value="<?php echo $obj->invoicedon; ?>"></td>
			<td><input type="submit" class="btn" name="action" value="Batch Invoice"/></td>
		</tr>
	</table>
</form>