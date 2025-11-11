<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../plots/Plots_class.php");
require_once("../houses/Houses_class.php");
/*require_once '../housetenants/Housetenants_class.php';*/
require_once("../../auth/rules/Rules_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
$pid = $_GET['pid'];
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Houses</title>
<script language="javascript" type="text/javascript">
var newwindow;
function poptastic(url,h,w)
{
	var ht=h;
	var wd=w;
	newwindow=window.open(url,'name','height='+ht+',width='+wd+',scrollbars=yes,left=250,top=80');
	if (window.focus) {newwindow.focus()}
}

function placeCursorOnPageLoad()
{
	if(document.stores)
		showUser();
	document.cashsales.itemname.focus();
		
}
</script>
<style type="text/css" media="all">
.cb{clear:both;}
.whatsNew {
	margin: 25px;
	padding: 10px;
	background: #ffffff;
	border: 1px solid #cccccc;
	border-radius: 10px;
	-webkit-box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
	-moz-box-shadow:    0px 0px 8px rgba(0,0,0,0.3);
	box-shadow:         0px 0px 8px rgba(0,0,0,0.3);
}

.whatsNew h2 {
	margin: 10px 20px;
	line-height: 16px;
	color: #015361;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 14px;
	font-style: italic;
}
.whatsNew a {
	line-height: 12px;
	color: #f00;
	font-family: 'tahoma';
	font-weight:bold;

}
.whatsNew p {
	margin-left:20px;
	line-height: 12px;
	color: #363634;
	font-family: 'tahoma';
	font-size:11px;
}
.make_info_wrapper{
	margin: 0;
	padding: 0;
	float: left;
	/*width: 50%;*/
	min-height: 240px;
	clear: right;
}

.info_wrapper{
	margin: 10px 20px;
}

.make_wrapper {
	display: inline-block;
	margin-top: 20px;
	padding-bottom: 5px;
	border-bottom: 1px solid #50281F;
	font-family:'Century Gothic';
	font-size: 14px;
}
.bt{	color: #222;
text-shadow: 0px 2px 3px #555;}
.make_wrapper .make_header {
	padding: 5px;
	float: left;
	/*width: 50px;*/
	color: #FFFFFF;
	background-color: #6eacf8;
}

.make_wrapper .make_title {
	padding: 5px;
	float: left;
	width: auto;
	font-size: 14px;
}

.header_wrapper {
	padding: 5px 0;
}

.header_wrapper .header_row {
	margin-right: 3px;
	padding: 5px;
	float: left;
	width:75px;
	color: #FFFFFF;
	background-color: #6eacf8;
	font-family:'Century Gothic';
	font-size:12px;
}

.data_wrapper {
	margin: 0;
	padding: 0;
}

.data_wrapper .data_row {
	padding: 4px;
	float: left;
	width: 75px;
	margin-right: 3px;
	font-family:'Arial';
	font-size:12px;
}
</style>

</head>

<body>
<h2>Property Vacant Houses Info</h2>
<a class="bt" href="vacant.php">Back</a>
<a class="bt" onClick="window.top.hidePopWin(true)" href="tenants.php">Cancel</a>
                   <div class="make_info_wrapper">
                                    <div class="make_wrapper">
                                    <div class="make_header">Property:</div>
 <?php
$plots=new Plots();

		$i=0;
		$fields="*";
		$join="";
		$having="";
		$groupby=" ";
		$orderby="";
		$where="where id=$pid";
		$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plots->result;
		while($row=mysql_fetch_object($res)){
		$i++;
?>
                                        
                                      <div class="make_title"><?php echo $row->name; ?></div>
                                      <? }?>
                                        <div class="cb"></div>
                                    </div>
                                    <div class="header_wrapper">
                                        <div class="header_row">Hse No:</div>
                                        <div class="header_row">Description:</div>
                                        <div class="header_row">Floor:</div>
                                        <div class="header_row">Rent:</div>
                                        <div class="header_row">Status:</div>
                                        <div class="header_row">Action:</div>
                                        <div class="cb"></div>
                                    </div>
<?php
$plots=new Houses();

		$i=0;
		$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_plots.name as plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor as flr, em_houses.elecaccno, em_houses.wateraccno, em_hsedescriptions.name as hsedescriptionid, em_houses.deposit, em_houses.vatable, em_housestatuss.name as housestatusid, em_rentalstatuss.name as rentalstatusid, em_houses.remarks";
		$join="left join em_plots on em_houses.plotid=em_plots.id  left join em_hsedescriptions on em_houses.hsedescriptionid=em_hsedescriptions.id  left join em_housestatuss on em_houses.housestatusid=em_housestatuss.id  left join em_rentalstatuss on em_houses.rentalstatusid=em_rentalstatuss.id ";
		$having="";
		$groupby=" ";
		$orderby="";
		$where=" where plotid=$pid and rentalstatusid=2 ";
		$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plots->result;
		while($row=mysql_fetch_object($res)){
		$i++;
				?>

                                               <div class="data_wrapper">
                                                <div class="data_row"><?php echo $row->hseno; ?></div>
                                                <div class="data_row"><?php echo $row->hsedescriptionid; ?></div>
                                                <div class="data_row"><?php echo $row->flr; ?></div>
                                                <div class="data_row"><?php echo $row->amount; ?></div>                                                <div class="data_row"><?php echo $row->housestatusid; ?></div>
                                                <div class="data_row"><a onClick="window.top.hidePopWin(true)" href="javascript:poptastic('../houses/addhouses_proc.php?id=<?php echo $row->id; ?>&tenantid=<?php echo $_GET['tenantid'];?>#tabs-2',700,1020);">assign</a></div>
                                                <div class="cb"></div>
                                            </div>
<?php }?>

                        <div class="info_wrapper">


                            	</div><!-- make_info_wrapper -->

                        <div class="cb">&nbsp;</div>
                        </div><!-- info_wrapper -->
                        <div class="cb">&nbsp;</div>
					</div><!-- whatsNew -->


</body>
</html>