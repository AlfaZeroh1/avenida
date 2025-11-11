<?php
session_start();
require_once("lib.php");
require_once 'DB.php';

$db = new DB();

if(empty($_SESSION['userid'])){
	redirect("modules/auth/users/login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WiseDigits ERP</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/elements.css" rel="stylesheet">
<!--     <link href="css/main.css" rel="stylesheet"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/raphael.min.js"></script>
    <script src="js/morris.js"></script>
        
    <script src="js/excanvas.min.js"></script>
    <script src="js/jquery.flot.js"></script>
    <script src="js/jquery.flot.pie.js"></script>
    <script src="js/jquery.flot.resize.js"></script>
    <script src="js/jquery.flot.time.js"></script>
    <script src="js/jquery.flot.tooltip.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

<script type="text/javascript">
     
    var newwindow;
    function poptastic(url)
    {
	    newwindow=window.open(url,'name');
	    if (window.focus) {newwindow.focus()}
    }
    
    <?php if(empty($obj->procedure) and empty($pop)){?>
    function getNotifications(){
	var feedback = $.ajax({
	    type: "POST",
	    url: "../../../modules/pm/notificationrecipients/notify.php",
	    async: false
	}).complete(function(){
	    setTimeout(function(){getNotifications();}, 1000);
	}).responseText;
		
	$('#notnum').html(feedback);
    }
    
    function showNotifications(){
	var feedback = $.ajax({
	    type: "POST",
	    url: "../../../modules/pm/notificationrecipients/notifys.php",
	    async: false
	}).complete(function(){
	    setTimeout(function(){showNotifications();}, 1000);
	}).responseText;
	
	if(feedback!=''){
	PNotify.desktop.permission();
	new PNotify({
                title: 'Notification',
                text: feedback,
                type: 'error',
                desktop: {
		    desktop: true
		}
            });
        }    
    }
    
    
//     getNotifications();
//     showNotifications();
    <?php } ?>
    </script>
    
    <style type="text/css">
    $(".form-control").removeAttr("width");
    $(".form-control").removeAttr("background-color");
    .side-nav{
      background-color:;
    }
    
    .inputwidth{
      max-width:300px;
    }
    
    .navbar-inverse .navbar-brand, .navbar-brand:hover, .navbar-brand:focus {
	color: #337ab7;
    }
    .top-nav > li > a{
      color: #337ab7;
    }
    .grid > td {
	border-collapse: separate;
	border-spacing: 10px 50px;
    }
    .side-nav>li>a {
        width: 225px;
	color:#093b5a;
    }
    ul
{
    list-style-type: none;
}
    .content {
	  background-color: #fff;
	  border: 1px solid rgb(245, 148, 14);
	  border-radius: 6px;
	  box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
	  position: relative;
      }
      
      table.dataTable {
	  border-collapse: separate !important;
	  clear: both;
/* 	  margin-bottom: 6px !important; */
/* 	  margin-top: 6px !important; */
	  max-width: none !important;
      }
      
      input[type="text"], input[type="email"], input[type="tel"], input[type="search"], input[type="url"], input[type="password"], .ui-autocomplete-input, textarea, .uneditable-input {
	  border: 1px solid #ccc;
	  border-radius: 3px;
	  color: #555555;
	  display: inline-block;
	  font-size: 13px;
	  line-height: 18px;
/* 	  padding: 4px; */
      }
      .label{
	color:black;
	font-size: 12px;
      }
      ul.modules{
	padding:0px;
	list-style:none;
	display:block;
	margin:0px 5px 5px;
	float:left;
	width:72%;
}
ul.modules li{
display:inline;
font-size:14px;
}
ul.modules li a
{
	/*font-weight:bold;*/
	display:block;
/* 	background:url(../fsimage/module-button.png) repeat; */
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	background:;
	border:1px solid #f5940e;
	font-size:14px;
	width:28%;
	text-decoration:none;
	outline:none;
	float:left;
	text-align:left;
	padding:10px 10px 14px 0px;
	margin:5px;
	color:#093b5a;
	
}

a.button {
border: 1px solid #979797;
}
a.button.icon {
padding-left: 11px;
}

a.button.icon span{
padding-left: 24px;
background: url(../images/plus.png) no-repeat 0 0px;
}

a.button.icon.chat span {
background-position: 0px 0px;
}
a.button.icon.users span{
padding:20px;
font-size:18px;
padding-left: 40px;
/*background: url(../images/users.png) no-repeat 0 0px;*/
}
a.button.icon.search span{
padding-left: 24px;
background: url(../images/search.png) no-repeat 0 0px;

}

a.button.icon.em span{
		padding-left: 60px;
	background: url(../images/em.png) no-repeat 0 4px;
height:100px;
font-size:16px;
}
a.button.icon.hrm span{
		padding-left: 60px;
	background: url(../images/hrm.png) no-repeat 0 4px;
height:100px;
font-size:16px;
}
a.button.icon.st span{
		padding-left: 60px;
	background: url(../images/st.png) no-repeat 0 4px;
height:100px;
font-size:16px;
}
a.button.icon.fn span{
		padding-left: 60px;
	background: url(../images/fn.png) no-repeat 0 4px;
height:100px;
font-size:16px;
}
a.button.icon.p span{
		padding-left: 60px;
	background: url(../images/p.png) no-repeat 0 4px;
height:100px;
font-size:16px;
}

a.button.icon.a span{
		padding-left: 60px;
	background: url(../images/a.png) no-repeat 0 4px;
height:100px;
font-size:16px;
}
a.button.icon.wf span{
		padding-left: 60px;
	background: url(../images/a.png) no-repeat 0 4px;
height:100px;
font-size:14px;
}
a.button.icon.r span{
		padding-left: 60px;
	background: url(../images/r.png) no-repeat 0 4px;
height:100px;
font-size:16px;
}
a.button.icon.q span{
		padding-left: 60px;
	background: url(../images/q.png) no-repeat 0 2px;
height:100px;
font-size:16px;
}
    </style>
        
    <title>WiseDigits ERP</title>
</head>

<body>
<?php if(empty($obj->procedure) and empty($pop)){?>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">WISEDIGITS ERP</a>
            </div>
            <!-- Top Menu Items -->
                        <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                    
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        
                        <li class="divider"></li>
                        
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="modules/auth/users/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            
             <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a href="index.php"><img width="210" src="images/<?php echo $_SESSION['logo']; ?>"></a>
                        </li>
                        
                        <?php 
			$query="select * from sys_modules where status=1 and id not in(32) order by position";
			$res=mysql_query($query);
			while($row=mysql_fetch_object($res)){
			if(moduleAuth($row->id,$_SESSION['level'])){
			?>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> <?php echo strtoupper($row->description); ?><span class="fa arrow"></span></a>
                            
                            <ul class="nav nav-second-level">
                            <?php 
				$query1="select * from sys_submodules where moduleid='$row->id' and status=1 and type='main' order by priority";
				$res1=mysql_query($query1);
				while($row1=mysql_fetch_object($res1)){ 
				$temp = explode("/", $row1->url);
				if(modularAuth($row->id,$_SESSION['level'],$temp[0],$temp[1])){
				?>
                                <li>
                                    <a href="../../../modules/<?php echo $row1->url; ?>"><i class="fa fa-tasks fa-fw"></i><?php echo $row1->description; ?></a>
                                </li>
                                <?php 
                                }
                                }
                                }
                                $query1="select * from sys_submodules where moduleid='$row->id' and status=1 and type='setup' order by priority";
				$res1=mysql_query($query1);
				if(mysql_affected_rows()>0){
				
				
                                ?>
                                <li>
                                    <a href="#">SET UP <span class="fa arrow"></span></a>
                                    <?
				  while($row1=mysql_fetch_object($res1)){
				  $temp = explode("/", $row1->url);
				  if(modularAuth($row->id,$_SESSION['level'],$temp[0],$temp[1])){
				  ?>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <?php
                                    }
                                    }
                                    ?>
                                    <!-- /.nav-third-level -->
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <?php 
                        
                        }
                        ?>
                        
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> REPORTS<span class="fa arrow"></span></a>
                                                
                        <ul class="nav nav-second-level">
                        <?php 
                    $query="select * from sys_modules where status=1 and id not in(32,3) order by position";
                    $res=mysql_query($query);
                    while($row=mysql_fetch_object($res)){
                    if(reportAuth($row->id,$_SESSION['level'])){
                    ?>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> <?php echo strtoupper($row->description); ?><span class="fa arrow"></span></a>
                            
                            <ul class="nav nav-third-level">
                            <?php 
			      $query1="select * from sys_submodules where moduleid='$row->id' and status=1 and type='reports' order by priority";
			      $res1=mysql_query($query1);
			      while($row1=mysql_fetch_object($res1)){ 
			      $temp = explode("/", $row1->url);
			      if(reportAuth($row->id,$_SESSION['level'],$temp[1],$temp[2])){
      // 				mysql_query("update sys_submodules set status=2 where id='$row1->id'");
			      ?>
                                <li>
                                    <a href="../../../<?php echo $row1->url; ?>"><i class="fa fa-tasks fa-fw"></i><?php echo $row1->description; ?></a>
                                </li>
                                <?php 
                                }
                                }
                                ?>
                            </ul>
                         </li>
                         <?php
                         }
                         }
                         ?>
                        </ul>
		      </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-collapse -->
        </nav>

       
   <?php } ?>         
                     <div id="page-wrapper">
            
		      <div id="container-fluid">
		      <div id="row-fluid">
		      <div id="span9">      


<ul class="modules">
<li><a class="button icon fn" href="modules/pos/orders/"><span>Sales</span></a></li>
<li><a class="button icon fn" href="modules/inv/items/"><span>Inventory</span></a></li>
<li><a class="button icon fn" href="modules/proc/suppliers/"><span>Procurement</span></a></li>
<li><a class="button icon hrm" href="modules/hrm/employees/"><span>HRM</span></a></li>
<li><a class="button icon hrm" href="modules/hrm/employeepayments/"><span>Payroll</span></a></li>
<li><a class="button icon fn" href="modules/fn/generaljournals/"><span>Finance</span></a></li>
<li><a class="button icon a" href="modules/auth/users/"><span>Administration</span></a></li>
<li><a class="button icon a" href="modules/wf/routes/"><span>Work Flow</span></a></li>>
<li><a class="button icon r" href="reports/"><span><u>R</u>eports</span></a></li>
<li><a class="button icon st" href="modules/sys/config/"><span>System Tools</span></a></li>
<li><a class="button icon q" href="#"><span>Help</span></a></li>
 
</ul>

  <div id="cur-user">
  
  
  <?php
 
  
  if(!empty($_SESSION['image'])){
    $image=$_SESSION['image'];
  }else//{
  //  $image="fsimage/default-user.jpg";
  //  $image=resize(200,600);
//  }
  ?>
  <a href="modules/hrm/employees/photo.php"><img src="modules/dms/documents/thumb.php?src=<? echo $image;?>&y=200&f=0"/></a>
  

    <div class="info">
<span class="cur">Currently Logged in as:</span>
<span class="name"><?php echo $_SESSION['username']; ?> 
<?
			$sql="select * from auth_levels where id='".$_SESSION['level']."'";
			$res = mysql_query($sql);
			$row=mysql_fetch_object($res);
			$level = $row->name;
			
        if(!empty($_SESSION['userid']))
		{
        	?>
            &nbsp;[<?php echo $level; ?>]&nbsp;</span>
           	 <div class="links">
             <a href="modules/auth/users/logout.php">Log Out</a></div>
             [<?php echo $_SESSION['branchename'];?>]
             
             <div class="links">
             <a href="modules/hrm/employeeleaveapplications/addemployeeleaveapplications_proc.php">Leave Apply</a></div>
              <div class="links">
             <a href="modules/hrm/employeeadvanceapplications/addemployeeadvanceapplications_proc.php">Advance Apply</a></div>
             <div class="links">
        <a href="modules/hrm/employees/addemployees_proc.php?id=<?php echo $_SESSION['employeeid']; ?>&employee=1">Profile</a>
        </div>
		<div class="links">
	 <?php
        if(($_SESSION['level']=="1"))
        {
        ?>
<li><a  id="bt-hide" href="modules/hrm/employeepayments/test.php"><span style="text-align:center;color: #f00;">Send Payslip Via Email</span></a>
<?php } ?>
</div>
             <?php 
             $today=date("Y-m-d");
             $query=" select hrm_employeeclockings.* from hrm_employeeclockings  left join auth_users on  auth_users.employeeid=hrm_employeeclockings.employeeid where auth_users.id='".$_SESSION['userid']."' and today='$today' and endtime='00:00:00'";
            	$res=mysql_query($query);
            	if(mysql_affected_rows()>0){
             ?>
             <a href="modules/hrm/employeeclockings/addemployeeclockings_proc.php?clock=clockout"><font color="red">Clock Out</font></a></div>
             <?            
             }
             else{
				?>
             <a href="modules/hrm/employeeclockings/addemployeeclockings_proc.php?clock=clockin">Clock In</a></div>
             <?   
			}
			$query="select inv_issuance.* from inv_issuance left join auth_users on inv_issuance.employeeid=auth_users.employeeid where auth_users.id='".$_SESSION['userid']."'";
			$res=mysql_query($query);
			if(mysql_affected_rows()>0){
				?>
			             <a href="modules/inv/issuance/issuance.php?issued=1">Items Issued</a></div>
					 <a href="modules/sys/issues/issues.php?issued=1">Issues</a></div>	
			             <?            
			             }
        }
        ?></span></div>
        
  </div>
  
  <div>
<!--  <div class="col-lg-3">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-check fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                  <?php
                  $query="select count(*) cnt from pm_tasks where employeeid = (select employeeid from auth_users where id='".$_SESSION['userid']."') and statusid<=3";
		  $row=mysql_fetch_object(mysql_query($query));
                  ?>
                    <p class="announcement-heading"><?php echo $row->cnt; ?></p>
                    <p class="announcement-text"><a href="modules/pm/tasks/tasks.php?status=1,2,3">Pending Tasks</a></p>
                  </div>
                </div>
                
              </div>
              <a href="modules/pm/tasks/tasks.php?status=8">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Complete Tasks
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            
          </div>
          
          <div class="col-lg-3">
<?php
$auth->roleid=8761;
$auth->levelid=$_SESSION['level'];
$query="select * from auth_rules where levelid='$auth->levelid' and roleid='$auth->roleid'";
$rs = mysql_query($query);
if(mysql_affected_rows()>0){
?>
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-check fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                  <?php
                  $query="select count(*) cnt from hrm_employees where statusid=1";
		  $row=mysql_fetch_object(mysql_query($query));
                  ?>
                    <p class="announcement-heading"><?php echo $row->cnt; ?></p>
                    <p class="announcement-text"><a href="modules/hrm/employees/employees.php">No of Staff</a></p>
                  </div>
                </div>
                
              </div>
              <a href="modules/pm/tasks/tasks.php?status=8">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View All
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <?php } ?> 
          </div>
    
          <div class="col-lg-3">
           <?php
$auth->roleid=8761;
$auth->levelid=$_SESSION['level'];
$query="select * from auth_rules where levelid='$auth->levelid' and roleid='$auth->roleid'";
$rs = mysql_query($query);
if(mysql_affected_rows()>0){
?>
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-check fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                  <?php
                  $query="select count(*) cnt from hrm_assignments where id not in(select assignmentid from hrm_employees)";
		  $row=mysql_fetch_object(mysql_query($query));
                  ?>
                    <p class="announcement-heading"><?php echo $row->cnt; ?></p>
                    <p class="announcement-text"><a href="modules/pm/tasks/tasks.php?status=1,2,3">Available Jobs</a></p>
                  </div>
                </div>
                
              </div>
              <a href="modules/pm/tasks/tasks.php?status=8">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View All
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <?php } ?>
          </div>



<div style="margin-left:15%;">
          <?php
$auth->roleid=8761;
$auth->levelid=$_SESSION['level'];
$query="select * from auth_rules where levelid='$auth->levelid' and roleid='$auth->roleid'";
$rs = mysql_query($query);
if(mysql_affected_rows()>0){
?>
          <div class="col-lg-7">
  <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Staff On Leave</h3>
              </div>
              <div class="panel-body">
    <div class="list-group">          
              
                                
              </div>
              
              </div>

  </div>
</div>  
<?php } ?>
          </div>
  </div>-->
  <div class="clearb"></div>
  </div><form name="ind">
  </form>
<div class="clearb"></div>
</div>
</div>
</div>
</div>
<div id="footer">
<div id="footer-inner">
<div id="footer-message">
<p align="center">Licenced to: <strong><?php echo $_SESSION['companyname'];?></strong>
<p align="center">Copyright &copy; <?php echo date("Y"); ?> WiseDigits. All Rights Reserved.</p>
</div>
</div>
<div class="clearb"></div>
</div>
<div class="clearb"></div>
</div>
</div>
</div>
</body>
</html>


