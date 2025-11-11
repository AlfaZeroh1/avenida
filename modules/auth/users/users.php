<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Users_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Users";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="12";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$resetid = $_GET['resetid'];
$status=$_GET['status'];

$ob = (object)$_GET;
$obj = (object)$_POST;

if(empty($obj->status))
    $obj->status="Active";

if(!empty($resetid)){
  $users = new Users();
  $fields="*";
  $join="  ";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='$resetid' ";
  $users->retrieve($fields,$join,$where,$having,$groupby,$orderby);$users->sql;
  $users = $users->fetchObject;
  
  if(empty($ob->pin))
    $users->password=md5('a');
  
  $user = new Users();
  if(!empty($ob->pin))
    $users->pinno = $user->generatePinNo();
  $user->edit($users);
  redirect("users.php");
}

$users=new Users();
if(!empty($delid)){
	$users = new Users();
	$fields="*";
	$join="  ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$delid' ";
	$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$users = $users->fetchObject;
	$users->status=$status;
	
	$user = new Users();
	$user->edit($users);
	redirect("users.php");
}
?>

<form action="users.php" method="post">
    <table class="table">
        <tr>
            <td>
                <?php //Authorization.
                $auth->roleid="11";//View
                $auth->levelid=$_SESSION['level'];

                if(existsRule($auth)){
                ?>
                <div style="float:left;"> <input class="btn btn-info" onclick="showPopWin('addusers_proc.php',600,430);" value="Add Users " type="button"/></div>
                <?php }?></td>
            <td>Status:</td>
            <td>
                <select name="status">
                    <option value="Active" <?php if($obj->status=='Active')echo "selected"; ?>>Active</option>
                    <option value="Inactive" <?php if($obj->status=='Inactive')echo "selected"; ?>>Inactive</option>
                </select>
            </td>
            <td><input type="submit" name="action" value="Filter" class="btn btn-info"/></td>
        </tr>
    </table>
</form>

<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Username </th>
			<th>PIN </th>
			<th>Level </th>
			<th>Status </th>
			<th>Last Login </th>
			<th>Last Reset On</th>
<?php
//Authorization.
$auth->roleid="13";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="14";//View
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
		$fields="auth_users.id, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) as employeeid, auth_users.username, auth_users.password, auth_levels.name as levelid, auth_users.status, auth_users.lastlogin, auth_users.createdby, auth_users.lastreseton, auth_users.createdon, auth_users.lasteditedby, auth_users.lasteditedon, auth_users.pinno";
		$join=" left join hrm_employees on auth_users.employeeid=hrm_employees.id  left join auth_levels on auth_users.levelid=auth_levels.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		if(!empty($obj->status))
            $where=" where auth_users.status='$obj->status' ";
		$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $users->sql;
		$res=$users->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		if(empty($row->pinno))
            $row->pinno="XXX";
		
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php if($row->username=='admin'){?><?php echo $row->username; ?><?php }else {?><a href='users.php?resetid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to Reset?')"><?php echo $row->username; ?></a><?php } ?></td>
			<td><?php if($row->levelid==1){?><?php echo $row->pinno; ?><?php }else {?><a href='users.php?resetid=<?php echo $row->id; ?>&pin=1' onclick="return confirm('Are you sure you want to Reset?')"><?php echo $row->pinno; ?></a><?php } ?></td>
			<td><?php echo $row->levelid; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->lastlogin; ?></td>
			<td><?php echo $row->lastreseton; ?></td>
<?php
//Authorization.
$auth->roleid="13";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addusers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="14";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='users.php?delid=<?php echo $row->id; ?>&status=<?php if($row->status=='Active'){echo"Inactive";}else{echo"Active";}?>' onclick="return confirm('Are you sure you want to delete?')"><?php if($row->status=='Active'){echo"De-Activate";}else{echo"Activate";}?></a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
