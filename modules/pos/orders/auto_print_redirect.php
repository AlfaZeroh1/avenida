<?php
$doc = $obj->documentno;
$targetUrl = !empty($_SESSION['ismobile']) 
    ? "../../auth/users/logout.php"
    : "orderss.php";
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Printing…</title>
<script>
// open the print window
window.open('print_new.php?doc=<?php echo $doc; ?>',
            'printWindow',
            'width=250,height=300');

// after the print window opens, redirect the main window
setTimeout(function(){
    window.location.href = '<?php echo $targetUrl; ?>';
}, 800);   // enough time to open new print window
</script>
</head>
<body>
Printing… please wait.
</body>
</html>
