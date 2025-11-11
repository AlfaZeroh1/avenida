<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../hrm/employees/Employees_class.php");

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
  poptastic('print.php?obj=<?php  echo str_replace('&','',serialize($obj)); ?>',450,940);
}
</script>
 
 
<form method="post" action="">
<table>
  <tr>
    <td>Employee:<br/>
    <input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'></td>
			</td>
      <td>
No of Bar Codes:<br/>
<input type="text" name="noofbarcodes" size="4" value="<?php echo $obj->noofbarcodes; ?>"/>
</td>
<td>
Days<br/>
<input type="text" name="noofday" size="4" value="<?php echo $obj->noofday; ?>"/>
</td>&nbsp;&nbsp;
<td>

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

$employees = new Employees();
$fields = " concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->employeeid' ";
$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$employees = $employees->fetchObject;

$employees->names=$employees->names." (".$obj->noofday.")";

$obj->desc=$employees->names;

$desc=$obj->employeeid."-".$obj->noofday;
$str=str_pad($desc,26,0,STR_PAD_LEFT);
$str=str_pad($desc,26,0,STR_PAD_LEFT);
?>
  
<img
src="../../barcodes/php.php?bctext=<?php echo $str; ?>&text=<?php echo $employees->names; ?>&noofday=<?php echo $obj->noofday; ?>&font=2"
alt="PNG: <?php echo str_pad($str, 8, "0", STR_PAD_LEFT); ?>" title="PNG: <?php echo str_pad($str, 8, "0", STR_PAD_LEFT); ?>">

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
