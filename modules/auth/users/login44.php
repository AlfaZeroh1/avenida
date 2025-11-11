<?
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Users_class.php");
require_once '../../sys/config/Config_class.php';
require_once '../../hrm/employees/Employees_class.php';
require_once("../../../Mobile_Detect.php");
$detect = new Mobile_Detect;

$db=new DB();
$users=new Users();


if($detect->isMobile()){}

$url=$_GET['url'];
if(!empty($url))
{
	$url=$url;
}

$config = new Config();
$fields=" * ";
$join="  ";
$where="";
$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);

while($con=mysql_fetch_object($config->result)){
	$_SESSION[$con->name]=$con->value;
}

$levelerror=$_GET['levelerror'];
if($levelerror==1)
{
	$levelerror="You do not have the right priviledges to view this page. Login with an Account with higher priviledges.";
	$home="<a href='../'>Go To Home</a>";
}

$obj=(object)$_POST;
if($obj->action=="Login")
{
      if($obj->num<=0 and !$detect->isMobile()){
	$username=trim($obj->username);
	$password=trim($obj->password);
	
	//change to lower case
	$username=strtolower($username);
	//$password=strtolower($password);
	if(empty($username))
	{
	$error="username is required";
	}
	elseif(empty($password))
	{
	$error="password is required";
	}
	else
	{	
		$password=md5($password);
		$fields=" auth_users.*, hrm_employees.image, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename, auth_levels.shift ";
		$join=" left join hrm_employees on hrm_employees.id=auth_users.employeeid left join auth_levels on auth_levels.id=auth_users.levelid ";
		$where=" where username='$username' and password='$password' and hrm_employees.statusid=1 ";
		$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$user=$users->fetchObject;
		
		if($users->affectedRows==1){
		        
		        $date=date("Y-m-d");
		        $month=date("n",strtotime($date));
		        $day=date("d",strtotime($date));
		        $year=date("Y",strtotime($date));
		
		        $dat=date("Y-m-d",mktime(0,0,0,($month-3),$day,$year));//echo $dat;
		        
		        $_SESSION['level']=$user->levelid;
		        
			if($user->status=="Active" and $user->lastreseton>$dat){
			       
			        $query="select pos_teams.id, sys_branches.id brancheid, sys_branches.name branchename, pos_teamroles.type teamroletype from pos_teams left join pos_teamdetails on pos_teamdetails.teamid=pos_teams.id left join sys_branches on sys_branches.id=pos_teams.brancheid left join pos_teamroles on pos_teamroles.id=pos_teamdetails.teamroleid where (pos_teams.status=0 or pos_teams.status is null or pos_teams.status='') and pos_teamdetails.employeeid='$user->employeeid'";
				$rs = mysql_query($query);
				
				if(mysql_affected_rows()==0 and $user->shift==1){
				
				  $error="No Active Shift!";
				
				}
				else{
				  
				  $r = mysql_fetch_object($rs);
				  $config = new Config();
				  $fields=" * ";
				  $join="  ";
				  $where="";
				  $config->retrieve($fields, $join, $where, $having, $groupby, $orderby);

				  while($con=mysql_fetch_object($config->result)){
					  $_SESSION[$con->name]=$con->value;
				  }

				  $user->lastlogin=date("Y-m-d H:i:s");
				  //$users->edit($user);
				  $_SESSION['username']=$user->username;
				  $_SESSION['password']=$user->password;
				  $_SESSION['level']=$user->levelid;
				  $_SESSION['levelid']=$user->levelid;
				  $_SESSION['userid']=$user->id;
				  $_SESSION['employeeid']=$user->employeeid;
				  $_SESSION['employeename']=strtoupper($user->employeename);
				  $_SESSION['ismobile']=0;
				  $_SESSION['shift']=$user->shift;
				  $_SESSION['tobrancheid']=$r->brancheid;
				  
				  $us = new Users();
				  $ob=$user;
				  $us->edit($ob);
				  
				  if(!empty($url))
				  {
					  if (strlen(strstr($url,"sales.php"))>0){
						  $url="../sales/";
					  }
					  redirect($url);
				  }
				  else
				  {
					  redirect("../../index.php");
				  }
				}
			}
			elseif($user->status=="Active" and $user->lastreseton<=$dat){
			?>
			<script>
			        alert("Your Password has not been reset for the last 3 Months. Please reset to log in!");			        
			</script>
			 <?php       redirect("../../../modules/auth/users/addusers_proc.php?id=$user->id");
			}
			else
			{
				$error="User Account is inactive. Contact Administrator";
			}
		}
		else
		{
		$error="Invalid username and password";
		}
	}
    }else{
      if(empty($obj->pfnum)){
	$error="Enter PIN!";
      }else{
	$query="select auth_users.*, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employee from hrm_employees left join auth_users on hrm_employees.id=auth_users.employeeid where auth_users.pinno='$obj->pfnum'";
	$res=mysql_query($query);echo mysql_affected_rows();
	if(mysql_affected_rows()>0){
	  
	  $user = mysql_fetch_object($res);
	  
	  $_SESSION['level']=$user->levelid;
	  $_SESSION['levelid']=$user->levelid;
	  $_SESSION['userid']=$user->id;
	  $_SESSION['username']=$user->username;
	  $_SESSION['employeeid']=$user->employeeid;
	  $_SESSION['employeename']=$user->employee;
	  $_SESSION['ismobile']=1;
	  
	  $query="select pos_teams.id, sys_branches.id brancheid, sys_branches.name branchename, pos_teamroles.type teamroletype from pos_teams left join pos_teamdetails on pos_teamdetails.teamid=pos_teams.id left join sys_branches on sys_branches.id=pos_teams.brancheid left join pos_teamroles on pos_teamroles.id=pos_teamdetails.teamroleid where (pos_teams.status=0 or pos_teams.status is null or pos_teams.status='') and pos_teamdetails.employeeid='".$_SESSION['employeeid']."'";
	  $rs = mysql_query($query);
	  if(mysql_affected_rows()>0){
	    $rw=mysql_fetch_object($rs);
	    
	    $_SESSION['brancheid']=$obj->brancheid;
	  }
	  
	  redirect("../../pos/orders/addorders_proc.php");
	}else{
	  $error="Invalid PIN!";
	}
      }
    }
}



include "login.html";


?>
