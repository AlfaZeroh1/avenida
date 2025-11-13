<?php
// receipt_print_qz.php  (PHP 5.6)
session_start();
require_once "../../../DB.php";
require_once '../../sys/config/Config_class.php';
require_once("../../pos/orders/Orders_class.php");
require_once("../../pos/orderdetails/Orderdetails_class.php");

$db = new DB();

if (!isset($_GET['doc']) || trim($_GET['doc']) === '') {
    echo "Missing order reference (?doc=ORDERNO)."; exit;
}
$doc = mysql_real_escape_string($_GET['doc']);

// --- fetch order (same your existing method) ---
$orders = new Orders();
$fields = "pos_orders.*, sys_branches.name branchename, sys_branches.printer, sys_branches.printer2, pos_orders.id as ids";
$join = " LEFT JOIN sys_branches ON sys_branches.id = pos_orders.brancheid ";
$where = " WHERE pos_orders.orderno = '{$doc}' ";
$orders->retrieve($fields, $join, $where);
$order = $orders->fetchObject;
if (!$order) { echo "Order not found: " . htmlspecialchars($doc); exit; }

// --- company lines ---
$config = new Config();
$config->retrieve(" * ", "", " WHERE id IN (1,2,9) ");
$company_lines = array();
while ($con = mysql_fetch_object($config->result)) $company_lines[] = $con->value;

// --- order items ---
$orderdetails = new Orderdetails();
$fields = "SUM(pos_orderdetails.quantity) quantity, inv_items.name itemname, pos_orderdetails.price, SUM(pos_orderdetails.quantity*pos_orderdetails.price) total, inv_items.warmth war, CASE WHEN inv_items.warmth=1 THEN CASE WHEN pos_orderdetails.warmth=1 THEN 'Warm' ELSE 'Cold' END ELSE '' END warm";
$join = " LEFT JOIN inv_items ON pos_orderdetails.itemid=inv_items.id ";
$groupby = " GROUP BY pos_orderdetails.itemid, price, pos_orderdetails.warmth ";
$where = " WHERE orderid IN (" . $order->ids . ") ";
$orderdetails->retrieve($fields, $join, $where, "", $groupby, "");
$items = array(); $total = 0.0;
while ($row = mysql_fetch_object($orderdetails->result)) {
    if (!empty($row->warm)) $row->itemname .= " - " . $row->warm;
    $items[] = $row;
    $total += ($row->price * $row->quantity);
}

function fmt($n) { return number_format($n,2); }

$servedBy = "";
if (!empty($order->createdby)) {
    $q = "SELECT CONCAT(TRIM(hrm_employees.firstname),' ',TRIM(hrm_employees.middlename),' ',TRIM(hrm_employees.lastname)) employeename FROM hrm_employees LEFT JOIN auth_users ON hrm_employees.id = auth_users.employeeid WHERE auth_users.id = '". mysql_real_escape_string($order->createdby) ."'";
    $er = mysql_query($q);
    if ($er) { $eo = mysql_fetch_object($er); if ($eo) $servedBy = $eo->employeename; }
}

$branchName = isset($order->branchename) ? $order->branchename : '';
$orderNo = isset($order->orderno) ? $order->orderno : $doc;
$dateTime = date("d/m/Y H:i:s");

// --- CONFIG: set your printer name and number of copies here ---
$printerName = 'PRINTER_NAME_HERE';   // <<< set exactly as in Windows
$copies = 1;                          // <<< number of copies you want

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Receipt - <?php echo htmlspecialchars($orderNo); ?></title>

<!-- QZ Tray JS (use published CDN) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qz-tray/2.1.0/qz-tray.js"></script>

<style>
/* minimal receipt styling (72mm) */
body{margin:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000;}
.receipt{width:72mm;padding:4mm;}
.header{text-align:center;font-weight:700;}
.items{width:100%;border-collapse:collapse;margin-top:6px;}
.items td{padding:2px 0;}
.right{text-align:right;}
</style>
</head>
<body>

<div id="receipt" class="receipt">
  <div class="header">
    <?php foreach ($company_lines as $i => $line): ?>
      <?php if ($i===0): ?><div><?php echo htmlspecialchars($line); ?></div>
      <?php else: ?><div style="font-size:11px;"><?php echo htmlspecialchars($line); ?></div><?php endif; ?>
    <?php endforeach; ?>
    <div style="margin-top:6px;">Order: <?php echo htmlspecialchars($orderNo); ?></div>
  </div>

  <div style="margin-top:6px;">
    Served By: <?php echo htmlspecialchars($servedBy); ?><br>
    Table No: <?php echo htmlspecialchars($order->tableno); ?><br>
    Location: <?php echo htmlspecialchars($branchName); ?><br>
    Time: <?php echo htmlspecialchars($dateTime); ?><br>
  </div>

  <table class="items" cellspacing="0" cellpadding="0">
    <?php foreach($items as $it): ?>
      <tr>
        <td><?php echo htmlspecialchars($it->itemname); ?></td>
        <td class="right"><?php echo (int)$it->quantity; ?></td>
        <td class="right"><?php echo fmt($it->price); ?></td>
        <td class="right"><?php echo fmt($it->total); ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <div style="margin-top:6px;">
    <div>TOTAL: <?php echo fmt($total); ?></div>
  </div>
</div>

<script>
// --------- QZ TRAY PRINT SCRIPT ----------
// Make sure QZ Tray is running on the client machine.

(function(){
  var printerName = <?php echo json_encode($printerName); ?>;
  var copies = <?php echo (int)$copies; ?>;
  var receiptHtml = document.getElementById('receipt').innerHTML;

  // Helper to show errors (replace with better UI if needed)
  function showError(msg) {
    alert('Print error: ' + msg);
    // fallback: open print dialog if QZ not available
    // window.print();
  }

  // Connect to QZ Tray
  function connectQZ() {
    return qz.websocket.connect().then(function(){
      console.log('QZ connected');
    });
  }

  // Find the printer (ensures exact name)
  function findPrinter(name) {
    return qz.printers.find(name).then(function(found){
      return found;
    });
  }

  // Create printing config with copies
  function createConfig(printer) {
    return qz.configs.create(printer, { copies: copies });
  }

  // Print HTML (simplest). QZ will render HTML to printer.
  function printHtml(config, html) {
    var data = [{
      type: 'html',
      format: 'plain',
      data: html
    }];
    return qz.print(config, data);
  }

  // Auto-run: connect, find printer, print, close
  document.addEventListener('DOMContentLoaded', function(){
    connectQZ().then(function(){
      return findPrinter(printerName);
    }).then(function(foundPrinter){
      var cfg = createConfig(foundPrinter);
      return printHtml(cfg, receiptHtml);
    }).then(function() {
      console.log('Printed via QZ Tray');
      // close connection and window
      setTimeout(function(){
        qz.websocket.disconnect();
        window.close();
      }, 500);
    }).catch(function(err){
      console.error(err);
      showError(err && err.toString ? err.toString() : err);
    });
  });
})();
</script>

</body>
</html>
