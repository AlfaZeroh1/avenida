<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pm/notificationrecipients/Notificationrecipients_class.php");
require_once("../../../modules/pm/tasks/Tasks_class.php"); 
$db = new DB();

if(empty($_SESSION['userid']) and empty($_GET['reset']) and empty($_POST['reset'])){
  redirect("../../../modules/auth/users/login.php");
}

$obj->procedure=$_GET['procedure'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WiseDigits ERP</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../../../css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../../../css/buttons.dataTables.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../../css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../../css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../../css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../../css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../../../css/elements.css" rel="stylesheet">
    <link href="../../../css/pnotify.css" rel="stylesheet">
    <link href="../../../css/jquery-ui-1.10.3.custom.css" rel="stylesheet"/>
    <link href="../../../css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen"/>
    
    <link href="../../../css/keyboard.css" rel="stylesheet">
<!--     <link href="../../../css/demo.css" rel="stylesheet"> -->
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- jQuery -->
    <script src="../../../js/jquery.js"></script>
    <script src="../../../js/jquery-ui.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../../js/bootstrap.min.js"></script>
    
    
	
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../../js/metisMenu.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="../../../js/sb-admin-2.js"></script>
    
    <script src="../../../js/jquery.dataTables.min.js"></script>
    <script src="../../../js/dataTables.bootstrap.min.js"></script>
    <script src="../../../js/dataTables.responsive.min.js"></script>
    <script src="../../../js/responsive.bootstrap.min.js"></script>
    <script src="../../../js/confirm-bootstrap.js"></script>
    
    <script src="../../../js/dataTables.buttons.min.js"></script> 
    <script src="../../../js/buttons.flash.min.js"></script> 
    <script src="../../../js/jszip.min.js"></script>
    <script src="../../../js/pdfmake.min.js"></script>
    <script src="../../../js/vfs_fonts.js"></script>
    <script src="../../../js/buttons.html5.min.js"></script>  
    <script src="../../../js/buttons.print.min.js"></script>
    <script src="../../../js/buttons.colVis.min.js"></script>
    <script src="../../../js/jquery.formatCurrency.js"></script>
    <script src="../../../js/dataTables.fixedColumns.min.js"></script>
    <script src="../../../js/jquery.jeditable.js"></script>
    <script src="../../../js/jquery.dataTables.editable.js"></script>
    <script src="../../../js/womon.js"></script>
<!--     <script src="../../../js/ckeditor.js"></script>  -->
    <script src="../../../js/pnotify.js"></script>    
    <script type="text/javascript" src="../../../js/pnotify.mobile.js"></script>
    <link href="../../../css/pnotify.brighttheme.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../../js/pnotify.desktop.js"></script>
    
    
	<link rel="stylesheet" type="text/css" href="../../../css/subModal.css" />
	<script type="text/javascript" src="../../../js/common.js"></script>
	<script type="text/javascript" src="../../../js/subModal.js"></script>  
	<script type="text/javascript" src="../../../js/dragg.js"></script> 
		
	<link href="../../../css/jquery.virtual_keyboard.css" rel="stylesheet" type="text/css"/>
		
	<script type="text/javascript" src="../../../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../../js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
    
    <script src="../../../js/jquery.virtual_keyboard.js" type="text/javascript"></script>
    
    <link href="../../../css/keyboard.css" rel="stylesheet">
	<script src="../../../js/jquery.keyboard.js"></script>

	<!-- keyboard extensions (optional) -->
	<script src="../../../js/jquery.mousewheel.js"></script>
	<script src="../../../js/jquery.keyboard.extension-typing.js"></script>
	<script src="../../../js/jquery.keyboard.extension-autocomplete.js"></script>
	<script src="../../../js/jquery.keyboard.extension-caret.js"></script>
	
<script type="text/javascript" src="../../../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../../js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
    
    <script type="text/javascript">
    $(document).ready(function() {
	$('#example').DataTable({
	  "scrollX": true,
	  "bSort":false,
	  dom: 'lBfrtip',
		"buttons": [
		 'copy', 'csv', 'excel', 'print',{
		    extend: 'pdfHtml5',
		    orientation: 'landscape',
		    pageSize: 'LEGAL'
		}],"bJQueryUI": true,
		"aLengthMenu": [[10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000], [10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000]],
		"sScrollY": 500,
 	  "iDisplayLength":100,
	});
	
	$('.datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
    
    
	
	$('table.display').DataTable({
	  "scrollX": true,
	  dom: 'lBfrtip',
	    "buttons": [
	      'copy', 'csv', 'excel', 'print',{
		extend: 'pdfHtml5',
		orientation: 'landscape',
		pageSize: 'LEGAL'
	    }],
	    "bJQueryUI": true,
	    "aLengthMenu": [[10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000], [10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000]],
	});	      
	
	$('input[type=text]').addClass('form-control');
	$('textarea').addClass('form-control');
	$('checkbox').addClass('form-control');
	$('select').addClass('form-control');
	$('input[type=text]').addClass('inputwidth');
	$('textarea').addClass('inputwidth');
	$('checkbox').addClass('inputwidth');
	$('select').addClass('inputwidth');
	$('.table').addClass('table-condensed');
	$('.table').addClass('table-striped');
	$('.table').addClass('table-hover');
	$('.table').removeClass('tgrid');
	$('.table').removeClass('ggrid');
	$('.table').addClass('table-bordered');
// 	$('.table').addClass('dt-responsive');
	$('.table').addClass('nowrap');
	$('input[type=button]').addClass('btn');
	$('input[type=submit]').addClass('btn');
	
	$('table').removeClass('tgrid');
	$('table').removeClass('ggrid');
	$('table').addClass('table');
// 	$('.tgrid').addClass('table');
	
	$('.date_input').datepicker({
	    dateFormat: 'yy-mm-dd',
	    startDate: '-3d',
	    changeMonth:true,
	    changeYear:true
	});
	
// 	$('#editor').wysiwyg();
	
    } );
    
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
    $(".th").removeAttr("padding-right");
    $('div.dataTables_scrollHeadInner').css('padding-left', '0');
    $('div.dataTables_scrollHeadInner').css('padding-right', '0');

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
/* 	  max-width: none !important; */
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
      
      .pac-container {
	  z-index: 1051 !important;
      }
      
       table.dataTable.table-condensed > thead, tfoot > tr > th {
	    padding-right: 35px;
	    background-color:rgb(221,226,231);
	}
      
      #content-flex{
	
	border: 1px solid #ccc;
	padding:1px;
	border-radius: 6px;
/* 	background-color: #f8f8f8; */
	
      }
      
      .page-title{
	
	display:none;
	
      }
      
      .table th{
	
	text-transform: uppercase;
	
      }
      
      .nav > li > a {
	  position: relative;
	  display: block;
	  padding: 4px 5px;
      }
      
      .dataTables_wrapper{
	
	border: 1px solid #ccc;
	padding:1px;
	border-radius: 6px;
	
      }
      
      .dataTables_filter{
	
	border: 1px solid #ccc;
	padding:1px;
	border-radius: 6px;
	background-color: #ccc;
	
      }
      
      form{
      border: 1px solid #dff0d8;
	padding:1px;
	border-radius: 6px;
      }
      .dataTables_length{
	float:left;
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
                <a class="navbar-brand" href="../../../index.php">WiseDigits ERP</a>
            </div>
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
                            <a href="../../../modules/pm/tasks/addtasks_proc.php?id=<?php echo $row->taskid; ?>&not=true">
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
                $tasks = new Tasks();
		$fields="*";
		$where=" where pm_tasks.employeeid in(select employeeid from auth_users where id='".$_SESSION['userid']."') and (pm_tasks.statusid<=3 or statusid=5) ";
		$join="";
		$having="";
		$groupby="";
		$orderby=" order by createdon desc ";
		$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
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
                            <a href="../../../modules/pm/tasks/addtasks_proc.php?id=<?php echo $row->id; ?>&not=true"><span class="<?php echo $class; ?>"><?php echo $row->name; ?></span></a>
                            
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
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="javascript:;" onclick="showPopWin('../../auth/users/addusers_proc.php?id=<?php echo $_SESSION['userid']; ?>',600,430);"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../../../modules/auth/users/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                            <a href="../../../index.php"><img width="210" src="../../../images/<?php echo $_SESSION['logo']; ?>"></a>
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
			      $query1="select * from sys_submodules where moduleid='$row->id' and status=1 and type='main' order by description";
			      $res1=mysql_query($query1);
			      while($row1=mysql_fetch_object($res1)){ 
				$temp = explode("/", $row1->url);
				if(modularAuth($row->id,$_SESSION['level'],$temp[0],$temp[1])){
				?>
				<li>
				    <a href="../../../modules/<?php echo $row1->url; ?>"><i class="fa fa-tasks fa-fw"></i><?php echo initialCap($row1->description); ?></a>
				</li>
				<?php 
				}
			      }
                          
                          
			  $query1="select * from sys_submodules where moduleid='$row->id' and status=1 and type='setup' order by description";
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
			  </li>
			  <?php
			  }
			  ?>
                        </ul>
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
			      $query1="select * from sys_submodules where moduleid='$row->id' and status=1 and type='reports' order by description";
			      $res1=mysql_query($query1);
			      while($row1=mysql_fetch_object($res1)){ 
			      $temp = explode("/", $row1->url);
			      if(reportAuth($row->id,$_SESSION['level'],$temp[1],$temp[2])){
      // 				mysql_query("update sys_submodules set status=2 where id='$row1->id'");
			      ?>
                                <li>
                                    <a href="../../../<?php echo $row1->url; ?>"><i class="fa fa-tasks fa-fw"></i><?php echo strtoupper($row1->description); ?></a>
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

       
           
                     <div id="page-wrapper">
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <?php echo $page_title; ?>
                            
                            
                            
                        </div>
                        <div class="panel-body">
                        <?php }else{ ?> 
                        <!-- /.panel-heading -->
                        
                        
                        <?php if($pop!=2){?>
            <div class="row">
                <div class="col-lg-14">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <?php echo $page_title; ?>
                            <?php if(!empty($pops)){ ?>
                            <a href="../../../modules/auth/users/logout.php" style="font-size:18px;" class="btn btn-danger">Log Out</a>
                            <?php } ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
      <?php }} ?>
      
      
      
      
      
