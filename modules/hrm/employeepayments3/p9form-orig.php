<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
// require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/hrm/employeepayments/Employeepayments_class.php");
require_once("../../../modules/hrm/employeepaiddeductions/Employeepaiddeductions_class.php");
require_once("../../../modules/hrm/employeepaidallowances/Employeepaidallowances_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="P9form";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include"../../../head.php";

//Default shows
?>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"sScrollY": 500,
 		"iDisplayLength":1000,
 		"bJQueryUI": true,
 		"bSort":false,
//  		"sPaginationType": "full_numbers"
 	} );
 } );
 
 $().ready(function() {
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid").val(ui.item.id);
	}
  });

});

function Clickheretoprint(task)
{ 
	var msg;
	
	msg="Do you want to print Pay slips?";
	//var ans=confirm(msg);
	var ans = true;
	if(ans)
	{		
          poptastic("p9formprint.php?employeeid=<?php echo $obj->employeeid; ?>&year=<?php echo $obj->year; ?>",2000,1000);
	}
}
</script>
<body>
<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">		  
   
    
</div>
<form action="" method="post">
<div style="float:center;">
<hr>
<table align="center" id="tasktable">
<tr>
		<td align="right">Employee : </td>
			<td>
			<input type="text" size="32" name="employeename" id="employeename" value="<?php echo $obj->employeename; ?>"/>
			<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
		</td>
     <td><div align="right"></div>
        <strong>Year:</strong>
        <select name="year" class="input-small">
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
        </select>
      <input type="submit" name="action" id="action" class="btn btn-primary btn-sm" value="Load" />
      </td>
      <td><input type="button" name="action" <?php if(empty($obj->employeeid)){ echo "disabled"; } ?> value="Print Payslip" onclick="Clickheretoprint('print');"/></td>
  </tr>
  
</table>

</div>
<hr>
<div style="clear:both;"></div>
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
		$i=0;
		$A=$B=$C=$D=$E1=$E2=$E3=$F=$G=$H=$I=$J=$K=$L=0;		
		?>
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='1' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='1' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='1' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='1' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='1' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);
		$A+=$employeepayments->basic+$cashallowances->amount;
		$B+=$noncashallowances->amount;
		$C+=0;
		$D+=$employeepayments->basic+$cashallowances->amount+$noncashallowances->amount;
		$E1+=($employeepayments->basic+$employeepayments->allowances)*30/100;
		$E2+=$nssf->amount;
		$E3+=2000;
		$F+=0;
		$G+=$gvalue;
		$H+=$paye->amount;
		$I+=$paye->amount+1162;
		$J+=1162;
		$K+=0;
		$L+=$paye->amount;
		?>
		<tr>	
		        <td>1</td>
		 	<td>JANUARY</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>
			
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>			
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php  echo formatNumber(0); ?></td>
			
			<td><?php  echo formatNumber($gvalue); ?></td>
			<td><?php  echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php  echo formatNumber($paye->amount+1162); ?></td>
			<td><?php  echo formatNumber(1162); ?></td>
			<td><?php  echo formatNumber(0); ?></td>
			<td><?php  echo formatNumber($paye->amount); ?></td>
		</tr>
		
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='2' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='2' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='2' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='2' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='2' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);
		?>
		<tr>	
		        <td>2</td>
		 	<td>FEBRUARY</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>
			
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>			
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php echo formatNumber(0); ?></td>
			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='3' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='3' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='3' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='3' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='3' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);
		?>
		<tr>	
		        <td>3</td>
		 	<td>MARCH</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>
			
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>			
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php echo formatNumber(0); ?></td>
			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='4' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='4' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='4' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='4' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='4' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);		
		?>
		<tr>		
		        <td>4</td>
		 	<td>APRIL</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>
			
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php echo formatNumber(0); ?></td>
			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='5' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='5' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='5' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='5' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='5' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);
		?>
		<tr>	
		        <td>5</td>
		 	<td>MAY</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>
			
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>			
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php echo formatNumber(0); ?></td>
			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='6' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='6' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='6' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='6' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='6' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);
		?>
		<tr>		
		 	<td>6</td>
		 	<td>JUNE</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>
			
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>			
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php echo formatNumber(0); ?></td>
			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='7' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='7' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='7' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='7' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='7' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);
		?>
		<tr>		
		 	<td>7</td>
		 	<td>JULY</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>

			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php echo formatNumber(0); ?></td>
			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='8' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='8' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='8' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='8' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='8' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);
		?>
		<tr>	
		        <td>8</td>
		 	<td>AUGUST</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>
			
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>			
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php echo formatNumber(0); ?></td>
			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='9' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='9' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='9' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='9' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='9' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);
		?>
		<tr>	
		        <td>9</td>
		 	<td>SEPTEMBER</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>
			
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>			
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php echo formatNumber(0); ?></td>
			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='10' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='10' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='10' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='10' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='10' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);
		?>
		<tr>		
		 	<td>10</td>
		 	<td>OCTOBER</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>
			
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php echo formatNumber(0); ?></td>
			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='11' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='11' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='11' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='11' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='11' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);
		?>
		<tr>		
		 	<td>11</td>
		 	<td>NOVEMBER</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>
			
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>			
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php echo formatNumber(0); ?></td>
			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		<?php 
		$employeepayments=new Employeepayments();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='12' and year='$obj->year' ";
		$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employeepayments=$employeepayments->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='12' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='No') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$cashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaidallowances=new Employeepaidallowances();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='12' and year='$obj->year' and allowanceid in(select id from hrm_allowances where noncashbenefit='Yes') ";
		$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$noncashallowances=$employeepaidallowances->fetchObject;
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$fields=" sum(amount) amount ";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='12' and year='$obj->year' and deductionid  in(select id from hrm_deductions where taxable='No') ";
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$nssf=$employeepaiddeductions->fetchObject;
		
		$employeepaiddeduction=new Employeepaiddeductions();
		$fields="*";
		$join="  ";
		$having="";
		$groupby="";
		$orderby="";
		//checks if deduction is still active
		$where=" where employeeid='$obj->employeeid' and month='12' and year='$obj->year' and deductionid=1 ";
		$employeepaiddeduction->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$paye=$employeepaiddeduction->fetchObject;
		
		$gvalue=min((($employeepayments->basic+$employeepayments->allowances)*30/100),$nssf->amount,20000);
		?>
		<tr>		
		 	<td>12</td>
		 	<td>DECEMBER</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>
			
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>			
			<td><?php echo formatNumber(20000); ?></td>
			
			<td><?php echo formatNumber(0); ?></td>
			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		<tr>		
		 	<td>&nbsp;</td>
		 	<td>TOTALS</td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount); ?></td>
			<td><?php echo formatNumber($noncashallowances->amount); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($employeepayments->basic+$cashallowances->amount+$noncashallowances->amount); ?></td>		
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)*30/100); ?></td>
			<td><?php echo formatNumber($nssf->amount); ?></td>			
			<td><?php echo formatNumber(20000); ?></td>			
			<td><?php echo formatNumber(0); ?></td>			
			<td><?php echo formatNumber($gvalue); ?></td>
			<td><?php echo formatNumber(($employeepayments->basic+$employeepayments->allowances)-($gvalue)); ?></td>
			<td><?php echo formatNumber($paye->amount+1162); ?></td>
			<td><?php echo formatNumber(1162); ?></td>
			<td><?php echo formatNumber(0); ?></td>
			<td><?php echo formatNumber($paye->amount); ?></td>
		</tr>
		
	       <?php		
// 		}
		?>
	</tbody>
	</table>

</div>
</div>
</div>
</div>
