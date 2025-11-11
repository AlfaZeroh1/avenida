<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
// require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/hrm/employeepayments/Employeepayments_class.php");
require_once("../../../modules/hrm/employeepaiddeductions/Employeepaiddeductions_class.php");
require_once("../../../modules/hrm/employeepaidallowances/Employeepaidallowances_class.php");
require_once("../../../modules/hrm/employeereliefs/Employeereliefs_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="P9form";
//connect to db
$db=new DB();

$obj=(object)$_GET;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>P9 FORM</title>

<script type="text/javascript">
  function print_doc()
  {
		
  		var printers = jsPrintSetup.getPrintersList().split(',');
		// Suppress print dialog
		jsPrintSetup.setSilentPrint(false);/** Set silent printing */

		var i;
		for(i=0; i<printers.length;i++)
		{alert(i+": "+printers[i]);
			if(printers[i].indexOf('<?php echo SPRINTER; ?>')>-1)
			{	
				jsPrintSetup.setPrinter(printers[i]);
			}
			
		}
		//set number of copies to 2
		jsPrintSetup.setOption('numCopies','1');
		jsPrintSetup.setOption('headerStrCenter','');
		jsPrintSetup.setOption('headerStrRight','');
		jsPrintSetup.setOption('headerStrLeft','');
		jsPrintSetup.setOption('footerStrCenter','');
		jsPrintSetup.setOption('footerStrRight','');
		jsPrintSetup.setOption('footerStrLeft','');
		jsPrintSetup.setOption('marginLeft','1');
		jsPrintSetup.setOption('marginRight','1');
		jsPrintSetup.setOption('marginTop','1');
		
		// Do Print
		jsPrintSetup.printWindow(window);
		
		//window.close();
		//window.top.hidePopWin(true);
		// Restore print dialog
		//jsPrintSetup.setSilentPrint(false); /** Set silent printing back to false */
 
  }
 </script>
<style media="print" type="text/css">
.noprint{ display:none;}
body {font-family:'Tahoma';font-size:10px;}
</style>

</head>

<body onload="print_doc();">
<div align="left" id="print_content" style="width:98%; margin:0px auto;">

<table style="clear:both;"  class="table" id="tbl" width="100%" border="1" cellspacing="0" cellpadding="2" align="center" >
	<thead>
	       <?php
	        $employees=new Employees();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where id='$obj->employeeid' ";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employees=$employees->fetchObject;
	       ?>
	       <tr>		
		 	<th colspan="6">&nbsp;</th>
		 	<th colspan="4"><center>KENYA REVENUE AUTHORITY
		 	INCOME TAX DEPARTMENT
		 	INCOME TAX DEDUCTION CARD YEAR <?php echo $obj->year; ?></center></th>
			<th colspan="6"></th>
	       </tr>
	       <tr>		
		 	<th colspan="9">Employer's Name: <?php echo $_SESSION['companyname'];?> </th>
			<th colspan="7">Employer's PIN: <?php echo $_SESSION['companypin'];?> </th>
		</tr>
		<tr>		
		 	<th colspan="9">Employee's Main Name: <?php echo $employees->lastname;?>  </th>
			<th colspan="7">Employee's PIN: <?php echo $employees->pinno;?>  </th>
		</tr>
		<tr>		
		 	<th colspan="9">Employee's Other Names: <?php echo $employees->firstname.' '.$employees->middlename;?></th>
			<th colspan="7">&nbsp;</th>
		</tr>
		<tr>		
		 	<th>#</th>
		 	<th>MONTH</th>
			<th>BASIC SALaRY </th>
			<th>BENEFITS NON-CASH</th>
			<th>VALUE OF QUARTERS</th>
			<th>TOTAL GROSS PAY</th>
			<th colspan="3">DEFINED CONTRIBUTION RETIREMENT SCHEME</th>
			<th>OWNER OCCUPIED INTEREST</th>	
			<th>RETIREMENT CONTRIBUTION AND OWNER-OCCUPATIONAL INTEREST</th>
			<th>CHARGEABLE PAY</th>
			<th>TAX CHARGED</th>
			<th>PERSONAL RELIEF</th>
			<th>INSURANCE RELIEF</th>
			<th>PAYE TAX(J-K)</th>
		</tr>
		<tr>		
		 	<th>&nbsp;</th>
		 	<th>&nbsp;</th>
			<th>A</th>
			<th>B</th>
			<th>C</th>
			<th>D</th>
			<th colspan="3" align="center">E</th>
			<th>F Amount Of interest</th>	
			<th>G lower of E added to F</th>
			<th>H</th>
			<th>J</th>
			<th>K</th>
			<th>-</th>
			<th>L</th>
		</tr>
		<tr>		
		 	<th>&nbsp;</th>
		 	<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>E 30% of A</th>
			<th>E</th>
			<th>E</th>
			<th>&nbsp;</th>	
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th colspan="2">K</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
// 	if($obj->action=="Filter"){
		$i=1;
		$A=$B=$C=$D=$E1=$E2=$E3=$F=$G=$H=$I=$J=$K=$L=0;		
		?>
		<?php 
		while($i<=12){
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='$i' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" case when sum(amount) is null then 0 else sum(amount) end amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='$i' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" case when sum(amount) is null then 0 else sum(amount) end amount  ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='$i' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" case when sum(amount) is null then 0 else sum(amount) end amount  ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='$i' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields=" case when amount is null then 0 else amount end amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='$i' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$employeereliefs=new Employeereliefs();
		$fields=" case when sum(amount) is null then 0 else sum(amount) end amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='$i' and year='$obj->year'";
		$employeereliefs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$insurancereliefs=$employeereliefs->fetchObject;
		
		
		$tt=0;
		$tt=$employeepayments->basic+$cashallowances->amount+$noncashallowances->amount;
		
		if($tt>0){
		    $relief=1162;
		    $fixed=20000;
		}else{
		    $relief=0;
		    $fixed=0;
		}
		   
		
		$gvalue=min((($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount)*30/100),$nssf->amount,$fixed);
		$A+=$employeepayments->basic+$cashallowances->amount;
		$B+=$noncashallowances->amount;
		$C+=0;
		$D+=$employeepayments->basic+$cashallowances->amount+$noncashallowances->amount;
		$E1+=($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount)*30/100;
		$E2+=$nssf->amount;
		$E3+=$fixed;
		$F+=0;
		$G+=$gvalue;
		$H+=$employeepayments->basic+$cashallowances->amount+$noncashallowances->amount-$gvalue;
		$I+=$paye->amount+$relief;
		$J+=$relief;
		$K+=$insurancereliefs->amount;
		$L+=$paye->amount;
		
		$month=date("F",mktime(0,0,0,$i,15,$obj->year));
		?>
		<tr>	
		        <td><?php echo $i; ?></td>
		 	<td><?php echo $month; ?></td>
			<td><?php echo $employeepayments->basic+$cashallowances->amount; ?></td>
			<td><?php echo $noncashallowances->amount; ?></td>
			<td><?php echo 0; ?></td>
			<td><?php echo $employeepayments->basic+$cashallowances->amount+$noncashallowances->amount; ?></td>		
			<td><?php echo ($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount)*30/100; ?></td>
			<td><?php echo $nssf->amount; ?></td>			
			<td><?php echo $fixed; ?></td>			
			<td><?php echo 0; ?></td>			
			<td><?php echo $gvalue; ?></td>
			<td><?php echo ($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount)-($gvalue); ?></td>
			<td><?php echo $paye->amount+$relief; ?></td>
			<td><?php echo $relief; ?></td>
			<td><?php echo $insurancereliefs->amount; ?></td>
			<td><?php echo $paye->amount; ?></td>
		</tr>
		<?php 
		$i++;
		}	
		?>		
	       <?php		
// 		}
		?>
	</tbody>
	<tfoot>
	<tr>		
		 	<th>&nbsp;</th>
		 	<th>TOTALS</th>
			<th><?php echo $A; ?></th>
			<th><?php echo $B; ?></th>
			<th><?php echo $C; ?></th>
			<th><?php echo $D; ?></th>		
			<th><?php echo $E1; ?></th>
			<th><?php echo $E2; ?></th>			
			<th><?php echo $E3; ?></th>			
			<th><?php echo $F; ?></th>			
			<th><?php echo $G; ?></th>
			<th><?php echo $H; ?></th>
			<th><?php echo $I; ?></th>
			<th><?php echo $J; ?></th>
			<th><?php echo $K; ?></th>
			<th><?php echo $L; ?></th>
		</tr>
	</tfoot>
	</table>
</div>
</body>
</html>