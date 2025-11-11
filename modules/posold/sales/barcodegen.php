<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../pos/sizes/Sizes_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");

include"../../../head.php";

$obj = (object)$_POST;
$ob = (object)$_GET;

if($ob->downsize){
  $obj->downsize=$ob->downsize;
}
?>
<script type="text/javascript">
// var str = "<?php echo $obj->greenhouseid; ?>";
// $().ready(function() { 
// 
// 
// $.get("getVarietys.php",{id:parseInt(str)},function(data){
//   $("#itemid").html(data);      
// });
// 
// $("#greenhouseid").on("change",function(){
//     str=$(this).val();
//     
//     //var st = str.split("-");
//       
//       $.get("getVarietys.php",{id:parseInt(str)},function(data){
// 	$("#itemid").html(data);      
//       });     
//       
//     
//   });
// }); 
 </script>
 <script type="text/javascript">
function Clickheretoprint()
{
  poptastic('print.php?obj=<?php  echo str_replace('&','',serialize($obj)); ?>&downsize=<?php echo $obj->downsize; ?>',450,940);
}
</script>
<form method="post" action="">
<table>
  <tr>
  <td>Green House:<br/> 
<?php
$greenhouses=new Greenhouses();
$where="  ";
$fields="*";
$join="";
$having="";
$groupby="";
$orderby=" order by name asc ";
$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
?>
<select name="greenhouseid" id="greenhouseid" class="selectbox greenhouse">
<option value="">Select...</option>
<?php
	while($rw=mysql_fetch_object($greenhouses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->greenhouseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;
</td>
  <td>
      Product: <br/><select id="itemid" name="itemid" class="selectbox">
	<option value="">Select...</option>
	<?php
	$items = new Items();
	$where="  ";
	$fields="*";
	$join=" ";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);logging($items->sql);
	?>
	<option value="">Select...</option>
	<?php
	while($row=mysql_fetch_object($items->result)){
	  ?>
	    <option value="<?php echo $row->id; ?>" <?php if($obj->itemid==$row->id){echo "selected";}?>><?php echo $row->name; ?></option>
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
	$where="";
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
<input type="text" name="noofbarcodes" size="4" value="<?php echo $obj->noofbarcodes; ?>"/>&nbsp;

<?php
// if(!empty($obj->downsize)){
?>
<!--Donwnsize Length: <select name="sizeid2" class="selectbox">
	<option value="">Select...</option>-->
	<?php
// 	$sizes = new Sizes();
// 	$fields="*";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$where="";
// 	$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	$res=$sizes->result;
// 	while($row=mysql_fetch_object($res)){
	  ?>
	    <!--<option value="<?php echo $row->id; ?>"  <?php if($row->id==$obj->sizeid2){echo"selected";}?>><?php echo initialCap($row->name); ?></option>-->
	  <?php
// 	}
	?>
<!--       </select> -->
<?php
// }
?>
<input type="hidden" name="downsize" value="<?php echo $obj->downsize; ?>"/>
</td><td>
      <input class="btn btn=info" type="submit" name="action" value="Generate" class="btn"/>
       <input class="btn btn=info" type="button" name="action2" value="Print" class="btn" onclick="Clickheretoprint();"/>
    </td>
  </tr>
</table>
</form>
<div style="font-size=25px;">
<?php
if(!empty($obj->action)){
$i=1;
if(empty($obj->greenhouseid)){
$error="Green House Must Be Provided!";
}
elseif(empty($obj->itemid)){
$error="Product Must Be Provided!";
}
elseif(empty($obj->sizeid)){
$error="Size Must Be Provided!";
}
elseif(empty($obj->quantity)){
$error="Quantity Must Be Provided!";
}
else{
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
$where="";
$where=" where id='$obj->sizeid'";
$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$sizes = $sizes->fetchObject;

$sizes2 = new Sizes();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where="";
$where=" where id='$obj->sizeid2'";
$sizes2->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$sizes2 = $sizes2->fetchObject;

$greenhouses=new Greenhouses();
$where=" where id='$obj->greenhouseid' ";
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$greenhouse=$greenhouses->fetchObject;

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

//$desc=$items->name." ".$sizes->name." (".$obj->quantity.")";
if(!empty($obj->downsize)){
  $desc.=" DS";
  
//   if(!empty($sizes->name)){
//     $desc.=$sizes2->name;
//   }
}

$obj->desc=$desc;

$j=0;

$row=mysql_fetch_object(mysql_query("select case when max(id) is null then 0 else max(id) end id from post_barcodes"));
$j=$row->id+1;

while($i<=$obj->noofbarcodes){

$str=$obj->itemid."-".$obj->sizeid."-".$obj->quantity."-".$obj->greenhouseid."-".$j."-".date("ymd")."-".$obj->sizeid2;
if(!empty($obj->downsize)){
  $str.="-".$obj->downsize;
}
$str=str_pad($str,26,0,STR_PAD_LEFT);

$desc=$items->code." ".$sizes->name."(".$obj->quantity.")-".$j."(".$greenhouse->name.") ";
?>

<img
src="../../barcodes/php.php?bctext=<?php echo $str; ?>&text=<?php echo $desc; ?>&greenhouse=<?php echo $obj->greenhouseid; ?>"
alt="PNG: <?php echo $str; ?>" title="PNG: <?php echo $str; ?>">

  <?php if($i%3==0){ ?>
  <br/>
  <br/>
  <hr/>
  <?php
  }
$i++;
$j++;
}
}
}
?>
</div>
<?php
if(!empty($error)){
	showError($error);
}
?>
