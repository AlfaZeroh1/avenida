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
      <td><input type="button" name="action" <?php if(empty($obj->employeeid)){ echo "disabled"; } ?> value="Print p9form" onclick="Clickheretoprint('print');"/></td>
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
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>KENYA REVENUE AUTHORITY INCOME TAX DEPARTMENT INCOME TAX DEDUCTION CARD YEAR <?php echo $obj->year; ?>
		 	</td>		 	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>		
	</thead>
	<tbody>
	<tr>		
		 	<td>Employer's Name: <?php echo $_SESSION['companyname'];?> </td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>		 	
			<td>Employer's PIN: <?php echo $_SESSION['companypin'];?> </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	<tr>		
		 	<td>Employee's Main Name: <?php echo $employees->lastname;?>  </td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>	
			<td>Employee's PIN: <?php echo $employees->pinno;?>  </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>		
		 	<td>Employee's Other Names: <?php echo $employees->firstname.' '.$employees->middlename;?></td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>		
		 	<td>#</td>
		 	<td>MONTH</td>
			<td>BASIC SALaRY </td>
			<td>BENEFITS NON-CASH</td>
			<td>VALUE OF QUARTERS</td>
			<td>TOTAL GROSS PAY</td>
			<td>DEFINED CONTRIBUTION RETIREMENT SCHEME</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>OWNER OCCUPIED INTEREST</td>	
			<td>RETIREMENT CONTRIBUTION AND OWNER-OCCUPATIONAL INTEREST</td>
			<td>CHARGEABLE PAY</td>
			<td>TAX CHARGED</td>
			<td>PERSONAL RELIEF</td>
			<td>INSURANCE RELIEF</td>
			<td>PAYE TAX(J-K)</td>
		</tr>
		<tr>		
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
			<td>A</td>
			<td>B</td>
			<td>C</td>
			<td>D</td>
			<td>E</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>F Amount Of interest</td>	
			<td>G lower of E added to F</td>
			<td>H</td>
			<td>J</td>
			<td>K</td>
			<td>-</td>
			<td>L</td>
		</tr>
		<tr>		
		 	<td>&nbsp;</td>
		 	<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>E 30% of A</td>
			<td>E</td>
			<td>E</td>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>K</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
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
</div>
</div>
</div>
