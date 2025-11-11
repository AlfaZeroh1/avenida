<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../pos/items/Items_class.php");

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
  poptastic('print.php?obj=<?php  echo str_replace('&','',serialize($obj)); ?>',450,940);
}
</script>
<form method="post" action="">
<table>
  <tr>
  <td>
      Product: <br/><select name="itemid" class="selectbox">
	<option value="">Select...</option>
	<?php
	$items = new Items();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res=$items->result;
	while($row=mysql_fetch_object($res)){
	  ?>
	    <option value="<?php echo $row->id; ?>"  <?php if($row->id==$obj->itemid){echo"selected";}?>><?php echo initialCap($row->name); ?></option>
	  <?php
	}
	?>
      </select>&nbsp;
    </td>
    <td>
      Size: <br/><select name="sizeid" class="selectbox">
	<option value="">Select...</option>
	<?php
	$sizes = new Sizes();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res=$sizes->result;
	while($row=mysql_fetch_object($res)){
	  ?>
	    <option value="<?php echo $row->id; ?>"  <?php if($row->id==$obj->sizeid){echo"selected";}?>><?php echo initialCap($row->name); ?></option>
	  <?php
	}
	?>
      </select>&nbsp;
      </td>
      <td>
      Quantity: <br/><input name="quantity" size="4" type="text" value="<?php echo $obj->quantity;?>"/>&nbsp;
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

$items = new Items();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->itemid'";
$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$items = $items->fetchObject;

$sizes = new Sizes();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$obj->sizeid'";
$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$sizes = $sizes->fetchObject;

if(strlen($items->name)>10){
                $v=explode(" ",$items->name);
                $x=0;
                while($x<count($v)){
                        if($x==0)
                                $items->name=substr(trim(initialCap($v[$x])),0,1)." ";
                        else
                                $items->name.=trim(initialCap($v[$x]))." ";
                        $x++;
                }
        }

$desc=$items->name." ".$sizes->name." (".$obj->quantity.")";

$obj->desc=$desc;

$str=$obj->itemid."-".$obj->sizeid."-".$obj->quantity."-".$i."-".date("ymd");
$str=str_pad($str,26,0,STR_PAD_LEFT);
while($i<=$obj->noofbarcodes){
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
