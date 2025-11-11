<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../prod/blocks/Blocks_class.php");
require_once("../../prod/areas/Areas_class.php");
require_once("../../prod/sizes/Sizes_class.php");
require_once("../../prod/varietys/Varietys_class.php");

include"../../../head.php";

$obj = (object)$_POST;
?>

<script type="text/javascript">
function Clickheretoprint()
{
  poptastic('print.php?obj=<?php  echo str_replace('&','',serialize($obj)); ?>',450,940);
}
$().ready(function() {
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)))",
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

<form method="post" action="">
<table>
  <tr>
    <td>Employee:<br/>
    <input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'></td>
			</td>
      
      <td>
      Blocks:<br/> <select name="blockid" class="selectbox">
<option value="">Select...</option>
<?php
	$blocks=new Blocks();
	$where="  ";
	$fields="prod_blocks.id, prod_blocks.name, prod_blocks.length, prod_blocks.width, prod_blocks.remarks, prod_blocks.ipaddress, prod_blocks.createdby, prod_blocks.createdon, prod_blocks.lasteditedby, prod_blocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($blocks->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->blockid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;
</td>
<td>Areas:<br/> 
<?php
$areas=new Areas();
$where="  ";
$fields="prod_areas.id, prod_areas.name, prod_areas.size, prod_areas.blockid, prod_areas.status, prod_areas.remarks, prod_areas.ipaddress, prod_areas.createdby, prod_areas.createdon, prod_areas.lasteditedby, prod_areas.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
?>
<select name="areaid" class="selectbox">
<option value="">Select...</option>
<?php
	while($rw=mysql_fetch_object($areas->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->areaid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;
</td>
<td>
<td>Variety: <br/><select name="varietyid" class="selectbox">
<option value="">Select...</option>
<?php
	$varietys=new Varietys();
	$where="  ";
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($varietys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->varietyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
</td>
			<td>Sizes:<br/><select name="sizeid" class="selectbox">
<option value="">Select...</option>
<?php
	$sizes=new Sizes();
	$where="  ";
	$fields="prod_sizes.id, prod_sizes.name, prod_sizes.remarks, prod_sizes.ipaddress, prod_sizes.createdby, prod_sizes.createdon, prod_sizes.lasteditedby, prod_sizes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($sizes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->sizeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;
</td>
<td>
Quantity:<br/><input type="text" size='4' name="quantity" value="<?php echo $obj->quantity; ?>"/>
<td>
Date: <br/>
      <input type="type" name="date" size="12" class="date_input" readonly value="<?php echo $obj->date; ?>"/>
      </td><td>
No of Bar Codes:<br/>
<input type="text" name="noofbarcodes" size="4" value="<?php echo $obj->noofbarcodes; ?>"/>
</td><td>
      <input type="submit" name="action" value="Generate" class="btn"/><br/></td><td>
       <input type="button" name="action2" value="Print" class="btn" onclick="Clickheretoprint();"/>
    </td>
  </tr>
</table>
</form>
<?php
if(!empty($obj->action)){
$i=1;
$str=str_pad($obj->employeeid, 4, "0", STR_PAD_LEFT)."-".$obj->blockid."-".$obj->areaid."-".$obj->varietyid."-".$obj->sizeid."-".$obj->quantity."-".$obj->date;

$str=str_pad($str,26,0,STR_PAD_LEFT);

$employees = new Employees();
$fields = " concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->employeeid' ";
$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$employees = $employees->fetchObject;


$varietys = new Varietys();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->varietyid'";
$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$varietys = $varietys->fetchObject;

$desc=$employees->names." ".$varietys->name;

$obj->desc=$desc;

while($i<=$obj->noofbarcodes){
?>
 <img
src="../../barcodes/php.php?bctext=<?php echo $str; ?>&text=<?php echo $desc; ?>"
alt="PNG: <?php echo $str; ?>" title="PNG: <?php echo $str; ?>"/>

  <?php if($i%5==0){ ?>
  <br/>
  <br/>
  <hr/>
  <?php
  }
$i++;
}
}
?>
