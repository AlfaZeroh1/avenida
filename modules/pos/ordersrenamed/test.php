<?php
session_start();
require  '../../../autoload.php';
require_once "../../../DB.php";
require_once "../../../lib.php";
require_once '../../sys/config/Config_class.php';
require_once("../../pos/orders/Orders_class.php");
require_once("../../pos/orderdetails/Orderdetails_class.php");

$db = new DB();

$obj = (object)$_GET;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
  use Mike42\Escpos\Printer;
  
// printOrder($obj);

function printOrder($obj,$copy,$bool=false){

//add session_start
$ipaddresss=$_SERVER['REMOTE_ADDR'];
$query="update sys_tracksessions set status=1, ipaddress='$ipaddresss' ";
mysql_query($query);

$_SESSION['print']=1;
  if($obj->combined){
    $i=0;
    $ordernos="";
    $shop = $_SESSION['shpordernos'];
    while($i<count($shop)){
      $ordernos.=$shop[$i].",";
      $i++;
    }
  }

  $ordernos=substr($ordernos,0,-1);

  


  try {
	  //get order
	  $orders = new Orders();
	  $fields="pos_orders.*, sys_branchess.name branchename, sys_branchess.printer, sys_branchess.printer2, group_concat(pos_orders.id) id, group_concat(pos_orders.orderno) orderno, sys_branchess.printer2name ";
	  $join=" left join sys_branches on sys_branches.id=pos_orders.brancheid left join sys_branches sys_branchess on sys_branchess.id=pos_orders.brancheid2 ";
	  $having="";
	  $groupby=" ";
	  $orderby=" ";
	  if(empty($obj->combined))
	    $where=" where orderno='$obj->doc' ";
	  else
	    $where=" where orderno in($ordernos) ";
	  $orders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $orders = $orders->fetchObject;
	  
	  if($orders->brancheid2!=30){
// 	  if(true){
	    if($copy==1)
	      $title="ORDER\n";
	    if($copy==2)
	      $title="CUSTOMER COPY\n";
	      
	    $ipaddress = $orders->printer; //"smb://GAZEBO/E-pos 80mm Thermal Printer";
	  }else{
	    
	    if($copy==1){
	      $title="KITCHEN ORDER\n";
	      $ipaddress = $orders->printer;
	    }
	    
	    if($copy==2){
	      $title="CUSTOMER COPY\n";
	      $ipaddress = $orders->printer;
	    }
	    
	    if($copy==3){
	      $title="CAPTAIN ORDER\n";
	      $ipaddress = $orders->printer2;
	    }
	  }
	  	  	 
	  $ipaddress = "smb:".$ipaddress;
	  
	  $connector = new WindowsPrintConnector($ipaddress);
	  $printer = new Printer($connector);
	  
	  
	  if($bool){
	    $titlet="copy ".$_SESSION['employeename'];
	    $titlet=str_pad($titlet,42,'-',STR_PAD_BOTH);
	    $printer -> text($titlet."\n");
	    
	    $printer->feed();
	  }

	  $config = new Config();
	  $fields=" * ";
	  $join="  ";
	  $where=" where id in(1,2,9) ";
	  $config->retrieve($fields, $join, $where, $having, $groupby, $orderby);

	  while($con=mysql_fetch_object($config->result)){
		  if($con->id==1){
		    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
		    $len=20; 
		    
		    $val = substr($con->value,0,15);
		    
		    $value=str_pad($val,$len,' ',STR_PAD_BOTH);
		  
		    $printer -> text($value."\n");
		    
		    $val = substr($con->value,15);
		    
		    $value=str_pad($val,$len,' ',STR_PAD_BOTH);
		  
		    $printer -> text($value."\n");
		    
		  }else{
		  
		    $len=30;
		    $value=str_pad($con->value,$len,' ',STR_PAD_BOTH);
		  
		    $printer -> text($value."\n");
		  
		  }
		  
		  $printer -> selectPrintMode();
	  }
	  
	  $printer -> setBarcodeHeight(80);
	  $printer -> barcode("9876", Printer::BARCODE_CODE39);
	  
	  $printer->feed();
	  $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);	  
	  
	  $len=20;
	  $value=str_pad($title,$len,' ',STR_PAD_BOTH);
		    
	  $printer -> text($title);
	  $printer -> selectPrintMode();
	  	  
	  $query="select concat(trim(hrm_employees.firstname),' ',concat(trim(hrm_employees.middlename),' ',trim(hrm_employees.lastname))) employeename from hrm_employees left join auth_users on hrm_employees.id=auth_users.employeeid where auth_users.id='$orders->createdby'";
	  $employee = mysql_fetch_object(mysql_query($query));

	  $printer -> feed();
	  $printer -> text(str_pad("SERVED By:",14,' ').$employee->employeename."\n");
	  $printer -> text(str_pad("TABLE NO:",14,' ').$orders->tableno."\n");
	  $printer -> text(str_pad("LOCATION:",14,' ').$orders->branchename."\n");
	  $printer -> text(str_pad("ORDER NO:",14,' ').$orders->orderno."\n");
	  $printer -> text(str_pad("Time:",14,' ').date("d/m/Y H:i:s")."\n");
	  $printer -> feed();
	  
	  $titles = new item("ITEM", "QNT","PRICE","TOTAL");
	  $printer -> text($titles);
	  
	  $str=str_pad('-',42,'-');
	  $str=$str."\n";
	  $printer -> text($str);
	  
	  $orderdetails = new Orderdetails();
	  $fields="sum(pos_orderdetails.quantity) quantity, inv_items.name itemname, pos_orderdetails.price, sum(pos_orderdetails.quantity*pos_orderdetails.price) total, inv_items.warmth war, case when pos_orderdetails.warmth=1 then 'Warm' when pos_orderdetails.warmth=2 then 'Cold' else '' end warm";
	  $join=" left join inv_items on pos_orderdetails.itemid=inv_items.id ";
	  $having="";
	  $groupby=" group by pos_orderdetails.itemid, price, pos_orderdetails.warmth ";
	  $orderby=" ";
	  $where=" where orderid in($orders->id) ";
	  $orderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $total=0;
	  
	  $items = array();
	  while($row=mysql_fetch_object($orderdetails->result)){
	    
	    if(!empty($row->warm)){
	      $row->itemname.=" -".$row->warm;
	    }
	    
	    $item = new item($row->itemname, $row->quantity."X",formatNumberP($row->price),formatNumberP($row->total));
	    $items[]=$item;
	    
	    $total+=($row->price*$row->quantity);
	  }
	  
	  foreach ($items as $item) {
	      $printer -> text($item);
	  }
	  
	  $printer->feed();
	  
	  $taxable = ($total/1.16);
	  $vat = ($total/1.16)*.16;
	  
	  $printer -> setEmphasis(true);
	  $titles = new item("AMOUNT", "","",formatNumber($taxable));
	  $printer -> text($titles);
	  
	  $printer -> setEmphasis(FALSE);
	  $titles = new item("VAT(16%)", "","",formatNumber($vat));
	  $printer -> text($titles);
	  
	  $printer -> setEmphasis(true);
	  $titles = new item("TOTAL", "","",formatNumber($total));
	  $printer -> text($titles);
	  
	  $printer -> setEmphasis();
	  $printer->feed();
	  
	  $str=str_pad('-',42,'-');
	  $str=$str."\n";
	  $printer -> text($str);
	  
	  $query="select * from sys_config where name='receiptfootnote'";
	  $rw = mysql_fetch_object(mysql_query($query));
	  $value=$rw->value;
	  $value=str_pad($value,42,' ',STR_PAD_BOTH);
// 	  $value=str_pad($value,42);
	  $printer -> text($value."\n");
	  
	  $printer -> text($str);
		  
	  $printer -> text("Developer: www.wisedigits.com\n");
		  
//	  $printer->feed();
	  
	  $printer->setEmphasis();
	  $printer -> cut();	  
// 	  logging("PRINTING");
// 	  echo "PRINTED";
	  /* Close printer */
	  $printer -> close();
	  
	  logging($orders->orderno." : ".$copy." => ".$obj->brancheid2." = ".date("H:i:s")." == ".$_SESSION['employeename']." == ".$_SESSION['userid']." :".$ipaddress);
	  
  } catch(Exception $e) {logging($orders->orderno.": $title ".$e -> getMessage());
	  echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
  }
  
//   $printer -> close();
  
  $copy++;
  
  
  if($copy<3 and $obj->brancheid2!=30)
    printOrder($obj,$copy,$bool);
    
  elseif($copy<4 and $obj->brancheid2==30)
    printOrder($obj,$copy,$bool);
    
    $_SESSION['print']="";
    $query="update sys_tracksessions set status=0, ipaddress='$ipaddresss' ";
    mysql_query($query);
}

class Item
{
    private $itemname;
    private $quantity;
    private $price;
    private $total;

    public function __construct($itemname = '', $quantity = '', $price="", $total="")
    {	
        $this -> itemname = $itemname;
        $this -> quantity = $quantity;
        $this -> price = $price;
        $this -> total = $total;
    }
    
    public function __toString()
    {
	$itemname = $this->itemname;
	$itemname1=substr($itemname,0,20);
	$itemname2=substr($itemname,21);
	
	$itemname = $itemname1;
	
	if(!empty($itemname2))
	  $itemname.="\n".str_pad($itemname2, 21);
	
        $rightCols = 10;
        $leftCols = 10;
        
        $left = str_pad($itemname, 21) ;
        $left .= str_pad($this -> quantity, 5) ;
        $left .= str_pad($this -> price, 5) ;
        
        $right = str_pad( $this -> total, $rightCols, ' ', STR_PAD_LEFT);
//         echo strlen($left.$right);
        return "$left$right\n";
    }
}
?>
