<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../auth/roles/Roles_class.php");

//require_once '../plots/Plots_class.php';

//connect to db
$db=new DB();

$id = $_GET['id'];
$roleid=$_GET['roleid'];


$roles=new Roles();
$where=" where moduleid='".$id."'";
$fields="*";
$join="";
$having=" having substring(trim(name),1,3)='add'";
$groupby="";
$orderby=" order by name ";
$roles->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $roles->sql;
?>
<option value="">Select...</option>
<?
while($rw=mysql_fetch_object($roles->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($roleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->description); ?></option>
	<?php
	}
	
?>