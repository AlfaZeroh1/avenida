<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
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
 </script>

<div id="tabs-1" style="min-height:700px;">
<form class="forms" id="theform" action="addemployeeleavedays_proc.php" name="employeeleavedays" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
		<td>
		<?php
			$employees=new Employees();
			$where=" where id='".$_SESSION['employeeid']."' ";
			$fields="concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) name,hrm_employees.id  employeeid ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$employees=$employees->fetchObject;
			$obj->employeeid=$employees->employeeid;
                        $obj->employeename=$employees->name;
			?>
		<input type="text" name="employeename" readonly id="employeename" value="<?php echo $obj->employeename; ?>">
		<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"></td>
	        </tr>
		</td>
	</tr>
	<tr>
		<td align="right">Leave Type : </td>
			<td><select name="leavetypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$leavetypes=new Leavetypes();
	$where="";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leavetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($leavetypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->leavetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Year : </td>
		<td><input type="text" name="year" id="year" value="<?php echo $obj->year; ?>"></td>
	</tr>
	<tr>
		<td align="right">Days : </td>
		<td><input type="text" name="days" id="days" value="<?php echo $obj->days; ?>"></td>
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
?>