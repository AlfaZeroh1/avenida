<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
$pop=1;
include "../../../head.php";

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
 
 function changeShort(){
  var remitted = ($("#submitted").val());
  var paid = ($("#balance").val());
  
  var short = paid-remitted;
  
  $("#short").val(short);
 }
 

function clickHerePrint(itemdetailid,teamid){
  
  poptastic("print.php?itemdetailid="+itemdetailid+"&brancheid=<?php echo $obj->brancheid; ?>&teamid="+teamid);
  
  window.top.hidePopWin(true);
  
  
}

function getPaymentCategorys(id){
  var paymentcategory=document.getElementById("paymentcategory");
  
  if(id==7){
    paymentcategory.style.display="block";
  }else{
    paymentcategory.style.display="none";
  }
 }
 
 womAdd('getPaymentCategorys("<?php echo $obj->paymentmodeid; ?>")');
 womOn();
 </script>

<div id="tabs-1" style="min-height:700px;">
<form class="forms" id="theform" action="addteamdetails_proc.php" name="teamdetails" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
				<input type="hidden" name="teamid" id="teamid" value="<?php echo $obj->teamid; ?>">
				<input type="hidden" name="cashier" id="cashier" value="<?php echo $obj->cashier; ?>">
				<input type="hidden" name="brancheid" id="brancheid" value="<?php echo $obj->brancheid; ?>"></td>
	</tr>
	<tr>
	  <td align="right">Selling Location:</td>
	  <td><select name="brancheid">
	    <option value="">Select...</option>
	  <?php
		$branches = new Branches();
		$fields=" * ";
		$join="";
		$groupby="";
		$having="";
		$where=" where id='$obj->brancheid' " ;
		$branches->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		while($rw=mysql_fetch_object($branches->result)){
		?>
		  <option value="<?php echo $rw->id; ?>" <?php if($rw->id==$obj->brancheid)echo "selected";?>><?php echo $rw->name; ?></option>
		<?php
		}
		?>
	    </select></td>
	</tr>
	<tr>
		<td align="right">Team Role : </td>
			<td><select name="teamroleid" class="selectbox">
<option value="">Select...</option>
<?php
	$teamroles=new Teamroles();
	$where="  ";
	$fields="pos_teamroles.id, pos_teamroles.name, pos_teamroles.remarks, pos_teamroles.ipaddress, pos_teamroles.createdby, pos_teamroles.createdon, pos_teamroles.lasteditedby, pos_teamroles.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teamroles->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($teamroles->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->teamroleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Employee Name : </td>
			<td><input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
			    <input type="text" readonly name="employeename" id="employeename" value="<?php echo $obj->employeename; ?>"/></td>
	</tr>
	
	<?php
	  //Authorization.
	  $auth->roleid="7486";//View
	  $auth->levelid=$_SESSION['level'];

	  if(existsRule($auth)){
	    $type="text";
	  }else{ 
	    $type="hidden";
	  }
	  ?>
	<tr>
		<?php if($obj->cashier==1){ ?>
		<td align="right">Collected : </td>
		<?php }else{ ?>
		<td align="right">Ordered : </td>
		<?php } ?>
		<td><input type="<?php echo $type; ?>" readonly name="ordered" id="ordered" value="<?php echo $obj->ordered; ?>"/></td>
	</tr>
	
	<?php if($obj->cashier==1){ ?>
	<tr>
		<td align="right">Float : </td>
		<td><input type="text" readonly name="float" id="float" value="<?php echo $obj->float; ?>"/></td>
	</tr>
	<?php } ?>
	
	<tr>
		<td align="right">Paid : </td>
		<td><input type="<?php echo $type; ?>" readonly name="paid" id="paid" value="<?php echo $obj->paid; ?>"/></td>
	</tr>
	
	<tr>
		<td align="right">Balance : </td>
		<td><input type="text" readonly name="balance" id="balance" value="<?php echo $obj->balance; ?>"/></td>
	</tr>
	
	
	
	<tr>
		<td align="right">Short : </td>
		<td><input type="text" readonly name="short" id="short" value="<?php echo $obj->short; ?>"/></td>
	</tr>
	
	<!--<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>-->
	
	<tr>
	  <td colspan='2' align="center">
	    <table class="table">
	      <td>Mode:
	      <select name='paymentmodeid' id='paymentmodeid' onchange="getPaymentCategorys(this.value);" class="selectbox">
		  <option value="">Select...</option>
		  <?php
		  $paymentmodes=new Paymentmodes();
		  $fields="*";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $where="";
		  $paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

		  while($rw=mysql_fetch_object($paymentmodes->result)){
		  ?>
			  <option value="<?php echo $rw->id; ?>" <?php if($obj->paymentmodeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
		  <?php
		  }
		  ?>
		</select>
	      </td>
	      <td><div id="paymentcategory">Account: <select name='imprestaccountid' id='imprestaccountid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$paymentcategorys=new Imprestaccounts();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$paymentcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentcategorys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->imprestaccountid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
			</div></td>
	      <td>Amount
	      <input type="text" size="8" name="paid" value="<?php echo $obj->paid; ?>"/></td>
	      <td>Remarks<input type="text" name="remarks" value="<?php echo $obj->remarks; ?>"/></td>
	      <td><input type="submit" name="action2" class="btn btn-warning" value="ADD"/>
	     </tr>
	     
	     <?php
	     $query="select sys_paymentmodes.name paymentmodeid, fn_banks.name bankid, fn_imprestaccounts.name imprestaccountid, pos_teampayments.amount, pos_teampayments.remarks, pos_teampayments.id from pos_teampayments left join sys_paymentmodes on pos_teampayments.paymentmodeid=sys_paymentmodes.id left join fn_banks on fn_banks.id=pos_teampayments.bankid left join fn_imprestaccounts on fn_imprestaccounts.id=pos_teampayments.imprestaccountid where pos_teampayments.teamdetailid='$obj->id'  and pos_teampayments.brancheid='$obj->brancheid' and pos_teampayments.cashier='$obj->cashier' ";
	     $rs=mysql_query($query);
	     while($row=mysql_fetch_object($rs)){
	     ?>
	     
	     <tr>
	      <td><?php echo $row->paymentmodeid; ?></td>
	      <td><?php echo $row->bankid.$row->imprestaccountid; ?></td>
	      <td><?php echo formatNumber($row->amount); ?></td>
	      <td><?php echo $row->remarks; ?></td>
	      <td><a href="addteamdetails_proc.php?id=<?php echo $obj->id; ?>&brancheid2=<?php echo $obj->brancheid; ?>&employeeid=<?php echo $obj->employeeid; ?>&teamid=<?php echo $obj->teamid; ?>&delid=<?php echo $row->id; ?>">DEL</a></td>
	     </tr>
	     
	     <?php
	     }
	     ?>
	     
	    </table>
	  </td>
	</tr>
	
	<tr>
		<td colspan="2" align="center"><input type="button" onClick="clickHerePrint('<?php echo $obj->id; ?>','<?php echo $obj->teamid; ?>')" class="btn btn-info" name="action" id="action" value="PRINT">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
if($saved=="Yes"){
  ?>
<!--   <script type="text/javascript">clickHerePrint("<?php echo $obj->id; ?>","<?php echo $obj->teamid; ?>");</script> -->
  <?php
}
?>