<?php
session_start();
require_once("lib.php");
require_once 'DB.php';

$db = new DB();

if(empty($_SESSION['userid'])){
	redirect("modules/auth/users/login.php");
}

$month=date("m");
$year=date("Y");

// $query="select sum(amount) amount from em_payables where paymenttermid=1 and month='$month' and year='$year'";
// $res=mysql_query($query);
// $row=mysql_fetch_object($res);
// $totalinvoiced = $row->amount;
// 
// $query="select sum(amount) amount from em_tenantpayments where paymenttermid=1 and month='$month' and year='$year'";
// $res=mysql_query($query);
// $row=mysql_fetch_object($res);
// $totalpaid = $row->amount;
// $difference=$totalinvoiced-$totalpaid;
// 
// $pie = array("label","$totalinvoiced");
// array_push($pie, "data","");
// 
// $arrays = array();
// $i = 10;
// $lykeys="";
// $llabels="";
// while($i>0){
//   $now=date("Y-m-d",mktime(0,0,0,date("m")-$i,date("d"),date("Y")));
//   $monthago=date("Y-m-d",mktime(0,0,0,date("m")-($i-1),date("d"),date("Y")));
//   
//   //get incomes totals by month
//   $query="select fn_inctransactions.month, fn_inctransactions.year, sum(fn_inctransactions.amount) amount, fn_incomes.name incomeid from fn_inctransactions left join fn_incomes on fn_incomes.id=fn_inctransactions.incomeid where fn_inctransactions.incomedate between '$now' and '$monthago' group by incomeid ";
//   $res = mysql_query($query);
//   $array = array('period'=>$i);
//   while($row = mysql_fetch_object($res)){
//     $array[$row->incomeid]=$row->amount;
//     $lykeys.="'$row->incomeid', ";
//     $llabels.="'$row->incomeid', ";
//   }
// 
//   $arrays[] = $array;
//   $i--;
// }
// 
$lxkey = "'period'";
$lykeys = substr($lykeys,0,-2);
$llabels = substr($llabels,0,-2);

$bar = array();
$tenmonthsago=date("Y-m-d",mktime(0,0,0,date("m")-5,date("d"),date("Y")));

$sql="select * from sys_dashboards where id in(select dashboardid from auth_leveldashboards where levelid='".$_SESSION['levelid']."') and  type='Bar Graph'";
$rs=mysql_query($sql);
$rw=mysql_fetch_object($rs);

$bartitle=$rw->name;
	    
$query=$rw->query;
$query=str_replace('SESSIONBRANCH',$_SESSION['brancheid'],$query);

$res=mysql_query($query);
$i=0;
while($row=mysql_fetch_object($res)){
  $bar[$i]['y']=getMonth($row->month)." ".$row->year;
  $bar[$i]['a']=$row->amount;
  
  $i++;
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
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

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
                <a class="navbar-brand" href="index.php">WiseDigits ERP</a>
            </div>
            <!-- /.navbar-header -->

            <!-- Top Menu Items -->
             <ul class="nav navbar-top-links navbar-right">
                <?php
              $query = "select pm_notifications.subject, pm_notifications.taskid, pm_notifications.id notificationid, pm_notificationrecipients.id, pm_notificationrecipients.status, pm_notificationrecipients.notifiedon, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeeid from pm_notificationrecipients left join pm_notifications on pm_notifications.id=pm_notificationrecipients.notificationid left join hrm_employees on hrm_employees.id=pm_notificationrecipients.fromemployeeid where status in('unread','notified') and employeeid in(select employeeid from auth_users where id='".$_SESSION['userid']."') order by pm_notificationrecipients.createdon desc";
	      $res=mysql_query($query);
	      
	      $num = mysql_affected_rows();
              ?>
              
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <span class="badge"><div id="notnum"><?php echo $num; ?></div></span> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                    
                    <?php
                    while($row=mysql_fetch_object($res)){
                    ?>
                        <li class="message-preview">
                            <a href="modules/pm/tasks/addtasks_proc.php?id=<?php echo $row->taskid; ?>&not=true">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $row->employeeid; ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> <?php echo $row->notifiedon; ?></p>
                                        <p><?php echo $row->subject; ?></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                        
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <?php
                $query="select * from pm_tasks where pm_tasks.employeeid in(select employeeid from auth_users where id='".$_SESSION['userid']."') and (pm_tasks.statusid<=3 or statusid=5) and 1!=1 order by createdon desc ";
		$tasks->result=mysql_query($query);
		$where="";
                ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> <span class="badge"><div id="notnum"><?php echo $tasks->affectedRows; ?></div></span> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        
                        <?php
			
			while($row=mysql_fetch_object($tasks->result)){
			
			if($row->statusid==1)
			  $class="label label-default";
			elseif($row->statusid==2)
			  $class="label label-info";
			elseif($row->statusid==3)
			  $class="label label-primary";
			elseif($row->statusid==4 || $row->statusid==5)
			  $class="label label-warning";
			elseif($row->statusid==6)
			  $class="label label-success";
			elseif($row->statusid==7)
			  $class="label label-danger";
			?>
                        
                        <li>
                        <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="" alt="">
                                    </span>
                                    <div class="media-body">
                            <a href="modules/pm/tasks/addtasks_proc.php?id=<?php echo $row->id; ?>&not=true"><span class="<?php echo $class; ?>"><?php echo $row->name; ?></span></a>
                            
                            </div>
                            </div>
                        </li>
                        
                        <?php
                        }
                        ?>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo initialCap($_SESSION['employeename']); ?><i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="javascript:;" onclick="showPopWin('modules/auth/users/addusers_proc.php?id=<?php echo $_SESSION['userid']; ?>',600,430);"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="modules/hrm/employeeleaveapplications/addemployeeleaveapplications_proc.php">Leave Apply</a></li>
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
                                    <a href="modules/<?php echo $row1->url; ?>"><i class="fa fa-tasks fa-fw"></i><?php echo $row1->description; ?></a>
                                </li>
                                <?php 
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
                                    <a href="<?php echo $row1->url; ?>"><i class="fa fa-tasks fa-fw"></i><?php echo $row1->description; ?></a>
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
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" style="font-weight:bold;"><a href="index.php"><?php echo $_SESSION['companyname']; ?></a></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            <?php
            //get statiscts
	    $sql="select * from sys_dashboards where id in(select dashboardid from auth_leveldashboards where levelid='".$_SESSION['levelid']."') and  type='panel'";
	    $rs=mysql_query($sql);
	    while($rw=mysql_fetch_object($rs)){
            ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel <?php echo $rw->cssclass; ?>">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa "></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php			    
				    $query=$rw->query;	
				    $query=str_replace('SESSIONBRANCH',$_SESSION['brancheid'],$query);
				    $res=mysql_query($query);
				    $row=mysql_fetch_object($res);
				 ?>
                                    <div class="huge"><?php echo formatNumberD($row->amount,0); ?></div>
                                    <div> <?php echo $rw->name; ?>!</div>
                                </div>
                            </div>
                        </div>
                       
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                       
                    </div>
                </div>
            <?php
            }
            ?>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $bartitle; ?>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Sold</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
					    $i=0;
					    $total=0;
					    while($i<count($bar)){
					    $total+=$bar[$i]['a'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $bar[$i]['y']; ?></td>
                                                    <td align="right"><?php echo formatNumber($bar[$i]['a']); ?></td>
                                                </tr>
                                             <?php
                                             $i++;
                                             }
                                             ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Total</th>
                                                    <th style="text-align:right;"><?php echo formatNumber($total);?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-8">
                                    <div id="morris-bar-chart"></div>
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        
                        <?php 
                        $query="select * from auth_leveldashboards where dashboardid=8 and levelid='".$_SESSION['levelid']."'";
                        mysql_query($query);
                        if(mysql_affected_rows()>0){ 
                        
                        ?>
                         <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>LOCATION</th>
                                                    <?php 
                                                    $yearstart=date("Y-m-d",mktime(0,0,0,1,1,date("Y")));
                                                    $i=0;
                                                    while($i<date("m")){
						      $i++;
						      ?>
						      <th style="text-align:right;"><?php echo getMonth($i);?></th>
						      <?php
						      
						      
                                                    }
                                                    ?>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $query="select * from sys_branches where type='Center'  ";
                                            $query.=" order by name";
					    $res = mysql_query($query);
					    $ttotals=array();
					    while($row=mysql_fetch_object($res)){
					    ?>
					      <tr>
						<td><?php echo initialCap($row->name); ?></td>
						<?php 
                                                    
                                                    $i=0;
                                                    $total=0;
                                                    
                                                    while($i<date("m")){
						      $i++;
						      $monthstart=date("Y-m-1",mktime(0,0,0,$i,date("d"),date("Y")));
						      $monthend=date("Y-m-t",mktime(0,0,0,$i,date("d"),date("Y")));
						      $quer="select sum(pd.quantity*pd.price) amount from pos_orders p left join pos_orderdetails pd on p.id=pd.orderid where brancheid2='$row->id' and orderedon between '$monthstart' and '$monthend'";
						      $rw->amount=0;
						      $rw=mysql_fetch_object(mysql_query($quer));
						      $total+=$rw->amount;
						      
						      $ttotals[($i-1)]+=$rw->amount;
						      ?>
						      <td align="right"><?php echo formatNumbertoZero($rw->amount);?></td>
						      <?php
						      
						      
                                                    }
                                                    $ttotals['total']+=$rw->amount;
                                                    ?>
                                                    <td align="right"><?php echo formatNumbertoZero($total);?></td>
					      </tr>
					    <?
					    }
                                            ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Total</th>
                                                    <?php 
                                                    
                                                    $i=0;
                                                    $total=0;
                                                    while($i<date("m")){
						      
						      
						      ?>
						      <th style="text-align:right;"><?php echo formatNumbertoZero($ttotals[$i]);?></th>
						      <?php
						      
						      $i++;
                                                    }
                                                    ?>
                                                    <th style="text-align:right;"><?php echo formatNumbertoZero($ttotals['total']);?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <?php } ?>
                        
                        <!-- /.panel-body -->
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Incomes (Past 1 Year)
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                   
                   <!-- /.panel -->
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
		    <div class="panel panel-default">
                        <div class="panel-heading">
<!--                             Invoiced vs Paid (<?php echo getMonth($month); ?> <?php echo $year; ?>) -->
                        </div>
                        <div class="panel-body">
                             <div class="flot-chart">
<!--                                 <div class="flot-chart-content" id="flot-pie-chart"></div> -->
                            </div>
<!--                             <a href="#" class="btn btn-default btn-block">View Details</a> -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Summaries
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php
                            $sql="select * from sys_dashboards where id in(select dashboardid from auth_leveldashboards where levelid='".$_SESSION['levelid']."') and  type='Tabular'";
			    $rs=mysql_query($sql);
			    while($rw=mysql_fetch_object($rs)){
                            ?>
                            <div class="list-group"><?php echo initialCap($rw->name); ?>
                            <?php                                                       
			       $querys=$rw->query; 	
			       $query=str_replace('SESSIONBRANCH',$_SESSION['brancheid'],$query);
                               $ress=mysql_query($querys);
                               while($rows=mysql_fetch_object($ress)){
                               ?>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-list fa-fw"></i> <?php echo $rows->name; ?>
                                    <span class="pull-right text-muted small"><em><?php echo formatNumber($rows->amount); ?></em>
                                    </span>
                                </a>
                               <?php                               
                               }
                               ?>
                            </div>
                            <?php
                            }
                            ?>
                            <!-- /.list-group -->
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <!-- /.panel -->
                    
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
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
    Morris.Area({
        element: 'morris-area-chart',
        data: <?php echo json_encode($arrays);?>,
        xkey: <?php echo $lxkey; ?>,
        ykeys: [<?php echo $lykeys; ?>],
        labels: [<?php echo $llabels; ?>],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });
    
    Morris.Bar({
        element: 'morris-bar-chart',
        data: <?php echo json_encode($bar);?>,
        xkey: 'y',
        ymin: 0,
        ykeys: ['a'],
        labels: ['Sold'],
        hideHover: 'auto',
        xLabelAngle: 30,
        resize: true
    });
    
     var data = [{
        label: "Sold",
        data: 9
    }, {
        label: "Paid",
        data: 20
    }, {
        label: "Balance",
        data: 30
    }];

    var plotObj = $.plot($("#flot-pie-chart"), data, {
        series: {
            pie: {
                show: true
            }
        },
        grid: {
            hoverable: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
                x: 20,
                y: 0
            },
            defaultTheme: false
        }
    });
    </script>

</body>

</html>
