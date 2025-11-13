<?php
// receipt_print_qz.php
session_start();
require '../../../autoload.php';
require_once "../../../DB.php";
require_once "../../../lib.php";
require_once '../../sys/config/Config_class.php';
require_once("../../pos/orders/Orders_class.php");
require_once("../../pos/orderdetails/Orderdetails_class.php");

// fetch order like before...
$db = new DB();
if(!isset($_GET['doc'])||trim($_GET['doc'])===''){ echo "Missing doc"; exit; }
$doc = mysql_real_escape_string($_GET['doc']);

// Fetch order
$orders = new Orders();
$fields = "pos_orders.*, sys_branches.name branchename, pos_orders.id as ids";
$join = " LEFT JOIN sys_branches ON sys_branches.id = pos_orders.brancheid ";
$where = " WHERE pos_orders.orderno = '{$doc}' ";
$orders->retrieve($fields,$join,$where);
$order=$orders->fetchObject;
if(!$order){ echo "Order not found"; exit; }

$config = new Config();
$config->retrieve(" * ", "", " WHERE id IN (1,2,9) ");
$company_lines = array();
while ($con = mysql_fetch_object($config->result)) { $company_lines[] = $con->value; }

$orderdetails = new Orderdetails();
$fields = "SUM(pos_orderdetails.quantity) quantity, inv_items.name itemname, pos_orderdetails.price, SUM(pos_orderdetails.quantity*pos_orderdetails.price) total, inv_items.warmth war, CASE WHEN inv_items.warmth=1 THEN CASE WHEN pos_orderdetails.warmth=1 THEN 'Warm' ELSE 'Cold' END ELSE '' END warm";
$join = " LEFT JOIN inv_items ON pos_orderdetails.itemid=inv_items.id ";
$where = " WHERE orderid IN (" . $order->ids . ") ";
$groupby = " GROUP BY pos_orderdetails.itemid, price, pos_orderdetails.warmth ";
$orderdetails->retrieve($fields,$join,$where,"",$groupby,"");
$items=array(); $total=0;
while($row=mysql_fetch_object($orderdetails->result)){ 
    if(!empty($row->warm)) $row->itemname.=" - ".$row->warm; 
    $items[]=$row; 
    $total+=$row->price*$row->quantity; 
}
function fmt($n){ return number_format($n,2); }
$servedBy="";
if(!empty($order->createdby)){
    $q="SELECT CONCAT(TRIM(hrm_employees.firstname),' ',TRIM(hrm_employees.middlename),' ',TRIM(hrm_employees.lastname)) employeename FROM hrm_employees LEFT JOIN auth_users ON hrm_employees.id=auth_users.employeeid WHERE auth_users.id='".mysql_real_escape_string($order->createdby)."'";
    $er=mysql_query($q); if($er){ $eo=mysql_fetch_object($er); if($eo) $servedBy=$eo->employeename; }
}
$orderNo=$order->orderno;
$branchName=$order->branchename;
$dateTime=date("d/m/Y H:i:s");
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Receipt <?php echo htmlspecialchars($orderNo); ?></title>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qz-tray/2.1.0/qz-tray.js"></script>

<style>
body{font-family:sans-serif;font-size:12px;width:72mm;margin:0;padding:3mm;}
</style>
</head>
<body>

<div id="receipt">
<?php foreach($company_lines as $i=>$line): ?>
<?php echo htmlspecialchars($line); ?><br>
<?php endforeach; ?>
Served By: <?php echo htmlspecialchars($servedBy); ?><br>
Table: <?php echo htmlspecialchars($order->tableno); ?><br>
Order No: <?php echo htmlspecialchars($orderNo); ?><br>
Date: <?php echo htmlspecialchars($dateTime); ?><br>
<hr>
<?php foreach($items as $it): ?>
<?php echo htmlspecialchars($it->itemname); ?> x <?php echo (int)$it->quantity; ?> @ <?php echo fmt($it->price); ?> = <?php echo fmt($it->total); ?><br>
<?php endforeach; ?>
<hr>
TOTAL: <?php echo fmt($total); ?><br>
</div>

<script>
// connect to QZ Tray
qz.websocket.connect().then(function() {
    var config = qz.configs.create("POS Printer Name", {copies:2}); // change printer name and copies
    var data = [{ type:'html', format:'plain', data: document.getElementById('receipt').innerHTML }];
    return qz.print(config,data);
}).then(function(){
    console.log("Printed successfully");
    setTimeout(function(){ window.close(); }, 1000);
}).catch(function(e){
    console.error("Print failed: ", e);
    alert("Printing error: "+e);
});
</script>

</body>
</html>
