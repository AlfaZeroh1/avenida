<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Estimations_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../processes/Processes_class.php");

// Additions for recipe Master
require_once("../../inv/branchstocks/Branchstocks_class.php");
require_once("../../bom/estimationdetails/Estimationdetails_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Estimations";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11369";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$obj = (object)$_POST;

if(empty($obj->action)){
  $obj->processedon=date("Y-m-d");
}

// ********************ORIGINAL *******************************************************
// if($obj->action=="Process"){echo "HERE";
  
//   $shpprocessings = $_SESSION['shpprocessings'];
  
//   $i=0;
//   $shprequisitions = array();
//   while($i<count($shpprocessings)){
    
//     $processes = new Processes();
    
//     $processes->estimationid = $shpprocessings[$i]['estimationid'];
//     $processes->quantity = $shpprocessings[$i]['quantity'];
//     $processes->processedon=$obj->processedon;
//     $processes->createdby=$_SESSION['userid'];
//     $processes->createdon=date("Y-m-d H:i:s");
//     $processes->lasteditedby=$_SESSION['userid'];
//     $processes->lasteditedon=date("Y-m-d H:i:s");
//     $processes->ipaddress=$_SERVER['REMOTE_ADDR'];
    
//     $processes = $processes->setObject($processes);
//     $processes->add($processes);
    
//     $i++;
    
//   } 
  
//   redirect("../processes/processes.php?processedon=".$obj->processedon);
// }
// ************************* END OF ORIGINAL ******************************************


//  *********************************EDITED*******************************************************
if($obj->action=="Process"){
  // Get The max DocumentNo in inv_stocktrack
  $max_doc_no_query = "SELECT COALESCE((MAX(documentno)+1),1) as recipe_document_no from inv_stocktrack where transaction like '%Recipe%'";
  $max_doc_no_res = mysql_query($max_doc_no_query);
  $recipe_document_no = mysql_fetch_object($max_doc_no_res)->recipe_document_no;
  //die($recipe_document_no." is the max documentno");
  // die(print_r($obj));
  // echo "HERE";
  // Hard Coded to point to Kitchen Centre in sys_branches...will be modified later
  $brancheid=$obj->brancheid;
  $shpprocessings = $_SESSION['shpprocessings'];
  //validate(
  if(empty($shpprocessings)){
    echo "<script>alert('Please Choose at least one item to process')</script>";
  }
  else if(empty($brancheid)){
    echo "<script>alert('Please Choose a Store')</script>";
  }
  else{
    // Final array after ommiting items that cannot be deducted due to ingredient deficit in the store
    $shpprocessings_filtered = array();
    echo "<br>**************************************************************************************<br>";
    foreach($shpprocessings as $item_array){
      echo"<br>>>>>>>>>><br>";
      $item_array = (object)$item_array;
      //Get The item Name From the Estimation ID;
      $estimation = new Estimations();
      $fields=" bom_estimations.itemid, inv_items.name as itemname ";
      $join=" LEFT JOIN  inv_items on inv_items.id=bom_estimations.itemid ";
      $where=" WHERE bom_estimations.id='$item_array->estimationid'";
      $having="";
      $groupby="";
      $orderby=" ";
      $estimation->retrieve($fields,$join,$where,$having,$groupby,$orderby);
      // echo $estimation->sql;die();
      $rw=mysql_fetch_object($estimation->result);
        // Used to check if any ingredient is short
        $ingredient_shortage = false;
        $missing_ingredient = '';
        // will be used to Store igredient Quantity and branchstock id later
        $ingredients=array();
        // Get id for all items used to create the item
        $estimationdetails = new Estimationdetails();
        $fields="*";
        $join=" ";
        $where=" WHERE estimationid=".$item_array->estimationid;
        $having="";
        $groupby="";
        $orderby=" ";
        $estimationdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
        // echo $estimationdetails->sql;die();
        $quantity_needed=0;
        while($rwd=mysql_fetch_object($estimationdetails->result)){
          //Get the quantity Needed for that stock
          $quantity_needed = $rwd->quantity*$item_array->quantity;
          // CHeck if the quantity needed is available in that store;
          $branchstocks = new Branchstocks();
          $fields="inv_branchstocks.*, inv_items.name as ingredient";
          $join=" LEFT JOIN  inv_items on inv_items.id=inv_branchstocks.itemid";
          $where=" WHERE inv_branchstocks.itemid=".$rwd->itemid." AND brancheid=$brancheid";
          $having="";
          $groupby="";
          $orderby=" ";
          $branchstocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
          // die($branchstocks->sql);
          $rwb=mysql_fetch_object($branchstocks->result);
          // If Quantity is less then deduction cannot occur
          if(!$rwb->quantity){$rwb->quantity = 0;}
          if($rwb->quantity < $quantity_needed){
            $ingredient_shortage = true;
            $missing_ingredient = $rwb->ingredient;
            $deficit = $quantity_needed - $rwb->quantity;
            // Printout a notification indicating to the user that the transaction was not successful
            // echo "$branchstocks->sql;";
            echo "<script>alert('Apologies, I was unable to process $rw->itemname as the ingredient $missing_ingredient is shy of quantity $deficit . You requested ingredient quantity equivalent of $quantity_needed and there is only $rwb->quantity available')</script>";
            // Stop Looping 
            break;
          }else{
            // Add the ingredient to Array
            $ingredients[] = array("branchstocksid"=>$rwb->id,"itemid"=>$rwd->itemid,"name"=>$rwb->ingredient,"quantity_used"=>$quantity_needed);//Quantity used because it is the quantity used to make the checked item
          }
        }
        // If there is no missing ingredient then add to list
        if(!$ingredient_shortage){
          // die(print_r($ingredients));
          // Here we'll add all add stock then deduct stock accordingly.
          foreach($ingredients as $ing){
            
            
            $ing = (object)$ing;
            $quantity_needed =($ing->quantity_used)*-1;
            $reduce_stock = "UPDATE inv_branchstocks SET quantity=quantity-".$ing->quantity_used." WHERE id= $ing->branchstocksid;";
            // echo $reduce_stock;die();
            if(mysql_query($reduce_stock)){
              // Get what has remained
              $remain = "SELECT quantity from inv_branchstocks WHERE id= $ing->branchstocksid;";
              $remain_res = mysql_query($remain);
              $ing->remain = mysql_fetch_object($remain_res)->quantity;
              // ADD RECORD TO STOCK TRACK
              $add_to_stocktrack = "INSERT INTO inv_stocktrack(itemid,brancheid,documentno,quantity,remain,recorddate,status,transaction,createdby,createdon,lasteditedby,lasteditedon,ipaddress) VALUES($ing->itemid,$brancheid,$recipe_document_no,$quantity_needed,$ing->remain,CURDATE(),0,'Recipe Master Ingredient',". $_SESSION['userid'].", NOW(),". $_SESSION['userid'].",NOW(),'". $_SERVER['REMOTE_ADDR']."')";
              if(mysql_query($add_to_stocktrack)){
                //  
              }else{echo mysql_error();}
            }else{echo mysql_error();}
          }
          // Now add to stock of the item
          $add_stock = "UPDATE inv_branchstocks SET quantity=quantity+".$item_array->quantity." WHERE inv_branchstocks.itemid=".$rw->itemid." AND brancheid=$brancheid;";
          // die($add_stock);
          if(mysql_query($add_stock)){
            // Get what has remained
            $remain = "SELECT quantity from inv_branchstocks WHERE inv_branchstocks.itemid=".$rw->itemid." AND brancheid=$brancheid;";
            $remain_res = mysql_query($remain);
            $rw->remain = mysql_fetch_object($remain_res)->quantity;
            // ADD RECORD TO STOCK TRACK
            $add_to_stocktrack = "INSERT INTO inv_stocktrack(itemid,brancheid,documentno,quantity,remain,recorddate,status,transaction,createdby,createdon,lasteditedby,lasteditedon,ipaddress) VALUES($rw->itemid,$brancheid,$recipe_document_no,$item_array->quantity,$rw->remain,CURDATE(),0,'Recipe Master Product',". $_SESSION['userid'].", NOW(),". $_SESSION['userid'].",NOW(),'". $_SERVER['REMOTE_ADDR']."')";
            if(mysql_query($add_to_stocktrack)){
              // echo "<br>Success! $rw->itemname has been processed<br>";
            }else{
              echo "<br>Error! $rw->itemname has not been processed<br>";
              echo mysql_error();
            }
          }else{echo mysql_error();}
          // echo"<br>$rw->itemname added to shp array<br>";
          // Add the item to final
          $item_array = (array)$item_array;
          $shpprocessings_filtered[] = $item_array;
          $recipe_document_no++;
        }else{
          echo"<br>$rw->itemname was not  added to shp array<br>";
        }
        // echo "<br>";print_r($ingredients);
        // echo "<br><br><br>";
    }
    // $shpprocessings = $shpprocessings_filtered;
    // echo"<br>THis is the Before shpprocessing variable<br>";
    // print_r($shpprocessings);
    // echo"<br>THis is the FInal FIltered shpprocessing variable<br>";
    // print_r($shpprocessings_filtered);
    $shpprocessings = $shpprocessings_filtered;
    // Alert User That Process is COmplete
    echo "<script>alert('SUCCESS! Process Complete')</script>";

    // die();  
    
    $i=0;
    $shprequisitions = array();
    while($i<count($shpprocessings)){
      
      $processes = new Processes();
      
      $processes->estimationid = $shpprocessings[$i]['estimationid'];
      $processes->quantity = $shpprocessings[$i]['quantity'];
      $processes->processedon=$obj->processedon;
      $processes->createdby=$_SESSION['userid'];
      $processes->createdon=date("Y-m-d H:i:s");
      $processes->lasteditedby=$_SESSION['userid'];
      $processes->lasteditedon=date("Y-m-d H:i:s");
      $processes->ipaddress=$_SERVER['REMOTE_ADDR'];
      
      $processes = $processes->setObject($processes);
      $processes->add($processes);
      
      $i++;
      
    } 

    
    redirect("../processes/processes.php?processedon=".$obj->processedon);
  }
}
//  *********************************END OF EDITED*******************************************************

if($obj->action=="Request from Store"){
  
  $shpprocessings = $_SESSION['shpprocessings'];
  
  $i=0;
  $shprequisitions = array();
  while($i<count($shpprocessings)){
    
    $estimationid = $shpprocessings[$i]['estimationid'];
    $quantity = $shpprocessings[$i]['quantity'];
    
    $query="select bom_estimationdetails.*, inv_items.name itemname, inv_items.costprice from bom_estimationdetails left join inv_items on inv_items.id=bom_estimationdetails.itemid where estimationid='$estimationid'";
    $res = mysql_query($query);
    $it=0;
    while($row=mysql_fetch_object($res)){
      
      $row->quantity = $quantity*$row->quantity;
      $row->total = $row->quantity*$row->costprice;
      
      $shprequisitions[$it]=array('itemid'=>"$row->itemid", 'itemname'=>"$row->itemname", 'quantity'=>"$row->quantity", 'aquantity'=>"$obj->aquantity", 'reorderlevel'=>"$obj->reorderlevel",'maxreorderlevel'=>"$obj->maxreorderlevel",'stock'=>"$obj->stock", 'memo'=>"Kitchen Requisition", 'total'=>"$obj->total");
      
      $it++;
      
    }
    $i++;
  }
  $ob->brancheid=30;
  $_SESSION['ob']=$ob;
  
  $_SESSION['shprequisitions']=$shprequisitions;
  redirect("../../inv/requisitions/addrequisitions_proc.php?raise=1");
  
}

unset($_SESSION['shpprocessings']);

$delid=$_GET['delid'];
$estimations=new Estimations();
if(!empty($delid)){
	$estimations->id=$delid;
	$estimations->delete($estimations);
	redirect("estimations.php");
}
//Authorization.
$auth->roleid="11368";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addestimations_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>

<script type="text/javascript" charset="utf-8">
function activateQuantity(str){
  
  if(str.checked==true){
    $("#qnt"+str.id).prop("readonly",false);
  }else{
    $("#qnt"+str.id).prop("readonly",true);
  }
  
}

function setQuantity(str,id){
  $.post("set.php",{checked:true,estimationid:id,quantity:str.value,type:"shpprocessings"});
}
</script>
<form action="estimations.php" method="post">
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>Department</th>
			<th>Item Type </th>
			<th>Perc(%) </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="11370";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11371";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="bom_estimations.id, bom_estimations.name, inv_items.name as itemid, bom_estimations.createdby,bom_estimations.prc, bom_estimations.createdon, bom_estimations.lasteditedby, bom_estimations.lasteditedon, bom_estimations.ipaddress, inv_departments.name departmentid ";
		$join=" left join inv_items on bom_estimations.itemid=inv_items.id left join inv_departments on inv_departments.id=inv_items.departmentid ";
		$having="";
		$groupby="";
		$orderby="";
		$estimations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$estimations->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><input type="checkbox" onChange="activateQuantity(this);" id="<?php echo $row->id; ?>"/></td>
			<td><?php echo initialCap($row->departmentid); ?></td>
			<td><a href="../estimationdetails/estimationdetails.php?estimationid=<?php echo $row->id; ?>"><?php echo $row->itemid; ?></td>
			<td><?php echo $row->prc; ?></td>
			<td><input type="text" readonly name="qnt<?php echo $row->id; ?>" id="qnt<?php echo $row->id; ?>" onChange="setQuantity(this,'<?php echo $row->id; ?>');"/></td>
<?php
//Authorization.
$auth->roleid="11370";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addestimations_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11371";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='estimations.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>

<table class="table" width="50%">
  <tr>
    <!-- <td>Select Store</td> -->
    <td>
    <label for="brancheid">Select Store</label>
      <select id="brancheid" name="brancheid" required>
        <option selected disabled>select store...</option>
        <?php
        $query = "SELECT id, name FROM sys_branches";
        $res = mysql_query($query);
        while ($row = mysql_fetch_object($res)) {
          echo '<option value="' . $row->id . '">' . $row->name . '</option>';
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>Date:</td>
    <td><input type="text" class="date_input" readonly name="processedon" id="processedon" value="<?php echo $obj->processedon; ?>"/></td>
    <td><input type="submit" class="btn btn-primary" name="action" value="Process"/></td>
    <td><input type="submit" class="btn btn-success" name="action" value="Request from Store"/></td>
  </tr>
</table>

</form>
<?php
include"../../../foot.php";
?>
