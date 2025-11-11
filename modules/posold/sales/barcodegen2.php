<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../crm/customers/Customers_class.php");

include"../../../head.php";

$obj = (object)$_POST;
?>
<script type="text/javascript">

$().ready(function() {
 
  $("#customername").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=customers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#customerid").val(ui.item.id);
	}
  });

 });
 </script>
 <script type="text/javascript">
function Clickheretoprint()
{
  poptastic('print3.php?obj=<?php  echo str_replace('&','',serialize($obj)); ?>',450,940);
}
</script>
<form method="post" action="">
<table>
  <tr>
  <td>
      Customer: <br/><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->customerid; ?>'>&nbsp;
    </td>
      <td>
No of Bar Codes:<br/>
<input type="text" name="noofbarcodes" size="4" value="<?php echo $obj->noofbarcodes; ?>"/>
</td><td>
      <input class="btn btn=info" type="submit" name="action" value="Generate" class="btn"/>
       <input class="btn btn=info" type="button" name="action2" value="Print" class="btn" onclick="Clickheretoprint();"/>
    </td>
  </tr>
</table>
</form>
<?php
if(!empty($obj->action)){
$i=1;

$customers = new Customers();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->customerid'";
$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$customers = $customers->fetchObject;

$obj->desc=$desc;

while($i<=$obj->noofbarcodes){

$desc=$customers->name." Box No: ".$i;

$str=$obj->customerid."-".$i;
$str=str_pad($str,26,0,STR_PAD_LEFT);
?>
  
<img
src="../../barcodes/php.php?bctext=<?php echo $str; ?>&text=<?php echo $desc; ?>"
alt="PNG: <?php echo $str; ?>" title="PNG: <?php echo $str; ?>">

  <?php if($i%3==0){ ?>
  <br/>
  <br/>
  <hr/>
  <?php
  }
  $i++;
}
}
?>
