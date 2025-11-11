<title>WiseDigits: Generaljournalaccounts </title>
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
 </script>

<div class='main'>
<form class="forms" id="theform" action="addgeneraljournalaccounts_proc.php" name="generaljournalaccounts" method="POST" enctype="multipart/form-data">
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
		<td align="right">Code : </td>
		<td><input type="text" name="code" id="code" value="<?php echo $obj->code; ?>"></td>
	</tr>
	<tr>
		<td align="right">Name : </td>
		<td><input type="text" name="name" id="name" size="45"  value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Account Type : </td>
			<td><select name="acctypeid">
<option value="">Select...</option>
<?php
	$acctypes=new Acctypes();
	$where="  ";
	$fields="sys_acctypes.id, sys_acctypes.name, sys_acctypes.balance";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$acctypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($acctypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->acctypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Reference : </td>
		<td>
		<?php
		if($obj->acctypeid==29){
		  $customers = new Customers();
		  $fields=" * ";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby=" order by name ";
		  $where=" where id not in(select refid from fn_generaljournalaccounts where acctypeid=29 and refid is not null) or id='$obj->refid'";
		  $customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  ?>
		  <select name="refid" class="select-box">
		  <option value="">Select...</option>
		  <?
		  while($row=mysql_fetch_object($customers->result)){
		    ?>
		    <option value="<?php echo $row->id; ?>" <?php if($obj->refid==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
		    <?php
		  }
		}elseif($obj->acctypeid==30){
		  $suppliers = new Suppliers();
		  $fields=" * ";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby=" order by name ";
		  $where=" where id not in(select refid from fn_generaljournalaccounts where acctypeid=30 and refid is not null) or id='$obj->refid'";
		  $suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  ?>
		  <select name="refid" class="select-box">
		  <option value="">Select...</option>
		  <?
		  while($row=mysql_fetch_object($suppliers->result)){
		    ?>
		    <option value="<?php echo $row->id; ?>" <?php if($obj->refid==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
		    <?php
		  }
		}elseif($obj->acctypeid==8){
		  $banks = new Banks();
		  $fields=" * ";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby=" order by name ";
		  $where=" where id not in(select refid from fn_generaljournalaccounts where acctypeid=8 and refid is not null) or id='$obj->refid'";
		  $banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  ?>
		  <select name="refid" class="select-box">
		  <option value="">Select...</option>
		  <?
		  while($row=mysql_fetch_object($banks->result)){
		    ?>
		    <option value="<?php echo $row->id; ?>" <?php if($obj->refid==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
		    <?php
		  }
		}else{
		?>
		<input type="text" name="refid" id="refid" value="<?php echo $obj->refid; ?>">
		<?php
		}
		?>
		</td>
	</tr>
	<tr>
	  <td align="right">Currency:</td>
	  <td><select name="currencyid">
				<option value="">Select...</option>
				<?php
				$currencys = new Currencys();
				$fields="* ";
				$join=" ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" ";
				$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($currencys->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->currencyid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select></td>
	</tr>
	<tr>
		<td align="right">Category : </td>
			<td><select name="categoryid">
<option value="">Select...</option>
<?php
	$generaljournalaccounts=new Generaljournalaccounts();
	$where="  ";
	$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.code, fn_generaljournalaccounts.name, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.categoryid, fn_generaljournalaccounts.ipaddress, fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by fn_generaljournalaccounts.name ";
	if(!empty($obj->id)){
	  $where.=" where fn_generaljournalaccounts.acctypeid='$obj->acctypeid'";
	}
	$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($generaljournalaccounts->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->categoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>