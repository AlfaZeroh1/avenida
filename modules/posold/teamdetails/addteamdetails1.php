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
  
  poptastic("print.php?itemdetailid="+itemdetailid+"&brancheid=<?php echo $brancheid; ?>&teamid="+teamid);
  
  window.top.hidePopWin(true);
  
  
}

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
				<input type="hidden" name="teamid" id="teamid" value="<?php echo $obj->teamid; ?>"></td>
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
		<td align="right">Ordered : </td>
		<td><input type="<?php echo $type; ?>" readonly name="ordered" id="ordered" value="<?php echo $obj->ordered; ?>"/></td>
	</tr>
	
	<tr>
		<td align="right">Paid : </td>
		<td><input type="<?php echo $type; ?>" readonly name="paid" id="paid" value="<?php echo $obj->paid; ?>"/></td>
	</tr>
	
	<tr>
		<td align="right">Balance : </td>
		<td><input type="text" readonly name="balance" id="balance" value="<?php echo $obj->balance; ?>"/></td>
	</tr>
	
	<tr>
		<td align="right">Remitted : </td>
		<td><input type="text" onChange="changeShort();" onKeyUp="changeShort();" name="submitted" id="submitted" value="<?php echo $obj->submitted; ?>"/></td>
	</tr>
	
	<tr>
		<td align="right">Short : </td>
		<td><input type="text" readonly name="short" id="short" value="<?php echo $obj->short; ?>"/></td>
	</tr>
	
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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
  <script type="text/javascript">clickHerePrint("<?php echo $itemdetailid; ?>","<?php echo $obj->teamid; ?>");</script>
  <?php
}
?>