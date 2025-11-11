<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/payes/Payes_class.php");
require_once("../../hrm/reliefs/Reliefs_class.php");
require_once("../../hrm/employeereliefs/Employeereliefs_class.php");
require_once("../../hrm/allowances/Allowances_class.php");
require_once("../../hrm/employeeallowances/Employeeallowances_class.php");
require_once("../../hrm/employeedeductions/Employeedeductions_class.php");
require_once("../../hrm/employeesurchages/Employeesurchages_class.php");
require_once("../../hrm/employeeloans/Employeeloans_class.php");
require_once("../../hrm/employeepaidallowances/Employeepaidallowances_class.php");
require_once("../../hrm/employeepaiddeductions/Employeepaiddeductions_class.php");
require_once("../../hrm/deductions/Deductions_class.php");

include "../../../head.php";

$obj = (object)$_POST;
$error=$_GET['error'];

$db = new DB();
?>
<?php
if($obj->action=="Save"){

$employeepayments = new Employeepayments();
				
$ob=$obj;
$ob->employeeid=$row->id;
$ob->assignmentid=$row->assignmentid;
$ob->employeebankid=$row->employeebankid;
$ob->bankbrancheid=$row->bankbrancheid;
$ob->bankacc=$row->bankacc;
$ob->clearingcode=$row->clearingcode;
$ob->ref=$row->ref;
$ob->basic=$row->basic;
$ob->allowances=$totalallowances;
$ob->deductions=$totaldeductions;
$ob->netpay=$netpay;
$ob->createdby=$_SESSION['userid'];
$ob->createdon=date("Y-m-d H:i:s");
$ob->lasteditedby=$_SESSION['userid'];
$ob->lasteditedon=date("Y-m-d H:i:s");
$ob->ipaddress=$_SERVER['REMOTE_ADDR'];

$employeepayments->setObject($ob);
$employeepayments->add($employeepayments);
}
?>



<script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
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
 </script>
 
 <script type="text/javascript" language="javascript">
 
$(document).ready(function() {
   	$('.check_row input:checkbox').click(function(){
		var curTrId = $(this).closest('tr').attr('id');
		var amtval = $('#' +curTrId+ '.check_row').find('td.amntt').html();
		amtval = Number(amtval.replace(/[^0-9\.-]+/g,""));//alert(amtval);
		
		var amVal = parseFloat(amtval);
		var viewtot = parseFloat($('input#totalamount').val());
		var viewded = parseFloat($('input#ded').val());
		var viewpay = parseFloat($('input#payable').val());
		if(isNaN(viewpay))
			viewpay=0;
			
		var deductions;
		var balance;
		if($(this).attr('checked') == 'checked'){	
			deductions = viewded+amVal;
			balance=viewtot-deductions;
			
			balance = Math.round(balance*Math.pow(10,2))/Math.pow(10,2);
			viewded = Math.round(deductions*Math.pow(10,2))/Math.pow(10,2);
			$('input#payable').val(balance);
			$('input#ded').val(deductions);
			$('#' +curTrId+ '.check_row').css('background-color','#f0f000');
			//alert('is checked ' + viewtot);
		}	
		else{
		 	//var viewtot = parseFloat($('input#balCheck').val());
			deductions = viewded-amVal;
			balance=viewtot-deductions;
			
			balance = Math.round(balance*Math.pow(10,2))/Math.pow(10,2);
			viewded = Math.round(deductions*Math.pow(10,2))/Math.pow(10,2);
			$('input#payable').val(balance);
			$('input#ded').val(viewded);
			$('#' +curTrId+ '.check_row').css('background-color','#fff');
			//alert('is not checked ' + viewtot);
	  }
	});
	
});
 </script>
 <script language="javascript" type="text/javascript">
function setStatus(str)
{//alert(str.value);
if(str.checked)
{
	var status="checked";
}
else
{
	var status="unchecked";
}
}
</script>
 <div class="content">
 <form action="" method="post">
<table border="0" width="40%">
  <tr>
    <td>Month</td>
    <td><select name="month" class="selectbox">
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
      </select>&nbsp;<select name="year" class="selectbox">
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
  </tr>
 <tr>
		<td align="right">Employee : </td>
			<td>
			<input type="text" size="32" name="employeename" id="employeename" value="<?php echo $obj->employeename; ?>"/>
			<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
		</td>
	</tr>
	<tr>
		<td align="right">Lump Sum Amount : </td>
			<td>
			<input type="text" size="10" name="amount" id="amount" value="<?php echo $obj->amount; ?>"/>
		</td>
	</tr>
	<tr>
	  <td colspan="2"><input type="submit" name="action" value="Process"/></td>
	</tr>
	<?php 
	if($obj->action=="Process"){
	  if(empty($obj->employeeid)){
	    $error="Must give Employee!";
	  }elseif(empty($obj->month) or empty($obj->year)){
	    $error="Must give Month/Year!";
	  }elseif(empty($obj->amount)){
	    $error="Must give Lump Sum amount!";
	  }else{
	  
	  $j=0;
	  $totalded=0;
	  $gndeductions=array();
	  $gnincomes=array();
	  $gnsalaries=array();
	  $employees = new Employees();
	  $fields="*, concat(hrm_employees.pfnum,' ',concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname)) names";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where hrm_employees.id='$obj->employeeid'";
	  $employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $employees = $employees->fetchObject;
	?>
	<tr>
	  <td colspan="2" align="center">
	  <?php echo $employees->names;  ?>
	  </td>
	</tr>
	<tr>
	  <td colspan="2">
	  <table border="1" width="100%">
	  <tr>
	    <th>#</th>
	    <th>Year</th>
	    <th>Amount</th>
	    <th>PAYE</th>
	  </tr>
	  <?php
	  $i=0;
	  $amnt=0;
	  $tpaye=0;
	  while($i<5){
	  if($i==4)
	    $amount=$obj->amount-$amnt;
	  else
	    $amount=$employees->basic;
	    
	  $payes = new Payes();
	  $ob->year=$obj->year-$i;
	  $ob->month=$obj->month;
	  $paye=$payes->getPAYE($amount,$employees->id, $ob);
	  $amnt+=$amount;
	  $tpaye+=$paye;
	  $totalded+=$paye;
	  $gndeductions['1']+=$paye;
	  ?>
	    <tr>
	      <td><?php echo ($i+1); ?></td>
	      <td><?php echo ($obj->year-$i); ?></td>
	      <td align="right"><?php echo formatNumber($amount); ?></td>
	      <td align="right"><?php echo formatNumber($paye); ?></td>
	    </tr>
	  <?
	  $i++;
	  }
	  
	  $employeepaiddeductions = new Employeepaiddeductions();
	  $fields="sum(amount) amount";
	  $where=" where employeeid='$obj->employeeid' and deductionid=1 ";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $employeepaiddeductions = $employeepaiddeductions->fetchObject;
	  ?>
	  <tr>
	      <td>&nbsp;</td>
	      <td>Total</td>
	      <td align="right"><?php echo formatNumber($amnt); ?></td>
	      <td align="right"><?php echo formatNumber($tpaye); ?></td>
	    </tr>
	  <tr>
	      <td>&nbsp;</td>
	      <td>Total Paid Tax</td>
	      <td align="right">&nbsp;</td>
	      <td align="right"><?php  echo formatNumber($employeepaiddeductions->amount); ?></td>
	    </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>PAYE Payable</td>
	      <td align="right">&nbsp;</td>
	      <td align="right"><?php $totalded=$totalded-$employeepaiddeductions->amount; echo formatNumber($tpaye-$employeepaiddeductions->amount); ?></td>
	    </tr>
	  </table>
	  </td>
	</tr>
	
	<tr>
	  <td colspan="2" align="center">
	  DEDUCTIONS
	  </td>
	</tr>
	<tr>
	  <td colspan="2">
	  <table border="1" width="100%">
	  <tr>
	    <th>#</th>
	    <th></th>
	    <th>Name</th>
	    <th>Amount</th>
	  </tr>
	  <?php
	  $i=0;
	  $amnt=0;
	  $tpaye=0;
	  
	  $employeedeductions=new Employeedeductions();
	  $fields="hrm_employeedeductions.id, hrm_deductions.deductiontype, hrm_deductions.name as deductionid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_deductiontypes.name as deductiontypeid, hrm_employeedeductions.amount, hrm_employeedeductions.frommonth, hrm_employeedeductions.fromyear, hrm_employeedeductions.tomonth, hrm_employeedeductions.toyear, hrm_employeedeductions.remarks, hrm_employeedeductions.createdby, hrm_employeedeductions.createdon, hrm_employeedeductions.lasteditedby, hrm_employeedeductions.lasteditedon";
	  $join=" left join hrm_deductions on hrm_employeedeductions.deductionid=hrm_deductions.id  left join hrm_employees on hrm_employeedeductions.employeeid=hrm_employees.id  left join hrm_deductiontypes on hrm_employeedeductions.deductiontypeid=hrm_deductiontypes.id ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  //checks if deduction is still active
	  $where=" where hrm_employeedeductions.employeeid=$employees->id and hrm_deductions.id>3 ";
// 	    if($rw->deductiontypeid==1){
	      $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
	      
	      $where.=" and case when hrm_deductions.deductiontypeid=1 then  str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.frommonth)),concat('-',hrm_employeedeductions.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeedeductions.tomonth)),concat('-',hrm_employeedeductions.toyear)),'%d-%m-%Y') else '' end ";
// 	    }
	  $employeedeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeedeductions->sql;
	  
	  while($row=mysql_fetch_object($employeedeductions->result)){
	  
	  ?>
	    <tr id = "<?php echo 'trRow'.$j ?>" class="check_row" style="background-color:<?php if($row->check=='checked'){echo'#f0f000';}else{echo'#fff';}?>">	    
	      <td><?php echo $row->idd; ?></td>
	    <td class="lines" align="center"><input name="<?php echo 'ded'.$row->id; ?>" type="checkbox" value="<?php echo $row->id; ?>" onchange="setStatus(this)" <?php if($row->check=='checked'){echo"checked";}?> /></td>
	      <td><?php echo ($row->deductionid); ?></td>
	      <td class="lines amntt" align="right"><?php echo formatNumber($row->amount); ?></td>
	    </tr>
	  <?
	  $i++;
	  $j++;
	  }
	  ?>
	  <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>Total</td>
	      <td align="right"><?php echo formatNumber($amnt); ?></td>
	    </tr>
	  </table>
	  </td>
	</tr>
	
	<tr>
	  <td colspan="2" align="center">
	  LOANS
	  </td>
	</tr>
	<tr>
	  <td colspan="2">
	  <table border="1" width="100%">
	  <tr>
	    <th>#</th>
	    <th></th>
	    <th>Name</th>
	    <th>Amount</th>
	  </tr>
	  <?php
	  $i=0;
	  $amnt=0;
	  $tpaye=0;
	  
	  $employeeloans=new Employeeloans();
	  $fields="hrm_employeeloans.id,hrm_employeeloans.employeeid as idd, hrm_loans.name as loanid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_employeeloans.principal, hrm_employeeloans.month, hrm_employeeloans.year ";
	  $join=" left join hrm_loans on hrm_employeeloans.loanid=hrm_loans.id  left join hrm_employees on hrm_employeeloans.employeeid=hrm_employees.id  ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  //checks if deduction is still active
	  $where=" where hrm_employeeloans.employeeid=$employees->id and hrm_employeeloans.principal>0 ";
	  $employeeloans->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeeloans->sql;
	  
	  while($row=mysql_fetch_object($employeeloans->result)){
	  
	  ?>
	    <tr id = "<?php echo 'trRow'.$j ?>" class="check_row" style="background-color:<?php if($row->check=='checked'){echo'#f0f000';}else{echo'#fff';}?>">	    
	      <td><?php echo ($i+1); ?></td>
	    <td class="lines" align="center"><input name="<?php echo 'loan'.$row->id; ?>" type="checkbox" value="<?php echo $row->id; ?>" onchange="setStatus(this)" <?php if($row->check=='checked'){echo"checked";}?> /></td>
	    <td><?php echo ($row->loanid); ?></td>
	    <td class="lines amntt" align="center"><?php echo formatNumber($row->principal); ?></td>
	    </tr>
	  <?
	  $i++;
	  $j++;
	  }
	  ?>
	  <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>Total</td>
	      <td align="right"><?php echo formatNumber($amnt); ?></td>
	    </tr>
	  </table>
	  </td>
	</tr>
	
	<tr>
	  <td colspan="2" align="center">
	  SURCHAGES
	  </td>
	</tr>
	<tr>
	  <td colspan="2">
	  <table border="1" width="100%">
	  <tr>
	    <th>#</th>
	    <th></th>
	    <th>Name</th>
	    <th>Amount</th>
	  </tr>
	  <?php
	  $i=0;
	  $amnt=0;
	  $tpaye=0;
	  
	  $employeesurchages=new Employeesurchages();
	  $fields="hrm_employeesurchages.id, hrm_surchages.name as surchageid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_employeesurchages.amount, hrm_employeesurchages.frommonth, hrm_employeesurchages.fromyear, hrm_employeesurchages.tomonth, hrm_employeesurchages.toyear, hrm_employeesurchages.remarks, hrm_employeesurchages.createdby, hrm_employeesurchages.createdon, hrm_employeesurchages.lasteditedby, hrm_employeesurchages.lasteditedon";
	  $join=" left join hrm_surchages on hrm_employeesurchages.surchageid=hrm_surchages.id  left join hrm_employees on hrm_employeesurchages.employeeid=hrm_employees.id ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  //checks if deduction is still active
	  $where=" where hrm_employeesurchages.employeeid=$employees->id ";
// 	    if($rw->deductiontypeid==1){
	      $date=date("Y-m-d",mktime(0,0,0,$obj->month,01,$obj->year));
	      
	      $where.=" and str_to_date('$date','%Y-%m-%d') between str_to_date(concat(concat(01,concat('-',hrm_employeesurchages.frommonth)),concat('-',hrm_employeesurchages.fromyear)),'%d-%m-%Y') and str_to_date(concat(concat(01,concat('-',hrm_employeesurchages.tomonth)),concat('-',hrm_employeesurchages.toyear)),'%d-%m-%Y')  ";
// 	    }
	  $employeesurchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeesurchages->sql;
	  
	  while($row=mysql_fetch_object($employeesurchages->result)){
	  
	  ?>
	      <tr id = "<?php echo 'trRow'.$j ?>" class="check_row" style="background-color:<?php if($row->check=='checked'){echo'#f0f000';}else{echo'#fff';}?>">	    
	      <td><?php echo ($i+1); ?></td>
	      <td class="lines" align="center"><input name="<?php echo 'surchage'.$row->id; ?>" type="checkbox" value="<?php echo $row->id; ?>" onchange="setStatus(this)" <?php if($row->check=='checked'){echo"checked";}?> /></td>
	      <td><?php echo ($row->surchageid); ?></td>
	      <td class="lines amntt" align="right"><?php echo formatNumber($row->amount); ?></td>
	    </tr>
	  <?
	  $i++;
	  $j++;
	  }
	  ?>
	  <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>Total</td>
	      <td align="right"><?php echo formatNumber($amnt); ?></td>
	    </tr>
	  </table>
	  </td>
	</tr>
	<tr>
	<td colspan="2"><input name="totalamount" type="text" id="totalamount" size="12" value="<?php echo round($obj->amount,2); ?>" readonly="readonly"/>&nbsp;Total Ded:&nbsp;
	<input name="ded" type="text" id="ded" size="12" value="<?php echo round($totalded,2); ?>" readonly="readonly"/>&nbsp;Payable:&nbsp;
	<input name="payable" type="text" id="payable" size="12" value="<?php echo round(($obj->amount-$totalded),2); ?>" readonly="readonly"/></td>
	</tr>
	<tr>
	  <td colspan="2"><input type="submit" name="action" value="Save"/></td>
	</tr>
	<?php 
	}
	}
	?>
</table>
</form>
</div>
<?php
if(!empty($error)){
	showError($error);
}
?>

