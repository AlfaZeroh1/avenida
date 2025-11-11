<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../hrm/assignments/Assignments_class.php");

//require_once '../plots/Plots_class.php';

//connect to db
$db=new DB();

$id = $_GET['id'];
$assignmentid = $_GET['assignmentid'];


$assignments=new Assignments();
$where=" where departmentid='".$id."'";
if(!empty($assignmentid) and empty($id))
  $where.=" and assignmentid='$assignmentid'";
$fields="*";
$join="";
$having=" ";
$groupby="";
$orderby=" order by name ";
$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
?>
<option value="">Select...</option>
<?
while($rw=mysql_fetch_object($assignments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($assignmentid==$rw->id){echo "selected";}?>><?php echo $rw->name; ?></option>
	<?php
	}
	
?>