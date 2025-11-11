<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/orders/Orders_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/inv/categorys/Categorys_class.php");
require_once("../../../modules/inv/departments/Departments_class.php");
require_once("../../../modules/sys/branches/Branches_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Orders";
//connect to db
$db=new DB();

$ob = (object)$_GET;
$obj=(object)$_POST;

if(!empty($ob->type))
  $obj->type=$ob->type;

if(empty($obj->action)){
    $obj->fromorderedon=date('Y-m-d');
    $obj->toorderedon=date('Y-m-d');
}

//Authorization.
$auth->roleid="8729";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

if(empty($obj->action)){
	$obj->fromorderedon=date('Y-m-d');
	$obj->toorderedon=date('Y-m-d');
	}
?>

<title>
    <?php echo $page_title; ?>
</title>

<link rel="stylesheet" href="orders_report.css">
<style media="all" type="text/css">
.confirmed{
  	background-color: green;
    color: white;
}
.danger{
  	background-color: green;
    color: red;
}
</style>

<div id="main">
    <div id="loading_cont">
        <div id="loading">
            <span>Loading</span>
        </div>
    </div>
    
    <div id="main-inner">

        <div id="content">

            <div id="content-inner">		  
                <div class="page-title"><?php echo $page_title; ?></div>
	            <div class="clearb"></div>
            </div>

            <div id="content-flex">
                <a style="color:red;" href="#" onclick="Clickheretoprint();">Print</a>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Filter</button>&nbsp;<?php if(!empty($rptgroup)){?><a class="btn btn-warning" target="_blank" href="../../graphs/graphs/bars.php">Bar Graph</a><?php } ?>


                <!-- -------------------------MODAL-------------------------------------------------- -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Filter</h4>
                            </div>
                            <div class="modal-body">
                                <!--FOrm Goes in Here  -->
                                <form action="orders.php" method="post" name="orders">
                                    <table width="100%" border="0" align="center">
                                        <tr>
                                            <td width="50%" <?php echo $str; ?>>
                                                <table class="table" border="0" align="right">
                                                    <tr>
                                                        <td>
                                                            Order No
                                                            <input type="hidden" name="type" value="<?php echo $obj->type; ?>" />
                                                        </td>
                                                        <td>
                                                            <input type='text' id='orderno' size='20' name='orderno' value='<?php echo $obj->orderno; ?>' />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Product Category</td>
                                                        <td>
                                                            <select name='categoryid' class='selectbox'>
                                                                <option value="">Select...</option>
                                                                <?php
                                                                $category = new Categorys();
                                                                $category->retrieve("*", "", "", "", "", "");
                                                                while ($rw = mysql_fetch_object($category->result)) {
                                                                ?>
                                                                    <option value="<?php echo $rw->id; ?>" <?php if ($obj->categoryid == $rw->id) { echo "selected"; } ?>>
                                                                        <?php echo initialCap($rw->name); ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Product Department</td>
                                                        <td>
                                                            <select name='departmentid' class='selectbox'>
                                                                <option value="">Select...</option>
                                                                <?php
                                                                $department = new Departments();
                                                                $department->retrieve("*", "", "", "", "", "");
                                                                while ($rw = mysql_fetch_object($department->result)) {
                                                                ?>
                                                                    <option value="<?php echo $rw->id; ?>" <?php if ($obj->departmentid == $rw->id) { echo "selected"; } ?>>
                                                                        <?php echo initialCap($rw->name); ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Location:</td>
                                                        <td>
                                                            <select name="brancheid2" id="brancheid2">
                                                                <option value="">Select...</option>
                                                                <?php
                                                                $branches = new Branches();
                                                                $branches->retrieve("*", "", "", "", "", "");
                                                                while ($rw = mysql_fetch_object($branches->result)) {
                                                                ?>
                                                                    <option value="<?php echo $rw->id; ?>" <?php if ($rw->id == $obj->brancheid2) { echo "selected"; } ?>>
                                                                        <?php echo $rw->name; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ordered On</td>
                                                        <td>
                                                            <strong>From:</strong>
                                                            <input type='text' id='fromorderedon' size='20' name='fromorderedon' readonly class="date_input" value='<?php echo $obj->fromorderedon; ?>' />
                                                            <br />
                                                            <strong>To:</strong>
                                                            <input type='text' id='toorderedon' size='20' name='toorderedon' readonly class="date_input" value='<?php echo $obj->toorderedon; ?>' />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Created By</td>
                                                        <td>
                                                            <select name='createdby' class='selectbox'>
                                                                <option value=''>Select...</option>
                                                                <?php
                                                                $users = new Users();
                                                                $fields = "auth_users.id, concat(hrm_employees.pfnum, ' ', concat(hrm_employees.firstname, ' ', concat(hrm_employees.middlename, ' ', hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname, ' ', concat(hrm_employees.middlename, ' ', hrm_employees.lastname)) employeename";
                                                                $where = " where auth_users.id in(select createdby from pos_orders)";
                                                                $join = " left join hrm_employees on hrm_employees.id=auth_users.employeeid";
                                                                $orderby = " order by employeename";
                                                                $users->retrieve($fields, $join, $where, "", "", $orderby);
                                                                while ($rw = mysql_fetch_object($users->result)) {
                                                                ?>
                                                                    <option value="<?php echo $rw->id; ?>" <?php if ($obj->createdby == $rw->id) { echo "selected"; } ?>>
                                                                        <?php echo $rw->employeeid; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Created On</td>
                                                        <td>
                                                            <strong>From:</strong>
                                                            <input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon; ?>' />
                                                            <br />
                                                            <strong>To:</strong>
                                                            <input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon; ?>' />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Product</td>
                                                        <td>
                                                            <select name='itemid' class='selectbox'>
                                                                <option value="">Select...</option>
                                                                <?php
                                                                $items = new Items();
                                                                $items->retrieve("*", "", "", "", "", "");
                                                                while ($rw = mysql_fetch_object($items->result)) {
                                                                ?>
                                                                    <option value="<?php echo $rw->id; ?>" <?php if ($obj->itemid == $rw->id) { echo "selected"; } ?>>
                                                                        <?php echo initialCap($rw->name); ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="2" align='center'>
                                                <input type="submit" class="btn" name="action" id="action" value="Filter" />
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                <!--FOrm Goes in Here  -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -------------------------END OF MODAL-------------------------------------------------- -->


                <!-- -------------------------REPORTS TABLE-------------------------------------------------- -->
                <table style="clear:both;"  class="table table_loading" id="tbl" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order No </th>
                            <th>Shift</th>
                            <th>Category </th>
                            <th>Department </th>
                            <th>Product</th>
                            <th>Date Ordered </th>
                            <th>Quantity </th>
                            <th>Unit Price </th>
                            <th>Total </th>
                            <th>Created By </th>
                            <th>Created On</th>
                            <th>Edited By </th>
                            <th>Edited On </th>
                            <th>IP Address </th>
                            <th>Confirmed</th>
                            <th>Packed</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            // $where = "";
                            $where = " WHERE pt.teamedon>='$obj->fromorderedon' AND  pt.teamedon<='$obj->toorderedon' ";
                            $limit = " LIMIT 10000";
                            $query = "SELECT p.orderno as orderno, ps.name as shift, ic.name as category, idpt.name as department, ii.name as product, p.orderedon as date_ordered, po.quantity-(case when po.voids is null then 0 else po.voids end) as quantity, ii.retailprice as unit_price, 0 as total, user_created.username as created_by, user_edited.username as edited_by, p.createdon as created_on, p.lasteditedon as edited_on, p.ipaddress as ip_address, 0 as confirmed, 1 as packed FROM pos_orders p LEFT JOIN pos_orderdetails po ON po.orderid=p.id LEFT JOIN inv_items ii ON ii.id=po.itemid LEFT JOIN inv_departments idpt ON idpt.id = ii.departmentid LEFT JOIN inv_categorys ic ON ic.id=ii.categoryid LEFT JOIN pos_teams pt on pt.id=p.shiftid LEFT JOIN pos_shifts ps on ps.id=pt.shiftid LEFT JOIN auth_users user_created ON p.createdby =  user_created.id LEFT JOIN auth_users user_edited ON p.lasteditedby =  user_edited.id $where $limit";
                            // echo"<tr><td colspan='17'>$query<td><tr>";
                            $res  = mysql_query($query);
                            $i=1;
                            while($row = mysql_fetch_object($res)){
                                ?>
                                    <tr>
                                        <td><?php echo "$i";$i++ ?></td>
                                        <td><?php echo "$row->orderno"; ?></td>
                                        <td><?php echo "$row->shift"; ?></td>
                                        <td><?php echo "$row->category"; ?></td>
                                        <td><?php echo "$row->department"; ?></td>
                                        <td><?php echo "$row->product"; ?></td>
                                        <td><?php echo "$row->date_ordered"; ?></td>
                                        <td><?php echo "$row->quantity"; ?></td>
                                        <td><?php echo "$row->unit_price"; ?></td>
                                        <td><?php echo "$row->total"; ?></td>
                                        <td><?php echo "$row->created_by"; ?></td>
                                        <td><?php echo "$row->created_on"; ?></td>
                                        <td><?php echo "$row->edited_by"; ?></td>
                                        <td><?php echo "$row->edited_on"; ?></td>
                                        <td><?php echo "$row->ip_address"; ?></td>
                                        <td><?php echo "$row->confirmed"; ?></td>
                                        <td><?php echo "$row->packed"; ?></td>
                                    </tr>
                                <?php

                            }
                        ?>
                        
                    </tbody>

                    <tfoot>
                        <tr>
                            <td>#</td>
                            <td>Order No </td>
                            <td>Shift</td>
                            <td>Category </td>
                            <td>Department </td>
                            <td>Product</td>
                            <td>Date Ordered </td>
                            <td>Remarks </td>
                            <td>Created By </td>
                            <td>Edited By </td>
                            <td>Created On</td>
                            <td>Edited On </td>
                            <td>IP Address </td>
                            <td>Confirmed</td>
                            <td>Packed</td>
                            <td>Unit Price </td>
                            <td>Total </td>
                        </tr>
                    </tfoot>
                </table>
                <!-- -------------------------END OF REPORTS TABLE-------------------------------------------------- -->
            </div>
        </div>
    </div>
</div>
</div>


<script>
    window.addEventListener('load', function() {
        const loadingScreen = document.getElementById('loading_cont');
        loadingScreen.classList.add('hide_loading_screen');
        // alert('Working');
    });
</script>