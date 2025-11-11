<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Demo</title>
  <link rel="stylesheet" href="../../../js/auto/jquery-ui.min.css" type="text/css" /> 
</head>
<body> 

	<form action='' method='post'>
		<p><label>Country:</label><input type='text' name='country' value='' id='auto'></p>
	</form>

<script type="text/javascript" src="../../../js/auto/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../../../js/auto/jquery-ui.min.js"></script>	
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$("#auto").autocomplete({
		source: "search.php",
		minLength: 1
	});				

});
</script>
</body>
</html>