<?php
$pop=1;
$pops=1;
include "../../../head.php";
?>
<script type="text/javascript">
  var tbl;
  var iterator=0;

  $(document).ready(function() {
    tbl = $('#tbl').dataTable({"bPaginate": false,
        "bFilter": false,
        "bInfo": false});
        
//         $('#myLinkToConfirm').confirmModal();
       $('.warmth').confirmModal({
        confirmTitle     : 'Custom please confirm',
        confirmMessage   : 'Custom are you sure you want to perform this action ?',
        confirmOk        : 'Custom yes',
        confirmCancel    : 'Cutom cancel',
        confirmDirection : 'rtl',
        confirmStyle     : 'primary',
//         confirmCallback  : defaultCallback,
        confirmDismiss   : true,
        confirmAutoOpen  : false
    });
    
//     $('.kyeboard').keyboard({ layout: 'qwerty' });    

//     $('#tableno').keyboard();

  $('#num')
	.keyboard({
		layout : 'num',
		restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
		preventPaste : true,  // prevent ctrl-v and right click
		autoAccept : true
	})
	.addTyping();
	
  });
  
 
function setCategory(id){
 
 
  $.get( "tbl.php", {categoryid:id,type:1}, function(data){
    $("#tblpick").html(data);
    
  $('.nav-pills a[href="#pickitem"]').tab('show');
      
  });
  
}

function setLocation(id){
 
 $("#brancheid2").val(id);
 
  $.get( "tbl.php", {brancheid:id,type:2}, function(data){
    $("#catpick").html(data);
    $('.nav-pills a[href="#category"]').tab('show');
  });
}

function setShop(itemid, warmth,warmthdesc){//alert(warmth);
  var quantity = $("#"+itemid+"-"+warmthdesc).val();//console.log("Quantity: "+quantity);
//   alert("");
  var totals=parseFloat($("#total").text());
  var brancheid2 = $("#brancheid2").val();
  
//   console.log("tt: ",totals);
  
  $.post("setorder.php",{itemid:itemid, quantity:quantity, type:1, totals:totals, warmth:warmth,brancheid2:brancheid2}, function(data){
    
    var error = data.split("|");//console.log("HERE");
    
//     totals=parseFloat($("#total").text());
    olditemtotal=parseFloat(error[0]);
    newitemtotal=parseFloat(error[1]);
   
    var totalss=totals-olditemtotal+newitemtotal;//console.log("TT: "+totalss);
    
    $("#total").text(totalss);
    
  });
}

function delShop(itemid){
  $.post("setorder.php",{itemid:itemid,  type:1, action:2});
  tbl.fnDeleteRow(itemid);
}

function loadWarmthModal(itemid,quantity){
  $('#myModal').modal('show');
  $("#modalitemid").val(itemid);
}

function clickWarmthModal(warmth){
  $('#myModal').modal('hide');
  var itemid = $("#modalitemid").val();
  saveForm(itemid, 1, warmth);
}

function removeItem(str){
  
  alert(str);
  
}
  
function saveForm(itemid,quantity,warmth){     
          
    var brancheid2 = $("#brancheid2").val();
    $.post( "addorders_proc.php", { action2: "Add", itemid:itemid, quantity:quantity, memo:$("#memo").val(), type:'1', iterator:$("#iterator").val(), warmth:warmth, brancheid2:brancheid2}, function(data){
    
      error=data;
      
      var totals=parseFloat($("#total").text());
		
      var err = error.split("|");//console.log(err);
	
// 	if(parseFloat(err[0])==1){
// 	alert("");
// 	}else{
	  
	  var total = parseFloat(err[2]) * parseFloat(err[3]);
	  
	  totals+=total;
	  
	  $("#total").text(totals);
	  
	  var str = "";
	    
	  if(err[0]==0){
	    tbl.fnAddData( [	      
		      err[1],		
		      "<input type='text' id='"+err[4]+"-"+err[5]+"' onChange='setShop("+err[4]+",&quot;"+err[6]+"&quot;,&quot;"+err[5]+"&quot;)'  size='4' value="+err[2]+" >",
		      err[5],
		      total,
		      '<a href="javascript:;" onClick="removeItem('+err[4]+');"><img src="../trash.png" alt="delete" title="delete" /></a>'] );
	      
	      iterator++;
	      
	      //add keyboard feature
	      $("#"+err[4]+"-"+err[5]).keyboard({
		    layout : 'num',
		    restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
		    preventPaste : true,  // prevent ctrl-v and right click
		    autoAccept : true
	    })
	    .addTyping();
	      
	    $("#iterator").val(iterator);
	  }else{
	    quantity=parseFloat($("#"+err[4]+"-"+err[5]).val());
	    quantity++;
	    $("#"+err[4]+"-"+err[5]).val(quantity);
	  }
	
//       }     
      
    } );
    return true;

}


function Clickheretoprint()
{ 
	var msg;
	msg="Do you want to print BILL?";
// 	var ans=confirm(msg);
	if(true)
	{
 		<?php $_SESSION['obj']=$obj; ?>
		
		var orderprint = window.open("print.php?doc=<?php echo $obj->orderno; ?>&copys=1","_blank", "height=400, width=550, status=yes, toolbar=no, menubar=no, location=no,addressbar=no"); 
		
		
	}
}

function setHidden(str){
  
  $("#printed").val(str);
  
  printDoc(str);
}

function cancelOrder(){
  location.replace("../../auth/users/logout.php");
}

function printDoc(id){
  if(id==1){
    var corderprint = window.open("print.php?doc=<?php echo $obj->orderno; ?>&copys=2","_blank", "height=400, width=550, status=yes, toolbar=no, menubar=no, location=no,addressbar=no"); 
  }else if(id==2){
    <?php if($obj->brancheid2==30){ ?>
    var captainorder = window.open("print.php?doc=<?php echo $obj->orderno; ?>&copys=3","_blank", "height=400, width=550, status=yes, toolbar=no, menubar=no, location=no,addressbar=no"); 
    <?php }else{ ?>
    location.replace("../../auth/users/logout.php");
    <?php } ?>
  }
  else if(id==3){
    location.replace("../../auth/users/logout.php");
  }
  
}
</script>

  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
    
    .table {
	margin-bottom: 0px;
	max-width: 100%;
	width: ;
    }
    

.btns {
    -moz-user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    font-size: 18px;
    font-weight: 400;
    line-height: 1.42857;
    margin-bottom: 0;
    padding: 6px 12px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    background-color: #f0ad4e;
    font-weight:bold;
    font-size:100%;
    min-width:98%;
    max-width:98%;
    transition-duration: 0.4s;
}
    
::-webkit-scrollbar {
    width: 2em;
    height: 2em
}
::-webkit-scrollbar-button {
    background: #ccc
}
::-webkit-scrollbar-track-piece {
    background: #888
}
::-webkit-scrollbar-thumb {
    background: #eee
}

a{
  color:black;
}
  </style>
</head>
<body>

<form action="addorders_proc.php" method="post">
<div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>COLD/WARM</strong></h4>
      </div>
      <div class="modal-body">
        <p>
        <input type="hidden" id="modalitemid"/>
        <button id="warmth" onclick="clickWarmthModal(2);" type="button" style="height:60px;font-size:22px;" class="btn btn-primary">COLD</button>
        <button id="warmth" onclick="clickWarmthModal(1);" type="button" style="height:60px;font-size:22px;" class="btn btn-warning">WARM</button></p>
        
        <p>
        <button id="warmth" onclick="clickWarmthModal(3);" type="button" style="height:60px;font-size:22px;" class="btn btn-info">WETFRY</button>
        <button id="warmth" onclick="clickWarmthModal(4);" type="button" style="height:60px;font-size:22px;" class="btn btn-warning">DRYFRY</button>
        <button id="warmth" onclick="clickWarmthModal(5);" type="button" style="height:60px;font-size:22px;" class="btn btn-primary">BOILED</button>
        <button id="warmth" onclick="clickWarmthModal(6);" type="button" style="height:60px;font-size:22px;" class="btn btn-warning">CHOMA</button>
        </p>
      </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="col-sm-8"> 
      
<div id="tabs" class="container" style="width:95%;">	
  <ul id="tabss" class="nav nav-pills">
	<li class="active"><a style="font-weight:bold; font-size:20px;" href="#sellingpoints" data-toggle="tab">SELLING POINTS</a></li>
	<li><a  href="#category" data-toggle="tab" style="font-weight:bold; font-size:20px;">CATEGORY</a></li>
	<li><a href="#pickitem" data-toggle="tab" style="font-weight:bold; font-size:20px;">ITEMS</a></li>
	<li><a href="orderss.php"  style="font-weight:bold; font-size:20px;">MY ORDERS</a></li>
  </ul>

  <div class="tab-content clearfix">
	<div class="tab-pane active" id="sellingpoints">
	<div class="col-sm-4"> 
	  <div class="panel panel-success">
	    <div class="panel-heading">SELLING POINTS</div>
	    <div class="panel-body">
	    
	    <input type="hidden" name="printed" id="printed" value="<?php echo $obj->printed; ?>"/>
	    
	    <input type="hidden" name="brancheid2" id="brancheid2" value="<?php echo $obj->brancheid2; ?>"/>
	    
	    <table class="table">
	    <?php
		    
	    $branches = new Branches();
	    $fields=" id, name ";
	    $join="";
	    $groupby="";
	    $having="";
	    $where=" where type='Center' and (visible='global' or id='".$_SESSION['brancheid']."') " ;
	    $orderby=" order by name ";
	    $branches->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	    $i=0;
	    while($rw=mysql_fetch_object($branches->result)){
	    
	    $style="";
	    
	    if($obj->brancheid2==$rw->id){
	      $style='style="background-color:#fcf8e3;"';
	    }
	    
	    $tbls=4;
	    if($detect->isMobile())$tbls=1;
	    ?>
	      <?php if($i%$tbls==0){ ?>
	      <tr>
	      <?php } ?>
	      <td <?php echo $style; ?>>
	      <a href="javascript:;" class="btns"  <?php if(empty($open)){?> onClick="return alert('NO ACTIVE SHIFT!');" <?php }else{ ?> onClick="setLocation('<?php echo $rw->id; ?>');" <?php } ?>>
		<img class="icon icons8-Dossier" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAA+ElEQVRoge3ZMQ6CMBQGYBPvwcwBYLUYTCRuDVeC2bjriIkbg9WNjcF4C+QI7s8JY9RgJbS0+v/J29+XvP4hYTRCEASxIpP4uGBc1IwLUjx1wEXUO4BxcdGwfDOVCoCu5YlxQQAAAIACgBdm5LgJOW5CfpjZAciL8pwXJT3OanMgx02tAZyeAcv1K6BrtJ6Qfz+hlLzZ1j5A2zQZ765SA0AXQFsLGXtCsi1kMuCrFjL6hGRayGiAzCM27oR+CoBvoYEAUi1kLKDJpxayAqBzAHgHQAsNBEALGQOw/hEDAMCfA+z+wRFwETEuKh3LT+P9vHcAgiCIktwAoRPhY6ELy7kAAAAASUVORK5CYII=" width="48" height="48">
		<br/>
		<span style="font-size:30px;"><?php echo strtoupper($rw->name); ?></span>
	      </a>
	      </td>
	    <?php
	      $i++;
	    }
	    ?>
	    </table>
	    </div>
        
      </div>
    </div>
  
	</div>
	<div class="tab-pane" id="category">
          <div class="panel panel-success">
        <div class="panel-heading">CATEGORY</div>
        <div class="panel-body" id="catpick">
        <table class="table">
        <?php
        $items = new Categorys();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id in (select categoryid from sys_branchcategorys where brancheid='$obj->brancheid') " ;
	$orderby=" order by name ";
	$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$i=0;
	while($rw=mysql_fetch_object($items->result)){
	?>
	  <?php if($i%4==0){ ?>
	  <tr>
	  <?php } ?>
	  <td>
	  <a href="javascript:;" onClick="setCategory('<?php echo $rw->id; ?>');">
	    <img class="icon icons8-Dossier" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAA+ElEQVRoge3ZMQ6CMBQGYBPvwcwBYLUYTCRuDVeC2bjriIkbg9WNjcF4C+QI7s8JY9RgJbS0+v/J29+XvP4hYTRCEASxIpP4uGBc1IwLUjx1wEXUO4BxcdGwfDOVCoCu5YlxQQAAAIACgBdm5LgJOW5CfpjZAciL8pwXJT3OanMgx02tAZyeAcv1K6BrtJ6Qfz+hlLzZ1j5A2zQZ765SA0AXQFsLGXtCsi1kMuCrFjL6hGRayGiAzCM27oR+CoBvoYEAUi1kLKDJpxayAqBzAHgHQAsNBEALGQOw/hEDAMCfA+z+wRFwETEuKh3LT+P9vHcAgiCIktwAoRPhY6ELy7kAAAAASUVORK5CYII=" width="48" height="48">
	    <br/>
	    <?php echo strtoupper($rw->name); ?>
	  </a>
	  </td>
	<?php
	  $i++;
	}
	?>
	</table>
        </div>
        
      </div>
      
	</div>
	<div class="tab-pane" id="pickitem" style="height:650px;overflow:scroll;">
          <div class="panel panel-primary">
        <div class="panel-heading">Pick ITEM</div>
        <div class="panel-body" id="tblpick">
        
        </div>
        
      </div>
	</div>
        <div class="tab-pane" id="myorders">
	  <div class="panel panel-warning">
<div class="panel-heading">MY ORDERS</div>
<div class="panel-body">

<div id="tabs" class="container" style="width:95%;">	
  <ul id="tabss" class="nav nav-pills">
	<?php
	//get distinct selling points
	$query=" select distinct sys_branches.name from sys_branches left join pos_orders on pos_orders.brancheid2=sys_branches.id where pos_orders.createdby='".$_SESSION['userid']."'";
	$rs = mysql_query($query);
	while($row=mysql_fetch_object($rs)){
	?>
	<li class="active"><a style="font-weight:bold; font-size:14px;" href="#id<?php echo $row->id; ?>" data-toggle="tab"><?php echo $row->name; ?></a></li>
	<?php
	}
	?>
  </ul>
  <div class="tab-content clearfix">
	
	<?php
	//get distinct selling points
	$query=" select distinct sys_branches.id from sys_branches left join pos_orders on pos_orders.brancheid2=sys_branches.id where pos_orders.createdby='".$_SESSION['userid']."'";
	$rs = mysql_query($query);
	while($row=mysql_fetch_object($rs)){
	?>
	
	<div class="tab-pane active" id="id<?php echo $row->id; ?>">


<table class="table" style="padding:2px;">
  <thead>
    <tr>
<!--       <th>&nbsp;</th> -->
<!--       <th>No</th> -->
      <th>Table</th>
      <th>Item</th>
      <th>Qnt</th>
      <th>Amnt</th>
      <th>PD</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php
    
    //get logged in person team role
    
    $orders = new Orders();
    $fields=" pos_orders.id, pos_orders.orderno,pos_orders.tableno, inv_items.name itemname, sum(pos_orderdetails.quantity) quantity, pos_orders.remarks, sum(pos_orderdetails.quantity*pos_orderdetails.price) amount, auth_users.username, pos_orders.status";
    $join=" left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id left join auth_users on auth_users.id=pos_orders.createdby left join inv_items on inv_items.id=pos_orderdetails.itemid ";
    $groupby=" group by pos_orderdetails.itemid ";
    $having="";
    $where=" where pos_orders.brancheid2='$row->id' and pos_orders.shiftid='$obj->shiftid' and pos_orders.status=1 ";
//     $where=" where pos_orders.orderedon=date(Now()) and pos_orders.status<=2 and pos_orders.brancheid2='$row->id' ";
//     $where=" case when pos_teamroles.type='Waiter' then where pos_orders.createdby='".$_SESSION['userid']."' else where pos_orders.shiftif='$obj->shiftid' end " ;
    if($obj->teamroletype=='Supervisor'){
      $where.=" and pos_orders.brancheid='$obj->brancheid' ";
    }else{
      $where.=" and pos_orders.createdby='".$_SESSION['userid']."' ";
    }
    
    $orderby=" order by pos_orders.id desc ";
    $orders->retrieve($fields, $join, $where, $having, $groupby, $orderby);
    
    $torder=0;
    $tpaid=0;
    $tbalance=0;
    
    while($rw=mysql_fetch_object($orders->result)){
    
    $query="select case when sum(pos_orderpayments.amount) is null then 0 else sum(pos_orderpayments.amount) end paid from pos_orderpayments where orderid='$rw->id' ";
    $w=mysql_fetch_object(mysql_query($query));
    
    $rw->paid=$w->paid;
    
    $balance = $rw->amount-$rw->paid;
    
    $torder+=$rw->amount;
    $tpaid+=$rw->paid;
    $tbalance+=$balance;
    
    if($balance<=0)
      continue;
		
    $color="";
    if($balance>0 and $rw->paid>0){
      $color="red";
    }
    
    if($balance<=0){
      $color="green";
    }
    
    if($rw->status==2)
      $color="blue";
    
    ?>
      <tr style="color:<?php echo $color; ?>">
<!-- 	<td><a href="addorders_proc.php?orderno=<?php echo $rw->orderno; ?>"><?php echo strtoupper($rw->username); ?></a></td> -->
<!-- 	<td><?php echo $rw->orderno; ?></td> -->
	<td><?php echo $rw->tableno; ?></td>
	<td><?php echo $rw->itemname; ?></td>
	<td><?php echo $rw->quantity; ?></td>
	<td align="right"><a href="addorders_proc.php?orderno=<?php echo $rw->orderno; ?>"><?php echo formatNumber($rw->amount); ?></a></td>
	<td><?php echo $rw->paid; ?></td>
	<td>
	<?php if($balance>0 and $rw->status<2){?>
<!-- 	  <a href="addorders_proc.php?orderno=<?php echo $rw->orderno; ?>">Cancel</a> -->
	<?php } ?>
	</td>
      </tr>
    <?php
    }
    ?>
  </tbody>
  <tfoot>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
<!--       <th>&nbsp;</th> -->
      <th>&nbsp;</th>
      <th style="text-align:right;"><?php echo formatNumber($torder);?></th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
    </tr>
  </tfoot>
 
</table>

    </div>
	<?php
	}
	?>
  </div>
</div>
</div>
        </div>
  </div>
</div>
      
      
      
    </div>
  
    
</div>

 
    
 <div class="col-sm-4">
    <table class="table btn-danger" style="font-size:18px;font-weight:bold;">
  <tbody>
    <tr style="color:red;font-weight:bold;font-size:18px;">
      <td colspan='4' align="center" ><?php echo $obj->branchename; ?> - <?php echo $_SESSION['employeename'];?>
	<input type="hidden" name="brancheid" id="brancheid" value="<?php echo $obj->brancheid; ?>"/>
	<input type="hidden" name="orderedon" id="orderedon" value="<?php echo $obj->orderedon; ?>"/>
      </td>
    </tr>
    <tr>
      <td align="right">Table No:</td>
      <td>
<!--       <input id="text" size="5" class="keyboard" required type="text" placeholder=" Table No..."> -->
      <input type="text" name="tableno" required has-error id="num" size="5"  value="<?php echo $obj->tableno; ?>">
	  <input type="hidden" name="shiftid" id="shiftid" value="<?php echo $obj->shiftid; ?>"/>
	  <input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"/>
	  <input type="hidden" name="orderno" id="orderno" value="<?php echo $obj->orderno; ?>"/>
	  <input type="hidden" name="teamroletype" id="teamroletype" value="<?php echo $obj->teamroletype; ?>"/>
      </td>
      <?php if(!empty($obj->retrieve)){ ?>
      <td align="right">Reason</td>
      <td><textarea name="remarks" required><?php echo $obj->remarks; ?></textarea></td>
      <?php } ?>
    </tr>
  </tbody>
    </table>
      <div class="panel panel-danger">
        <div class="panel-heading">ORDER </div>
        
        <div class="panel-body">
        
        <table id='tbl' class="table" width="100%" style="font-size:18px;font-weight:bold;">
	  <thead>
	    <th>Item<input type="hidden" name="iterator" id="iterator" value="<?php echo $obj->iterator; ?>"/></th>
	    <th>Qnt</th>
	    <th>Warmth</th>
	    <th id="price">Price</th>
	    <th>&nbsp;</th>
	  </thead>
	  <tbody>
	  <?php
	  $i=0;
	  $shop = $_SESSION['shop'];
	  $total=0;
	  while($i<count($shop)){
	  $total+=$shop[$i]['total'];
	  ?>
	    <tr>
	      <td><?php echo $shop[$i]['itemname']; ?></td>
	      <td><input type="text" value="<?php echo $shop[$i]['quantity']; ?>" onChange="saveForm('<?php echo $shop[$i]['itemid']; ?>','1','');" id="num" class="alignRight"/></td>
	      <td>&nbsp;</td>
	      <td style="text-align:right;"><?php echo $shop[$i]['total']; ?></td>
	      <td><a href="javascript:;" ><img class="icon icons8-Cancel" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAADCElEQVRoge2Zz2sTQRTHR+yhoOL/oOhBoYp137T0st03iXgQROnJ4skiqKTtodaTrRe1nup/IdSC9WzFetda8Af+AXqwTUnNW7PJJnkeki0mTcjMJpsY2C+82zDz+c68NzO7I0SsWLFiCSGEOy6HCeG+68hVQtgihDQp2CUFu4SQJoQt15GrpGDOdUYu9JpXCCHEL9s+SgpmyZHfCIEN4ys5coaTQ0e6Ds62PUCOnCGEnRDg9bGdRSvFtj3QFfjsuHW2miLtgtfHZhblmWjhlbxOCH8igA/CzSrrWiTwpOAmIRQjhA+iSGhNdhTeRbhKCH4X4IPwXce60hF4SljnCSHXRfggcjQO59qCZ9seIITNHsBXw/rAExOHw88+yunewVcii/JuKPhdNXycEDJaAyVGODc9pQ2Vm55iSozotk9vj40dM5/9ykHVeoDkKPvv3zKXy+wtP23ZPr+8xFwus7+xzpQc1VwFK2UEz0IcIoTvWvAb67yvFiYC+ED+uze6Jr6YzT7KIa1USE0xl0pco1KJvccPD7T1niw0bJtL3dKtBf1TmhTM6eaz9+gBs+/XgpXLnF9eajrzlen32Vuc1y9oBbPaBlyEFe2OW5joCDwCE8oXBikEn806B/YW5w+aqBppHx6YELZMDKRDDNDcRPvwTAg7JgbyIQepmKgv1mrBtgHPhJDvioGGOV/JpZrCDhFe5CnUHL62sEMa2DYxYPzFlX/+7CB8schcKnbKxEdtA6bbaEP4asE2LOxQJky2Ud17UAv4oE0nTGQduGeQQn1+laiYgE8tO1aSC2srtTO/0HyrrF+JwqsVJiU7m//7BnTTSEkuvH7ZEr7eRGFNG978Oi2EEGzbg4TwU8tEpB801g+27UFjA0IIkUXrji5UVOEi3A4FX12F/v6oF0KIjDN8khD2emAg4ynrRFvwgfr6x1YgQmuySyYKhNaNjsIHcp2LlyNOpwwpuBQJfKDfCKdJ55Azj829hDwVKXygvn7g+Fd9+8TUSA0f+SqgZfpfH/lixYrVe/0FMnjxXWl0ifAAAAAASUVORK5CYII=" width="48" height="48"></a></td>
	    </tr>
	  <?
	  $i++;
	  }
	  ?>
	  </tbody>
	  
	  <tfoot>
	    <th>Total</th>
	    <th>&nbsp;</th>
	    <th>&nbsp;</th>
	    <th style="text-align:right;"><div id="total"><?php echo $total; ?></div></th>
	    <?php //if(empty($obj->retrieve)){?>
	    <th>&nbsp;</th>
	    <?php //} ?>
	  </tfoot>
	  
        </table>
        
        </div>
        
        <div class="panel-footer" style="text-align:center;">
        <div style="float:left;">
        <?php if(empty($obj->retrieve)){?>
	  <input type="submit" style="font-size:24px;" class="btn btn-warning" name="action" id="action" value="<?php echo $obj->action; ?>"/>
        <?php }else{ 
	  //Authorization.
	  $auth->roleid="8664";//View
	  $auth->levelid=$_SESSION['level'];

	  if(existsRule($auth)){
	  ?>
	    <input type="submit" style="font-size:24px;" class="btn btn-danger" name="action" id="action" value="CANCEL"/>&nbsp;
	    <input type="submit" style="font-size:24px;" class="btn btn-danger" name="action" id="action" value="PRINT"/>&nbsp;
<!-- 	    <a href="javascript:;" style="font-size:24px;" onClick="Clickheretoprint();" class="btn btn-default">Print</a> -->
	  <?php 
	  }
        }
        ?>
        </div>
        <div style="float:left;min-width:40px;">&nbsp;
        </div>
        <div style="float:left;">
	  <input type="button" style="font-size:24px;" class="btn btn-danger" onClick="cancelOrder();" name="action" id="action" value="CANCEL"/>
        </div>
        </div>
        
      </div>
    </div>
    
    <div class="col-sm-5">   
</div>


        
   
  </form>  

</div>

<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
	
	if($open==0)
	  redirect("../../auth/users/logout.php");
}
if($saved=="Yes"){
	?>
<script type="text/javascript">//Clickheretoprint();

</script>
<?php
//   redirect("../../auth/users/logout.php");
}

?>


