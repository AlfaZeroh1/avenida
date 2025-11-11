<?
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Users_class.php");
require_once '../../sys/config/Config_class.php';
require_once '../../hrm/employees/Employees_class.php';

$db=new DB();
$users=new Users();

$url=$_GET['url'];
if(!empty($url))
{
	$url=$url;
}

$obj=(object)$_POST;

$config = new Config();
$fields=" * ";
$join="  ";
$where="  ";
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


if($obj->action=="Login")
{
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
		$fields=" auth_users.*, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename ";
		$join=" left join hrm_employees on hrm_employees.id=auth_users.employeeid ";
		$where=" where username='$username' and password='$password' ";
		$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$user=$users->fetchObject;
		
		if($users->affectedRows==1)
		{
		        $date=date("Y-m-d");
		        $month=date("n",strtotime($date));
		        $day=date("d",strtotime($date));
		        $year=date("Y",strtotime($date));
		
		        $dat=date("Y-m-d",mktime(0,0,0,($month-3),$day,$year));//echo $dat;
		        
		        $_SESSION['level']=$user->levelid;
		        
			if($user->status=="Active" and $user->lastreseton>$dat)
			{
			     //check if user belongs to company
			     $query="select ub.companyid, b.name from auth_usercompanys ub left join sys_companys b on ub.companyid=b.id where ub.userid='$user->id' and ub.companyid='$obj->companyid'";//echo $query;
			     $sr = mysql_query($query);
			     if(mysql_affected_rows()==0){
			      $error="User has no access to selected company!";
			     }
			     else{   
				
				$ub = mysql_fetch_object($sr);
				
				$config = new Config();
				$fields=" * ";
				$join="  ";
				$where=" where companyid='".$_SESSION['companyid']."' ";
				$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);

				while($con=mysql_fetch_object($config->result)){
					$_SESSION[$con->name]=$con->value;
				}

				$user->lastlogin=date("Y-m-d H:i:s");
				
				//$users->edit($user);
				$_SESSION['username']=$user->username;
				$_SESSION['password']=$user->password;
				$_SESSION['level']=$user->levelid;
				$_SESSION['levelid']=$user->levelid;//echo $_SESSION['level'];
				$_SESSION['userid']=$user->id;
				$_SESSION['employeeid']=$user->employeeid;
				$_SESSION['employeename']=$user->employeename;
				$_SESSION['companyid']=$obj->companyid;
				$_SESSION['company']=$ub->name;
				
				$config = new Config();
                $fields=" * ";
                $join="  ";
                $where=" where companyid='$obj->companyid' ";
                $config->retrieve($fields, $join, $where, $having, $groupby, $orderby);

                while($con=mysql_fetch_object($config->result)){
                    $_SESSION[$con->name]=$con->value;
                }
// 				$_SESSION['companyname']=$ub->name;
				
				$us = new Users();
				$ob=$user;
				$us->edit($ob);
				
				if(!empty($url))
				{
					if (strlen(strstr($url,"sales.php"))>0) {
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
			 <?php       
			 redirect("../../../modules/auth/users/addusers_proc.php?id=$user->id&userid=$user->id&reset=1");
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
}
include "login.html";


?>
