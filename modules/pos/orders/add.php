<title>WiseDigits ERP: Orders </title>
<?php 
include "../../../head.php";

?>

<hr>
<div class="content">
<form  id="theform" action="addorders_proc.php" name="orders" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample" onsubmit="return checkForm(this, event);">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>
		Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			
		</table>
	<table width="50%" class="table gridd" >
	
	<tr>
		<td align="right">Product:</td>
		<td><input type="text"  name="itemname" id="itemname" value="<?php echo $obj->itemname; ?>"/>
		      <input type="hidden" name="itemid" id="itemid" value="<?php echo $obj->itemid; ?>"/>
		      <font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Quantity: </td>
		<td><input type="text" name="quantity" id="quantity" size="16" value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
	</tr>
	
	<tr>
		<td align="right">Price: </td>
		<td><input type="text" name="price" id="price" size="16" readonly value="<?php echo $obj->price; ?>"><font color='red'>*</font></td>
	</tr>
	
	<tr>	
		<td align="right">Memo: </td>
		<td><textarea name="memo" id="memo"><?php echo $obj->memo; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="button" onclick="saveForm();" class="btn btn-primary" name="action2" value="Add"/></td>
	</tr>
	</table>
	
		<table align='center'>
		<tr>
			<td style="color:red;"><?php echo $_SESSION['employeename'];?></td>
			<td>Order No:</td>
			<td><input type="text" name="orderno" id="orderno" readonly size="16"  value="<?php echo $obj->orderno; ?>"></td>
			<td>Date Ordered:</td>
			<td><input type="date" name="orderedon" id="orderedon"  class="date_input" size="16" readonly  value="<?php echo $obj->orderedon; ?>"></td>
			<td>Remarks:</td>
			<td><textarea name="remarks" ><?php echo $obj->remarks; ?></textarea></td>
		</tr>
		</table>
<table class="table display" width="100%">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<?php if(!empty($obj->retrieve)){?>
		<th>&nbsp;</th>
		<?php }?>
		<th align="left">Product  </th>
		<th align="left">Qty</th>
		<th align="left">Price</th>
		<th align="left">Total</th>
		<th align="left">Memo <input type="hidden" id="iterator" name="iterator" value="<?php echo $obj->iterator; ?>"/> </th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	
	if($_SESSION['shporders']){
		$shporders=$_SESSION['shporders'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<?php if(!empty($obj->retrieve)){?>
			<td><input type="checkbox" name="<?php echo $shporders[$i]['id']; ?>"/></td>
			<?php }?>
			<td><?php echo $shporders[$i]['itemname']; ?> </td>
			<td><?php echo $shporders[$i]['quantity']; ?> </td>
			<td><?php echo $shporders[$i]['price']; ?> </td>
			<td><?php echo $shporders[$i]['total']; ?> </td>
			<td><?php echo $shporders[$i]['memo']; ?> </td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=1" onclick="return confirm('Are you sure you want to delete?')">Del</a></td>
		</tr>
		<?php
		$i++;
		$j--;
		}
	}
	?>
	</tbody>
</table>
<table align="center" width="100%">
	<?php //if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input  class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
		
	</tr>
	<?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input type="button" value="Print" onclick="Clickheretoprint();"/>
		<input type="submit" name="action" id="action" value="Confirm Order" />
		<input type="submit" name="action" id="action" value="Copy Order" />
		
		</td>
	</tr>
	<?php }?>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
</hr>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
if($saved=="Yes"){
	redirect("addorders_proc.php?retrieve=");
}

?>