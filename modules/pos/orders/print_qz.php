<?php
// receipt_print_qz.php
session_start();
require_once "../../../DB.php";
require_once '../../sys/config/Config_class.php';
require_once("../../pos/orders/Orders_class.php");
require_once("../../pos/orderdetails/Orderdetails_class.php");

$db = new DB();

if (!isset($_GET['doc']) || trim($_GET['doc']) === '') {
    echo "Missing order reference (use ?doc=ORDERNO).";
    exit;
}

$doc = mysql_real_escape_string($_GET['doc']);

$orders = new Orders();
$fields = "pos_orders.*, sys_branches.name branchename, sys_branches.printer, pos_orders.id as ids";
$join = " LEFT JOIN sys_branches ON sys_branches.id = pos_orders.brancheid ";
$where = " WHERE pos_orders.orderno = '{$doc}' ";
$orders->retrieve($fields, $join, $where);
$order = $orders->fetchObject;
if (!$order) { echo "Order not found: " . htmlspecialchars($doc); exit; }

$config = new Config();
$config->retrieve(" * ", "", " WHERE id IN (1,2,9) ");
$company_lines = array();
while ($con = mysql_fetch_object($config->result)) $company_lines[] = $con->value;

$orderdetails = new Orderdetails();
$fields = "SUM(pos_orderdetails.quantity) quantity, inv_items.name itemname, pos_orderdetails.price, 
           SUM(pos_orderdetails.quantity*pos_orderdetails.price) total, inv_items.warmth war,
           CASE WHEN inv_items.warmth=1 THEN CASE WHEN pos_orderdetails.warmth=1 THEN 'Warm' ELSE 'Cold' END ELSE '' END warm";
$join = " LEFT JOIN inv_items ON pos_orderdetails.itemid=inv_items.id ";
$groupby = " GROUP BY pos_orderdetails.itemid, price, pos_orderdetails.warmth ";
$where = " WHERE orderid IN (" . $order->ids . ") ";
$orderdetails->retrieve($fields, $join, $where, "", $groupby, "");
$items = array();
$total = 0.0;
while ($row = mysql_fetch_object($orderdetails->result)) {
    if (!empty($row->warm)) $row->itemname .= " - " . $row->warm;
    $items[] = $row;
    $total += ($row->price * $row->quantity);
}

function fmt($n) { return number_format($n, 2); }

$servedBy = "";
if (!empty($order->createdby)) {
    $q = "SELECT CONCAT(TRIM(hrm_employees.firstname), ' ', TRIM(hrm_employees.middlename), ' ', TRIM(hrm_employees.lastname)) employeename 
          FROM hrm_employees 
          LEFT JOIN auth_users ON hrm_employees.id = auth_users.employeeid 
          WHERE auth_users.id = '" . mysql_real_escape_string($order->createdby) . "'";
    $er = mysql_query($q);
    if ($er) { $eo = mysql_fetch_object($er); if ($eo) $servedBy = $eo->employeename; }
}

$branchName = isset($order->branchename) ? $order->branchename : '';
$orderNo = isset($order->orderno) ? $order->orderno : $doc;
$dateTime = date("d/m/Y H:i:s");

$printerNameJS = addslashes(isset($order->printer) && $order->printer != '' ? $order->printer : '');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Receipt - <?php echo htmlspecialchars($orderNo); ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rsvp/4.8.5/rsvp.min.js"></script>

<!-- 🔥 UPDATED: QZ TRAY 2.2.5 -->
<script src="https://cdn.jsdelivr.net/npm/qz-tray@2.2.5/qz-tray.js"></script>

<!-- 🔥 REQUIRED SECURITY BLOCK FOR QZ 2.2.5 -->
<script>
//
// SHA-256 hashing for QZ Tray (browser native API)
//
window.sha256 = function(data) {
    return crypto.subtle.digest("SHA-256", new TextEncoder().encode(data))
        .then(buf =>
            Array.from(new Uint8Array(buf))
            .map(b => b.toString(16).padStart(2, "0"))
            .join("")
        );
};

qz.security.setSha256Type(function(data) {
    return sha256(data);
});

//
// Disable signature (DEV MODE) — Works perfectly with local printers.
// QZ Tray requires a promise that resolves to a signature string.
//
qz.security.setSignaturePromise(function(toSign) {
    console.warn("QZ SIGNATURE DISABLED — returning empty signature");
    return Promise.resolve("");
});
</script>

<style>
:root { --receipt-width-mm: 72mm; --font-family: "DejaVu Sans", Arial, sans-serif; --txt-color: #000; }
html, body { margin:0; padding:0; font-family:var(--font-family); font-size:12px; color:var(--txt-color); }
.receipt { width: calc(var(--receipt-width-mm) - 6mm); margin:0 auto; padding:6px 3mm; box-sizing:border-box; }
.header { text-align:center; margin-bottom:6px; }
.header .company { font-weight:700; font-size:13px; letter-spacing:0.5px; }
.header .small { font-size:10px; }
.meta { margin-bottom:6px; font-size:11px; line-height:1.4; }
.items { width:100%; border-collapse:collapse; margin-bottom:6px; }
.items thead th { text-align:left; font-size:11px; padding-bottom:4px; }
.items tbody td { padding:3px 0; font-size:11px; }
.qty, .price, .total { text-align:right; min-width:16mm; }
.totals { margin-top:6px; font-size:11px; }
.totals .row { display:flex; justify-content:space-between; padding:2px 0; }
.footer { margin-top:8px; text-align:center; font-size:10px; }
@media print { .no-print{display:none;} .receipt{margin:0; padding:0;} }
</style>
</head>
<body>

<div class="receipt" id="receipt">
  <div class="header">
    <?php foreach ($company_lines as $i => $line): ?>
      <?php if ($i === 0): ?><div class="company"><?php echo htmlspecialchars($line); ?></div>
      <?php else: ?><div class="small"><?php echo htmlspecialchars($line); ?></div><?php endif; ?>
    <?php endforeach; ?>
    <div style="margin-top:6px;"><svg id="barcode"></svg></div>
  </div>

  <div class="meta">
    <div>Served By: <?php echo htmlspecialchars($servedBy); ?></div>
    <div>Table No: <?php echo htmlspecialchars($order->tableno); ?></div>
    <div>Location: <?php echo htmlspecialchars($branchName); ?></div>
    <div>Order No: <?php echo htmlspecialchars($orderNo); ?></div>
    <div>Time: <?php echo htmlspecialchars($dateTime); ?></div>
  </div>

  <table class="items">
    <thead><tr><th>ITEM</th><th style="text-align:right">QTY</th><th style="text-align:right">PRICE</th><th style="text-align:right">TOTAL</th></tr></thead>
    <tbody>
      <?php foreach ($items as $it): ?>
      <tr>
        <td><?php echo htmlspecialchars($it->itemname); ?></td>
        <td style="text-align:right"><?php echo (int)$it->quantity; ?></td>
        <td style="text-align:right"><?php echo fmt($it->price); ?></td>
        <td style="text-align:right"><?php echo fmt($it->total); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="totals">
    <?php $vat_base = $total*0.84; $vat_amount = $total*0.16; ?>
    <div class="row"><div>TOTAL (excl VAT): <?php echo fmt($vat_base); ?></div></div>
    <div class="row"><div>VAT (16%): <?php echo fmt($vat_amount); ?></div></div>
    <div class="row" style="font-weight:700; font-size:12px;"><div>TOTAL: <?php echo fmt($total); ?></div></div>
  </div>

  <div style="margin-top:6px; border-top:1px solid #000; border-bottom:1px dashed #000; padding:6px 0 20px;">
    <?php
      $q = "SELECT value FROM sys_config WHERE name='receiptfootnote' LIMIT 1";
      $r = mysql_query($q);
      if ($r && mysql_num_rows($r)) { $rw = mysql_fetch_object($r); echo '<div class="footer">'.htmlspecialchars($rw->value).'</div>'; }
    ?>
    <div class="footer">Developer: Gamil Tech - 0721716051</div>
  </div>
</div>

<script>
// ---------------------
// BARCODE
// ---------------------
JsBarcode("#barcode", "<?php echo addslashes($orderNo); ?>", {
  format: "CODE39",
  width: 1,
  height: 40,
  displayValue: true,
  fontSize: 12
});

// ---------------------
// PRINTING
// ---------------------
function getReceiptHTML(copyLabel) {
    var html = document.getElementById('receipt').outerHTML;
    if (copyLabel) {
        html += '<div style="text-align:center;font-size:11px;margin-top:6px;font-weight:bold;">' + copyLabel + '</div>';
    }
    return html;
}

function ensureQZ() {
    if (!qz.websocket.isActive()) {
        return qz.websocket.connect();
    }
    return Promise.resolve();
}

function doPrint(copyLabel) {
    ensureQZ().then(function() {
        var printerName = "<?php echo $printerNameJS; ?>";

        return qz.printers.find().then(function(printers) {
            if (!printers || printers.length === 0) {
                alert("No printers available.");
                return;
            }

            // fallback: first printer
            if (!printerName) {
                printerName = printers[0];
                console.warn("Using first detected printer:", printerName);
            }

            return actuallyPrint(printerName, copyLabel);
        });

    }).catch(function(err) {
        alert("Printing failed: " + err.message);
        console.error("QZ Print error:", err);
    });
}

function actuallyPrint(printerName, copyLabel) {
    var html = getReceiptHTML(copyLabel);

    var data = [
        { type: 'html', format: 'plain', data: html },
        { type: 'raw', format: 'plain', data: '\x1D\x56\x00' } // CUT
    ];

    var cfg = qz.configs.create(printerName);

    return qz.print(cfg, data);
}

window.onload = function() {
    doPrint("Customer Copy").then(function() {
        if (qz.websocket.isActive()) qz.websocket.disconnect();
        setTimeout(function() { window.close(); }, 1500);
    }).catch(function(err) {
        alert("Printing setup failed: " + err.message);
        console.error(err);
    });
};
</script>

</body>
</html>
