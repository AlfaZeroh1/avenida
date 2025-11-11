<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/inv/branchstocks/Branchstocks_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/sys/branches/Branches_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if (empty($_SESSION['userid'])) {
    ;
    redirect("../../../modules/auth/users/login.php");
}

$page_title = "Branchstocks";
//connect to db
$db = new DB();

$obj = (object) $_POST;

if (empty($obj->action)) {
    $obj->brancheid = $_SESSION['brancheid'];
}

//Authorization.
$auth->roleid = "9497"; //Report View
$auth->levelid = $_SESSION['level'];

//auth($auth);
include "../../../head.php";

//$rptwhere=" inv_branchstocks.status='Available' ";
$rptjoin = '';
$track = 0;
$k = 0;
$fds = '';
$fd = '';
$aColumns = array();
$sColumns = array();
//Processing Groupings
$rptgroup = '';
$track = 0;
if (!empty($obj->grbrancheid) or ! empty($obj->gritemid) or ! empty($obj->grcreatedby) or ! empty($obj->grcreatedon)) {
    $obj->shbrancheid = '';
    $obj->shitemid = '';
    $obj->shquantity = '';
    $obj->shcreatedby = '';
    $obj->shcreatedon = '';
    $obj->shipaddress = '';
    $obj->shcostprice = '';
}


$obj->sh = 1;
$obj->grbrancheid = 1;
$obj->gritemid = 1;
$obj->shcostprice = 1;
$obj->shtcostprice = 1;
$obj->shquantity = 1;
$obj->shserialno = 1;



if (!empty($obj->grbrancheid)) {
    if ($track > 0)
        $rptgroup.=", ";
    else
        $rptgroup.=" group by ";

    $rptgroup.=" brancheid ";
    $obj->shbrancheid = 1;
    $track++;
}

if (!empty($obj->gritemid)) {
    if ($track > 0)
        $rptgroup.=", ";
    else
        $rptgroup.=" group by ";

    $rptgroup.=" itemid ";
    $obj->shitemid = 1;
    $track++;
}

if (!empty($obj->grcreatedby)) {
    if ($track > 0)
        $rptgroup.=", ";
    else
        $rptgroup.=" group by ";

    $rptgroup.=" createdby ";
    $obj->shcreatedby = 1;
    $track++;
}

if (!empty($obj->grcreatedon)) {
    if ($track > 0)
        $rptgroup.=", ";
    else
        $rptgroup.=" group by ";

    $rptgroup.=" createdon ";
    $obj->shcreatedon = 1;
    $track++;
}

//processing columns to show

array_push($sColumns, 'item');
array_push($aColumns, "inv_items.id as item");
// 	$k++;

if (!empty($obj->shbrancheid) or empty($obj->action)) {
    array_push($sColumns, 'brancheid');
    array_push($aColumns, "sys_branches.name as brancheid");
    $rptjoin.=" left join sys_branches on sys_branches.id=inv_branchstocks.brancheid ";
    $k++;
}

if (!empty($obj->shitemid) or empty($obj->action)) {
    array_push($sColumns, 'itemid');
    array_push($aColumns, "inv_items.name as itemid");
    $rptjoin.=" left join inv_items on inv_items.id=inv_branchstocks.itemid ";
    $k++;

    $itm = $k;
}

if (!empty($obj->shquantity) or empty($obj->action)) {
    array_push($sColumns, 'quantity');
    if (empty($rptgroup))
        array_push($aColumns, "inv_branchstocks.quantity");
    else
        array_push($aColumns, "sum(inv_branchstocks.quantity) quantity");
    $k++;

    $y = $k;
}

if (!empty($obj->shtcostprice)) {
    array_push($sColumns, 'tcostprice');
    array_push($aColumns, "case when inv_items.costprice is null then 0 else inv_items.costprice end as tcostprice");
    $k++;
    $join = " left join inv_items on inv_items.id=inv_branchstocks.itemid ";
    if (!strpos($rptjoin, trim($join))) {
        $rptjoin.=$join;
    }

    $x = $k;
}

if (!empty($obj->shcostprice)) {
    array_push($sColumns, 'costprice');
    if (empty($rptgroup))
        array_push($aColumns, "round((inv_branchstocks.quantity) * (case when inv_items.costprice is null then 0 else inv_items.costprice end),2) as costprice");
    else
        array_push($aColumns, "round(sum(inv_branchstocks.quantity) * (case when inv_items.costprice is null then 0 else inv_items.costprice end),2) as costprice");
    $k++;
    $join = " left join inv_items on inv_items.id=inv_branchstocks.itemid ";
    if (!strpos($rptjoin, trim($join))) {
        $rptjoin.=$join;
    }
    $mnt = $k;
}

if (!empty($obj->shcreatedby) or empty($obj->action)) {
    array_push($sColumns, 'createdby');
    array_push($aColumns, "auth_users.username createdby");
    $join = " left join auth_users on auth_users.id=inv_branchstocks.createdby ";
    if (!strpos($rptjoin, trim($join))) {
        $rptjoin.=$join;
    }
    $k++;
}

if (!empty($obj->shcreatedon) or empty($obj->action)) {
    array_push($sColumns, 'createdon');
    array_push($aColumns, "inv_branchstocks.createdon");
    $k++;
}

if (!empty($obj->shipaddress)) {
    array_push($sColumns, 'ipaddress');
    array_push($aColumns, "inv_branchstocks.ipaddress");
    $k++;
}

//processing columns to show




$track = 0;

//processing filters


$rptwhere = " 1=1 ";
$track++;

if (!empty($obj->brancheid)) {
    if ($track > 0)
        $rptwhere.="and";
    $rptwhere.=" inv_branchstocks.brancheid='$obj->brancheid'";

    $track++;
}

if (!empty($obj->itemid)) {
    if ($track > 0)
        $rptwhere.="and";
    $rptwhere.=" inv_branchstocks.itemid='$obj->itemid'";
    $track++;
}

if (!empty($obj->createdby)) {
    if ($track > 0)
        $rptwhere.="and";
    $rptwhere.=" inv_branchstocks.createdby='$obj->createdby'";
    $track++;
}

if (!empty($obj->fromcreatedon)) {
    if ($track > 0)
        $rptwhere.="and";
    $rptwhere.=" inv_branchstocks.createdon>='$obj->fromcreatedon'";
    $track++;
}

if (!empty($obj->tocreatedon)) {
    if ($track > 0)
        $rptwhere.="and";
    $rptwhere.=" inv_branchstocks.createdon<='$obj->tocreatedon'";
    $track++;
}

//Processing Joins
;
$track = 0;
echo "MNT:" . $mnt . " Y:" . $y . "X:" . $x;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript" charset="utf-8">
<?php $_SESSION['aColumns'] = $aColumns; ?>
<?php $_SESSION['sColumns'] = $sColumns; ?>
<?php $_SESSION['join'] = "$rptjoin"; ?>
<?php $_SESSION['sTable'] = "inv_branchstocks"; ?>
<?php $_SESSION['sOrder'] = ""; ?>
<?php $_SESSION['sWhere'] = "$rptwhere"; ?>
<?php $_SESSION['sGroup'] = "$rptgroup"; ?>


    $().ready(function () {
        $("#itemname").autocomplete({
            source: "../../../modules/server/server/search.php?main=inv&module=items&field=inv_items.name",
            appendTo: "#myModal", focus: function (event, ui) {
                event.preventDefault();
                $(this).val(ui.item.label);
            },
            select: function (event, ui) {
                event.preventDefault();
                $(this).val(ui.item.label);
                $("#itemid").val(ui.item.id);
            }
        });

    })

    $(document).ready(function () {


        $('#tbl').dataTable({
            "scrollX": true,
            dom: 'lBfrtip',
            "buttons": [
                'copy', 'csv', 'excel', 'print', {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }],
            "aLengthMenu": [[10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000], [10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000]],
            "bJQueryUI": true,
            "bSort": true,
            "sPaginationType": "full_numbers",
            "sScrollY": 400,
            "iDisplayLength": 50,
            "bJQueryUI": true,
                    "bRetrieve": true,
            "sAjaxSource": "../../../modules/server/server/processing.php?sTable=inv_branchstocks",
            "fnRowCallback": function (nRow, aaData, iDisplayIndex) {

                $('td:eq(0)', nRow).html(iDisplayIndex + 1);
                console.log(aaData);
                var num = aaData.length;
                for (var i = 1; i < num; i++) {
                    if (i == 1)
                        continue;
                    if (i == "<?php echo ($itm); ?>") {
                        $('td:eq(' + i + ')', nRow).html("<a href='../../../modules/inv/branchstocks/branchstocks.php?itemid=" + aaData[0] + "&brancheid=<?php echo $obj->brancheid; ?>&branche=1' >" + aaData[i] + "</a>");
                    } else if (i == "<?php echo $mnt; ?>" || i == "<?php echo $x; ?>" || i == "<?php echo $y; ?>") {
                        $('td:eq(' + i + ')', nRow).html(aaData[i]).formatCurrency().attr('align', 'right');
                    }
                    else
                        $('td:eq(' + i + ')', nRow).html(aaData[i]);
                }
                return nRow;
            },
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                $('th:eq(0)', nRow).html("1");
                $('th:eq(1)', nRow).html("TOTAL");
                var total = 0;
                var total1 = 0;
                var total2 = 0;
                for (var i = 0; i < aaData.length; i++) {
                    for (var j = 2; j < aaData[i].length; j++) {
                        if (j == "<?php echo $mnt; ?>") {

                            total += parseFloat(aaData[i][j]);
                            $('th:eq(' + j + ')', nRow).html(total).formatCurrency();
                        }
                        else if (j == "<?php echo $x; ?>") {

                            total1 += parseFloat(aaData[i][j]);
                            $('th:eq(' + j + ')', nRow).html(total1).formatCurrency();
                        }
                        else if (j == "<?php echo $y; ?>") {

                            total2 += parseFloat(aaData[i][j]);
                            $('th:eq(' + j + ')', nRow).html(total2).formatCurrency();
                        }
                        else {
                            $('th:eq(' + j + ')', nRow).html("");
                        }
                    }
                }
            }
        });
    });
</script>

<div id="main">
    <div id="main-inner">
        <div id="content">
            <div id="content-inner">
                <div id="content-header">
                    <div class="page-title"><?php echo $page_title; ?></div>
                    <div class="clearb"></div>
                </div>
                <div id="content-flex">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Filter</button>
                    <a class="btn btn-warning" target="_blank" href="../../graphs/graphs/bars.php">Bar Graph</a>
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Filter</h4>
                                </div>
                                <div class="modal-body">
                                    <form  action="branchstocks.php" method="post" name="branchstocks" >
                                        <table width="100%" border="0" align="center">
                                            <tr>
                                                <td width="50%" rowspan="2">
                                                    <table class="tgrid gridd" border="0" align="right">
                                                        <tr>
                                                            <td>Branch</td>
                                                            <td>
                                                                <select name='brancheid' class='selectbox'>
                                                                    <?php
                                                                    $branches = new Branches();
                                                                    $where = "  ";
                                                                    if ($_SESSION['brancheid'] == 6) {
                                                                        ?>
                                                                        <option value="">ALL...</option>
                                                                        <?php
                                                                        $where = "";
                                                                    } else {
                                                                        ?>
                                                                        <option value="">Select here...</option>
                                                                        <?php
                                                                        $where = " ";
                                                                    }
                                                                    $fields = " * ";
                                                                    $join = "";
                                                                    $having = "";
                                                                    $groupby = "";
                                                                    $orderby = "";
                                                                    $branches->retrieve($fields, $join, $where, $having, $groupby, $orderby);

                                                                    while ($rw = mysql_fetch_object($branches->result)) {
                                                                        ?>
                                                                        <option value="<?php echo $rw->id; ?>" <?php
                                                                        if ($obj->brancheid == $rw->id) {
                                                                            echo "selected";
                                                                        }
                                                                        ?>>
                                                                                    <?php echo initialCap($rw->name); ?>
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Itemid</td>
                                                            <td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
                                                                <input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Created By</td>
                                                            <td>
                                                                <select name='createdby' class='selectbox'>
                                                                    <option value=''>Select...</option>
                                                                    <?php
                                                                    $users = new Users();
                                                                    $fields = "*";
                                                                    $where = "";
                                                                    $join = "   ";
                                                                    $having = "";
                                                                    $groupby = "";
                                                                    $orderby = "";
                                                                    $users->retrieve($fields, $join, $where, $having, $groupby, $orderby);

                                                                    while ($rw = mysql_fetch_object($users->result)) {
                                                                        ?>
                                                                        <option value="<?php echo $rw->id; ?>" <?php
                                                                        if ($obj->createdby == $rw->id) {
                                                                            echo "selected";
                                                                        }
                                                                        ?>><?php echo $rw->username; ?></option>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Created On</td>
                                                            <td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon; ?>'/>
                                                                <br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon; ?>'/></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>
                                                    <table class="tgrid gridd" width="100%" border="0" align="left">
                                                        <tr>
                                                            <th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
                                            </tr>
                                            <tr>
                                                <td><input type='checkbox' name='grbrancheid' value='1' <?php
                                                    if (isset($_POST['grbrancheid'])) {
                                                        echo"checked";
                                                    }
                                                    ?>>&nbsp;Branch</td>
                                                <td><input type='checkbox' name='gritemid' value='1' <?php
                                                    if (isset($_POST['gritemid'])) {
                                                        echo"checked";
                                                    }
                                                    ?>>&nbsp;Item</td>
                                            <tr>
                                                <td><input type='checkbox' name='grcreatedby' value='1' <?php
                                                    if (isset($_POST['grcreatedby'])) {
                                                        echo"checked";
                                                    }
                                                    ?>>&nbsp;Created By</td>
                                                <td><input type='checkbox' name='grcreatedon' value='1' <?php
                                                    if (isset($_POST['grcreatedon'])) {
                                                        echo"checked";
                                                    }
                                                    ?>>&nbsp;Created On</td>
                                        </table>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table class="tgrid gridd" width="100%" border="0" align="left">
                                                    <tr>
                                                        <th colspan="3"><div align="left"><strong>Fields to Show (For Detailed Reports)</strong>: </div></th>
                                        </tr>
                                        <tr>
                                            <td><input type='checkbox' name='shbrancheid' value='1' <?php
                                                if (isset($_POST['shbrancheid']) or empty($obj->action)) {
                                                    echo"checked";
                                                }
                                                ?>>&nbsp;Branch</td>
                                            <td><input type='checkbox' name='shitemid' value='1' <?php
                                                if (isset($_POST['shitemid']) or empty($obj->action)) {
                                                    echo"checked";
                                                }
                                                ?>>&nbsp;Item</td>
                                        <tr>

                                            <td><input type='checkbox' name='shquantity' value='1' <?php
                                                if (isset($_POST['shquantity']) or empty($obj->action)) {
                                                    echo"checked";
                                                }
                                                ?>>&nbsp;Quantity</td>
                                            <td><input type='checkbox' name='shcostprice' value='1' <?php
                                                if (isset($_POST['shcostprice'])) {
                                                    echo"checked";
                                                }
                                                ?>>&nbsp;Total Cost Price</td>
                                        <tr>
                                            <td><input type='checkbox' name='shcreatedby' value='1' <?php
                                                if (isset($_POST['shcreatedby']) or empty($obj->action)) {
                                                    echo"checked";
                                                }
                                                ?>>&nbsp;Created By</td>
                                            <td><input type='checkbox' name='shcreatedon' value='1' <?php
                                                if (isset($_POST['shcreatedon']) or empty($obj->action)) {
                                                    echo"checked";
                                                }
                                                ?>>&nbsp;Created On</td>
                                        <tr>
                                            <td><input type='checkbox' name='shipaddress' value='1' <?php
                                                if (isset($_POST['shipaddress'])) {
                                                    echo"checked";
                                                }
                                                ?>>&nbsp;Ipaddress</td>
                                            <td><input type='checkbox' name='shtcostprice' value='1' <?php
                                                if (isset($_POST['shtcostprice'])) {
                                                    echo"checked";
                                                }
                                                ?>>&nbsp;Cost Price</td>
                                        <tr>
                                            <td><input type='checkbox' name='shserialno' value='1' <?php
                                                if (isset($_POST['shserialno'])) {
                                                    echo"checked";
                                                }
                                                ?>>&nbsp;Serial No</td>
                                            <td><input type='checkbox' name='shtcostprice' value='1' <?php
                                                if (isset($_POST['shtcostprice'])) {
                                                    echo"checked";
                                                }
                                                ?>>&nbsp;Cost Price</td>

                                            </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align='center'><input type="submit" class="btn" name="action" id="action" value="Filter" /></td>
                                        </tr>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
                        <thead>
                            <tr>
                                <th>#</th>
        <!-- 			<th>Branch </th> -->
                                <?php if ($obj->shbrancheid == 1 or empty($obj->action)) { ?>
                                    <th>Branch </th>
                                <?php } ?>
                                <?php if ($obj->shitemid == 1 or empty($obj->action)) { ?>
                                    <th>Product </th>
                                <?php } ?>

                                <?php if ($obj->shquantity == 1 or empty($obj->action)) { ?>
                                    <th>Quantity </th>
                                <?php } ?>
                                <?php if ($obj->shtcostprice == 1) { ?>
                                    <th>Cost Price </th>
                                <?php } ?>
                                <?php if ($obj->shcostprice == 1) { ?>
                                    <th>Total Cost Price </th>
                                <?php } ?>

                                <?php if ($obj->shcreatedby == 1 or empty($obj->action)) { ?>
                                    <th>Created By </th>
                                <?php } ?>
                                <?php if ($obj->shcreatedon == 1 or empty($obj->action)) { ?>
                                    <th>Created On </th>
                                <?php } ?>
                                <?php if ($obj->shipaddress == 1) { ?>
                                    <th>IP Address </th>
                                <?php } ?>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <?php if ($obj->shbrancheid == 1 or empty($obj->action)) { ?>
                                    <th>&nbsp; </th>
                                <?php } ?>
                                <?php if ($obj->shitemid == 1 or empty($obj->action)) { ?>
                                    <th>&nbsp; </th>
                                <?php } ?>

                                <?php if ($obj->shquantity == 1 or empty($obj->action)) { ?>
                                    <th>&nbsp; </th>
                                <?php } ?>
                                <?php if ($obj->shtcostprice == 1) { ?>
                                    <th>&nbsp;</th>
                                <?php } ?>
                                <?php if ($obj->shcostprice == 1) { ?>
                                    <th>&nbsp;</th>
                                <?php } ?>

                                <?php if ($obj->shcreatedby == 1 or empty($obj->action)) { ?>
                                    <th>&nbsp; </th>
                                <?php } ?>
                                <?php if ($obj->shcreatedon == 1 or empty($obj->action)) { ?>
                                    <th>&nbsp; </th>
                                <?php } ?>
                                <?php if ($obj->shipaddress == 1) { ?>
                                    <th>&nbsp;</th>
                                <?php } ?>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include"../../../foot.php";
?>