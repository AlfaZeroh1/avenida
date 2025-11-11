<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../prod/varietys/Varietys_class.php");

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
  poptastic('varprint.php?obj=<?php  echo str_replace('&','',serialize($obj)); ?>',450,940);
}
</script>
 
 
<form method="post" action="">
<table>
  <tr>
    <td>Reject Type:<br/>
    <select name="varietyid" id="varietyid" class="selectbox">
<option value="">Select...</option>
<?php
	$varietys=new Varietys();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name ";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($varietys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->varietyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>
			</td>
      <td>
No of Bar Codes:<br/>
<input type="text" name="noofbarcodes" size="4" value="<?php echo $obj->noofbarcodes; ?>"/>
</td><td>
      <input class="btn btn-info" type="submit" name="action" value="Generate" class="btn"/>
       <input class="btn btn-info" type="button" name="action2" value="Print" class="btn" onclick="Clickheretoprint();"/>
    </td>
  </tr>
</table>
</form>
<?php
if(!empty($obj->action)){
$i=1;
while($i<=$obj->noofbarcodes){

$varietys = new Varietys();
$fields = " * ";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->varietyid' ";
$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$varietys = $varietys->fetchObject;

$obj->desc=$varietys->name;

$str=str_pad($obj->varietyid,26,0,STR_PAD_LEFT);
?>
  
<img
src="../../barcodes/php.php?bctext=<?php echo $str; ?>&text=<?php echo $varietys->name; ?>"
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
