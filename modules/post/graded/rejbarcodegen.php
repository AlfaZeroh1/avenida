<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../prod/rejecttypes/Rejecttypes_class.php");

include"../../../head.php";

$obj = (object)$_POST;
?>
<script type="text/javascript">
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
 
 <script type="text/javascript">
function Clickheretoprint()
{
  poptastic('rejprint.php?obj=<?php  echo str_replace('&','',serialize($obj)); ?>',450,940);
}
</script>
 
 
<form method="post" action="">
<table>
  <tr>
    <td>Reject Type:<br/>
    <select name="rejecttypeid" id="rejecttypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$rejecttypes=new Rejecttypes();
	$where="  ";
	$fields="prod_rejecttypes.id, prod_rejecttypes.name, prod_rejecttypes.remarks, prod_rejecttypes.ipaddress, prod_rejecttypes.createdby, prod_rejecttypes.createdon, prod_rejecttypes.lasteditedby, prod_rejecttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$rejecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($rejecttypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->rejecttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>
			</td>
      <td>
No of Bar Codes:<br/>
<input type="text" name="noofbarcodes" size="4" value="<?php echo $obj->noofbarcodes; ?>"/>
</td><td>
      <input  class="btn btn-info" type="submit" name="action" value="Generate" class="btn"/>
       <input  class="btn btn-info" type="button" name="action2" value="Print" class="btn" onclick="Clickheretoprint();"/>
    </td>
  </tr>
</table>
</form>
<?php
if(!empty($obj->action)){
$i=1;
while($i<=$obj->noofbarcodes){

$rejecttypes = new Rejecttypes();
$fields = " * ";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->rejecttypeid' ";
$rejecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$rejecttypes = $rejecttypes->fetchObject;

$obj->desc=$rejecttypes->name;

$str=str_pad($obj->rejecttypeid,26,0,STR_PAD_LEFT);
?>
  
<img
src="../../barcodes/php.php?bctext=<?php echo $str; ?>&text=<?php echo $rejecttypes->name; ?>"
alt="PNG: <?php echo str_pad($obj->employeeid, 4, "0", STR_PAD_LEFT); ?>" title="PNG: <?php echo str_pad($str, 4, "0", STR_PAD_LEFT); ?>">

  <?php if($i%4==0){ ?>
  <br/>
  <br/>
  <hr/>
  <?php
  }
$i++;
}
}
?>
