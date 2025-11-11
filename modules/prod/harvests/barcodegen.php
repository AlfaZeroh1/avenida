<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../prod/blocks/Blocks_class.php");
require_once("../../prod/sections/Sections_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");
require_once("../../prod/areas/Areas_class.php");
require_once("../../prod/sizes/Sizes_class.php");
require_once("../../prod/varietys/Varietys_class.php");

include"../../../head.php";

$obj = (object)$_POST;
?>

<script type="text/javascript">
function Clickheretoprint()
{
  poptastic('print.php?obj=<?php  echo str_replace('&','',serialize($obj)); ?>&arr=<?php  echo str_replace('&','',serialize($arr)); ?>&date=<?php  echo str_replace('&','',serialize($date)); ?>',450,940);
}
$().ready(function() {
<?php
$i = 0;
  while($i<$obj->days){
?>
  $("#employeename<?php echo $i; ?>").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid<?php echo $i; ?>").val(ui.item.id);
	}
  });

 <?php
 $i++;
 }
 ?>
});

$(document).ready(function(){
<?php
$j=0;
while($j<$obj->days){
?>
  $("#blockid<?php echo $j; ?>").on("change",function(){
    var str=$(this).val();
    
    //var st = str.split("-");
      
      $.get("getSections.php",{id:parseInt(str)},function(data){
	$("#sectionid<?php echo $j; ?>").html(data);      
      });     
      
    
  });
  $("#sectionid<?php echo $j; ?>").on("change",function(){
    var str=$(this).val();
    
    //var st = str.split("-");
      
      $.get("getSectionEmployee.php",{id:parseInt(str)},function(data){
	
	var st = data.split("-");
	$("#employeeid<?php echo $j; ?>").val(st[0]);
	$("#employeename<?php echo $j; ?>").val(st[1]);      
      });
      
      $.get("getGreenHouses.php",{id:parseInt(str)},function(data){
	$("#greenhouseid<?php echo $j; ?>").html(data);      
      });
    
  });
  $("#greenhouseid<?php echo $j; ?>").on("change",function(){
    var str=$(this).val();
      
      $.get("getVarietys.php",{id:parseInt(str)},function(data){
	$("#varietyid<?php echo $j; ?>").html(data);      
      });     
      
    
  });
  $("#varietyid<?php echo $j; ?>").on("change",function(){
    var str=$(this).val();
      
      $.get("getVariety.php",{id:parseInt(str)},function(data){
	$("#quantity<?php echo $j; ?>").val(data);      
      });     
      
    
  });
  <?php
  $j++;
  }
  ?>
})
</script>

<form method="post" action="">
<table>
  <tr>
    <td colspan="4">How many Barcodes? <input type="text" name="days" value="<?php echo $obj->days; ?>"/>
    <input type="submit" name="action" class="btn" value="Draw"/>
  </tr>
  <?php if(!empty($obj->days)){?>
  <tr>
    

  </tr>
  <?php
  $i = 0;
  while($i<$obj->days){
  ?>
  <tr>
  <td>
      Blocks:<br/> <select id="blockid<?php echo $i; ?>" name="blockid<?php echo $i; ?>" class="selectbox block" onchange>
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
		<option value="<?php echo $rw->id; ?>" <?php if($_POST['blockid'.$i]==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;
</td>
<td>Section:<br/> 
<?php
$sections=new Sections();
$where="  ";
$fields="prod_sections.id, prod_sections.name, prod_blocks.name blockid";
$join=" left join prod_blocks on prod_blocks.id=prod_sections.blockid ";
$having="";
$groupby="";
$orderby="";
$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
?>
<select name="sectionid<?php echo $i; ?>" id="sectionid<?php echo $i; ?>" class="selectbox section">
<option value="">Select...</option>
<?php
	while($rw=mysql_fetch_object($sections->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($_POST['sectionid'.$i]==$rw->id){echo "selected";}?>><?php echo initialCap($rw->blockid." ".$rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;
</td>
<td>Green House:<br/> 
<?php
$greenhouses=new Greenhouses();
$where="  ";
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
?>
<select name="greenhouseid<?php echo $i; ?>" id="greenhouseid<?php echo $i; ?>" class="selectbox greenhouse">
<option value="">Select...</option>
<?php
	while($rw=mysql_fetch_object($greenhouses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($_POST['greenhouseid'.$i]==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;
</td>
  <td>In Charge:<br/>
    <input type='text' size='25' name='employeename<?php echo $i; ?>' id='employeename<?php echo $i; ?>' value='<?php echo $_POST['employeename'.$i]; ?>'>
					<input type="text" size='2' readonly name='employeeid<?php echo $i; ?>' id='employeeid<?php echo $i; ?>' value='<?php echo $_POST['employeeid'.$i]; ?>'></td>
			</td>
      
      
<td>Variety: <br/><select name="varietyid<?php echo $i; ?>" id="varietyid<?php echo $i; ?>" class="selectbox">
<option value="">Select...</option>
<?php
	$varietys=new Varietys();
	$where="  ";
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($varietys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($_POST['varietyid'.$i]==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
</td>
			<td>Sizes:<br/><select name="sizeid<?php echo $i; ?>" class="selectbox">
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
		<option value="<?php echo $rw->id; ?>" <?php if($_POST['sizeid'.$i]==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>&nbsp;
</td>
<td>
Quantity:<br/><input type="text" size='4' name="quantity<?php echo $i; ?>" id="quantity<?php echo $i; ?>" value="<?php echo $_POST['quantity'.$i]; ?>"/>
    <td align="right">
<!--Date <?php //echo ($i+1);?>:<br/>
      <input type="type" name="date<?php //echo $i; ?>" size="10" class="date_input" readonly value="<?php //echo $_POST['date'.$i]; ?>"/>-->
      </td>
      <td align="right">
No of Bar Codes: <br/>
<input type="text" name="noofbarcodes<?php echo $i; ?>" size="4" value="<?php echo $_POST['noofbarcodes'.$i]; ?>"/>
</td>
  </tr>
  <?php
  $i++;
  }
  ?>
  <?php
  }
  ?>
  
  <tr>
  <td colspan='4' align='center'>
      <input type="submit" name="action" value="Generate" class="btn"/><br/></td><td>
       <input type="button" name="action2" value="Print" class="btn" onclick="Clickheretoprint();"/>
    </td>
  </tr>
</table>
</form>
<?php
if($obj->action=="Generate"){
$arr = array();
$date=array();
$j=0;
while($j<$obj->days){
  $str=str_pad($_POST['employeeid'.$j], 4, "0", STR_PAD_LEFT)."-".$_POST['greenhouseid'.$j]."-".$_POST['varietyid'.$j]."-".$_POST['sizeid'.$j]."-".$_POST['quantity'.$j]."-".$_POST['date'.$j];

  $str=str_pad($str,26,0,STR_PAD_LEFT);

  $employees = new Employees();
  $fields = " concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) names";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='".$_POST['employeeid'.$j]."' ";
  $employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $employees = $employees->fetchObject;


  $varietys = new Varietys();
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='".$_POST['varietyid'.$j]."'";
  $varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $varietys = $varietys->fetchObject;
  
  $sizes = new Sizes();
  $fields="*";
  $join="";
  $having="";
$groupby="";
  $orderby="";
  $where=" where id='".$_POST['sizeid'.$j]."'";
  $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $sizes = $sizes->fetchObject;
  
    $greenhouses=new Greenhouses();
  $where="  ";
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $where=" where id='".$_POST['greenhouseid'.$j]."'";
  $greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $greenhouses = $greenhouses->fetchObject;

	if(strlen($varietys->name)>10){
		$v=explode(" ",$varietys->name);
		$i=0;
		while($i<count($v)){
			if($i==0)
				$varietys->name=substr(trim(initialCap($v[$i])),0,1)." ";
			else
				$varietys->name.=trim(initialCap($v[$i]))." ";
			$i++;
		}
	}
  $desc=$greenhouses->name." ".trim($employees->names)." ".$varietys->name." ".$sizes->name;//." ".getDat($_POST['date'.$j]);

  $obj->desc=$desc;
$i=1;
$arr[$j]=$_POST['noofbarcodes'.$j];
//$date[$j]=$_POST['date'.$j];
  while($i<=$_POST['noofbarcodes'.$j]){
	$desc = str_replace("&","$",$desc);
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
  $j++;
  }
}
?>
