<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/invoices/Invoices_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/crm/customers/Customers_class.php");
require_once("../../../modules/crm/agents/Agents_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/pos/saletypes/Saletypes_class.php");
require_once("../../../modules/pos/invoiceconsumables/Invoiceconsumables_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Invoices";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8728";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromsoldon=date('Y-m-d');
	$obj->tosoldon=date('Y-m-d');
	
// 	$obj->grcustomerid=1;
	$obj->grdocumentno=1;
// 	$obj->grinvoiceno=1;
}

$rptwhere='';
$rptjoin='';
$track=0;
$k=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//Processing Groupings
$rptgroup='';
$track=0;
	

if(empty($obj->action)){
	
	$obj->shdocumentno='';
	$obj->shpackingno='';
	$obj->shcustomerid='';
	$obj->shagentid='';
	$obj->shremarks='';
	$obj->shsoldon='';
	$obj->shmemo='';
	$obj->shinvoiceno='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shcontinentid='';
	$obj->shcountryid='';
	$obj->shexchangerate='';
	$obj->shexchangerate2='';
	$obj->shcurrencyid='';
	
	
     
}




if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
	 $obj->grdocumentno=1;
	
	$track++;
}

if(!empty($obj->grpackingno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" packingno ";
	$obj->shpackingno=1;
	$track++;
}

if(!empty($obj->grcustomerid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" customerid ";
	$obj->shcustomerid=1;
	$track++;
}

if(!empty($obj->gragentid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" agentid ";
	$obj->shagentid=1;
	$track++;
}

if(!empty($obj->grsoldon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" soldon ";
	$obj->shsoldon=1;
	$track++;
}

if(!empty($obj->grinvoiceno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" invoiceno ";
	$obj->shinvoiceno=1;
	$track++;
}

if(!empty($obj->grcreatedby)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdby ";
	$obj->shcreatedby=1;
	$track++;
}

if(!empty($obj->grcreatedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdon ";
	$obj->shcreatedon=1;
	$track++;
}

if(!empty($obj->gritemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$obj->shitemid=1;
	$track++;
}

if(!empty($obj->grcategoryid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" categoryid ";
	$obj->shcategoryid=1;
	$track++;
}

if(!empty($rptgroup)){
  $obj->shquantity=1;
  $obj->shtotal=1;
  $obj->shtotaleuros=1;
  $obj->shtotalkshs=1;
}

//processing columns to show

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "pos_items.name itemid");
		
		$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	  
		$join=" left join pos_items on pos_items.id=pos_invoicedetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}
	if(!empty($obj->shcategoryid)  or empty($obj->action)){
		array_push($sColumns, 'categoryid');
		array_push($aColumns, "pos_categorys.name categoryid");
		
		$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	  
		$join=" left join pos_items on pos_items.id=pos_invoicedetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join pos_categorys on pos_categorys.id=pos_items.categoryid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$k++;
		}
		
	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "pos_invoices.documentno");
		
		$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$k++;
		}
	if(!empty($obj->shsaletypeid)  or empty($obj->action)){
		array_push($sColumns, 'saletypeid');
		array_push($aColumns, "pos_saletypes.name saletypeid");
		
		$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join pos_saletypes on pos_saletypes.id=pos_invoices.saletypeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$k++;
		}

	if(!empty($obj->shpackingno)  or empty($obj->action)){
		array_push($sColumns, 'packingno');
		array_push($aColumns, "pos_invoices.packingno");
		
		$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$k++;
		}

	if(!empty($obj->shcustomerid)  or empty($obj->action)){
		array_push($sColumns, 'customerid');
		array_push($aColumns, "crm_customers.name as customerid");
		$rptjoin.=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		$k++;
		}
		
	if(!empty($obj->shcontinentid) ){
		array_push($sColumns, 'continentid');
		array_push($aColumns, "crm_continents.name continentid");
		$k++;
		$join=" left join crm_continents on crm_continents.id=crm_customers.continentid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}

		$join=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		 
		}

	if(!empty($obj->shcountryid)){
		array_push($sColumns, 'countryid');
		array_push($aColumns, "crm_countrys.name countryid");
		$k++;
		
		$join=" left join crm_countrys on crm_countrys.id=crm_customers.countryid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shagentid)  or empty($obj->action)){
		array_push($sColumns, 'agentid');
		array_push($aColumns, "crm_agents.name as agentid");
		$rptjoin.=" left join crm_agents on crm_agents.id=pos_invoices.agentid ";
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "pos_invoices.remarks");
		$k++;
		}

	if(!empty($obj->shsoldon)  or empty($obj->action)){
		array_push($sColumns, 'soldon');
		array_push($aColumns, "pos_invoices.soldon");
		$k++;
		}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "pos_invoices.memo");
		$k++;
		}
		
		
	if(!empty($obj->shinvoiceno) ){
		array_push($sColumns, 'invoiceno');
		//array_push($aColumns, "pos_invoices.invoiceno");
		array_push($aColumns, "CONCAT(crm_customers.code,'',pos_invoices.invoiceno) as invoiceno");
		$join=" left join crm_customers on crm_customers.id=pos_invoices.customerid  ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}


	if(!empty($obj->shcreatedby) ){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "pos_invoices.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "pos_invoices.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "pos_invoices.ipaddress");
		$k++;
		}	

	if(!empty($obj->shexchangerate) ){
		array_push($sColumns, 'exchangerate');
		array_push($aColumns, "pos_invoices.exchangerate");
		$k++;
		}

	if(!empty($obj->shexchangerate2)){
		array_push($sColumns, 'exchangerate2');
		array_push($aColumns, "pos_invoices.exchangerate2");
		$k++;
		}

	if(!empty($obj->shcurrencyid)){
		array_push($sColumns, 'currencyid');
		array_push($aColumns, "pos_invoices.currencyid");
		$k++;
		
		
		
		}


$mnt=($k+1);
$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->saletypeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.saletypeid='$obj->saletypeid'";
	$track++;
}

if(!empty($obj->packingno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.packingno='$obj->packingno'";
	$track++;
}

if(!empty($obj->customerid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.customerid='$obj->customerid'";
		
	$track++;
}

if(!empty($obj->agentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.agentid='$obj->agentid'";
		
	$track++;
}

if(!empty($obj->fromsoldon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.soldon>='$obj->fromsoldon'";
	$track++;
}

if(!empty($obj->tosoldon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.soldon<='$obj->tosoldon'";
	$track++;
}

if(!empty($obj->invoiceno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.invoiceno<='$obj->invoiceno'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" pos_items.id='$obj->itemid' ";
	$join=" left join pos_invoices on pos_invoices.id=pos_invoicedetails.invoiceid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join pos_items on pos_items.id=pos_invoicedetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#customername").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=customers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#customerid").val(ui.item.id);
	}
  });

  $("#agentname").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=agents&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#agentid").val(ui.item.id);
	}
  });

});
</script>

<?php


 $sizes=new Sizes();
  $where="  ";
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby=" order by name ";
  $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
    
  $cols="";
  while($rw=mysql_fetch_object($sizes->result)){
  
    if($obj->shquantity==1 and $obj->grsizeid==1){
      $cols=" sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.quantity end) as '$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, $rw->name);
      
      $k++;
    }
    if($obj->shprice==1 and $obj->grsizeid==1){
      
      $cols=" round(sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.price end),2) as 'p$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, "p$rw->name");
      
      $k++;
    }
    
    if($obj->shtotal==1 and $obj->grsizeid==1){
      if(!empty($rptgroup)){
	$cols=" round((sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.total end)+sum(pos_invoiceconsumables.total)),2) as 't$rw->name'";
	$join=" left join pos_invoiceconsumables on pos_invoices.id=pos_invoiceconsumables.invoiceid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
      }
      else
	$cols=" round(sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.total end),2) as 'p$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, "t$rw->name");
      
      $k++;
    }
    
    if($obj->shtotaleuros==1 and $obj->grsizeid==1){
      $cols=" round(sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.total*pos_invoices.exchangerate2 end),2) as 'e$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, "e$rw->name");
      
      $k++;
    }
    
    if($obj->shtotalkshs==1 and $obj->grsizeid==1){
      $cols=" round(sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.total*pos_invoices.exchangerate end),2) as 'k$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, "k$rw->name");
      $k++;
    }
    
    if($obj->shavgeuros==1 and $obj->grsizeid==1){
      $cols=" round(sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.total*pos_invoices.exchangerate2 end)/sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.quantity end),2) as 'ek$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, "ek$rw->name");
      
      $k++;
    }
    
    if($obj->shavgkshs==1 and $obj->grsizeid==1){
      $cols=" round(sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.total*pos_invoices.exchangerate end)/sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.quantity end),2) as 'ak$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, "ak$rw->name");
      
      $k++;
    }
    
    if($obj->shpercstems==1 and $obj->grsizeid==1){
      $cols=" round(sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.quantity end)/sum(pos_invoicedetails.quantity),2) 'pk$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, "ak$rw->name");
      $k++;
    }
    
    if($obj->shpercrev==1 and $obj->grsizeid==1){
      $cols=" round(sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.total*pos_invoices.exchangerate end)/sum(pos_invoicedetails.total*pos_invoices.exchangerate2),2) as 'rk$rw->name'";
      array_push($aColumns, $cols);
      array_push($sColumns, "rk$rw->name");
      $k++;
    }
  }
  
  

if(!empty($obj->shquantity)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(pos_invoicedetails.quantity) quantity");
		}else{
		array_push($aColumns, "pos_invoicedetails.quantity");
		}

		$k++;
		
		}

	

  /*$inv=new Invoices();
  $where="";
  $fields="pos_invoices.id,pos_invoices.documentno,pos_invoicedetails.invoiceid";
  $join="left join pos_invoices on pos_invoices.documentno=pos_invoicedetails.invoiceid";
  $having="";
  $groupby="";
  $orderby=" ";
  $inv->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  while($riv=mysql_fetch_object($inv->result)){
  
  $cons=new Invoiceconsumables();
  $where="";
  $fields="pos_invoices.id,pos_invoiceconsumables.total";
  $join="left join pos_invoices on pos_invoices.id=pos_invoiceconsumables.invoiceid";
  $having="";
  $groupby="";
  $orderby=" ";
  $cons->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  while($rcs=mysql_fetch_object($inv->result)){
  $cons=$rcs->total:
  $totalcons+=$cons;
  }
  }*/		
if(!empty($obj->shtotal)){
		array_push($sColumns, 'total');
		if(!empty($rptgroup)){
			array_push($aColumns, "round((sum(pos_invoicedetails.total)+(select case when sum(pos_invoiceconsumables.total) is null then 0 else sum(pos_invoiceconsumables.total) end from pos_invoiceconsumables where invoiceid=pos_invoices.id)),2) total");
// 			$join=" left join pos_invoiceconsumables on pos_invoices.id=pos_invoiceconsumables.invoiceid ";
// 			if(!strpos($rptjoin,trim($join))){
// 				$rptjoin.=$join;
// 			}
		
		}else{
		array_push($aColumns, "round(pos_invoicedetails.total,2) total");
		}

		$k++;
		
		array_push($sColumns, 'ctotal');
		
		if(!empty($rptgroup)){
			array_push($aColumns, "round((select case when (sum(pos_returninwarddetails.total)) is null then 0 else (sum(pos_returninwarddetails.total)) end p from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as ctotal, ");
		}else{
			array_push($aColumns, "round((select case when (pos_returninwarddetails.total) is null then 0 else (pos_returninwarddetails.total) end p from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as ctotal, ");
		}

		$k++;
// 		
		array_push($sColumns, 'ntotal');
		
		if(!empty($rptgroup)){
		  array_push($aColumns, "round(((sum(pos_invoicedetails.total)+(select case when sum(pos_invoiceconsumables.total) is null then 0 else sum(pos_invoiceconsumables.total) end from pos_invoiceconsumables where invoiceid=pos_invoices.id)))-(select case when sum(pos_returninwarddetails.total) is null then 0 else sum(pos_returninwarddetails.total) end from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as ntotal, ");
		}else{
			array_push($aColumns, "round(((pos_invoicedetails.total)+(select case when (pos_invoiceconsumables.total) is null then 0 else (pos_invoiceconsumables.total) end from pos_invoiceconsumables where invoiceid=pos_invoices.id))-(select case when (pos_returninwarddetails.total) is null then 0 else (pos_returninwarddetails.total) end from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as ntotal, ");
		}

		$k++;
		
		}
		
		if(!empty($obj->shtotaleuros)){
		array_push($sColumns, 'etotal');
		if(!empty($rptgroup)){
			array_push($aColumns, "round(sum(pos_invoicedetails.total*pos_invoices.exchangerate2)+(select case when sum(pos_invoiceconsumables.total*pos_invoices.exchangerate2) is null then 0 else sum(pos_invoiceconsumables.total*pos_invoices.exchangerate2) end from pos_invoiceconsumables where invoiceid=pos_invoices.id),2)  as etotal");
		}else{
		array_push($aColumns, "round((pos_invoicedetails.total*pos_invoices.exchangerate2)+(select case when pos_invoiceconsumables.total is null then 0 else pos_invoiceconsumables.total end from pos_invoiceconsumables where invoiceid=pos_invoices.id),2) etotal");
		}
		
		$k++;
		
		array_push($sColumns, 'ectotal');
		
		if(!empty($rptgroup)){
			array_push($aColumns, "round((select case when (sum(pos_returninwarddetails.total*pos_returninwards.exchangerate2)) is null then 0 else (sum(pos_returninwarddetails.total*pos_returninwards.exchangerate2)) end k from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as ectotal, ");
		}else{
			array_push($aColumns, "round((select case when (pos_returninwarddetails.total*pos_returninwards.exchangerate2) is null then 0 else (pos_returninwarddetails.total*pos_returninwards.exchangerate2) end k from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as ectotal, ");
		}

		$k++;
		
		array_push($sColumns, 'entotal');
		
		if(!empty($rptgroup)){
		  array_push($aColumns, "round(((sum(pos_invoicedetails.total*pos_invoices.exchangerate2)+(select case when sum(pos_invoiceconsumables.total*pos_invoices.exchangerate2) is null then 0 else sum(pos_invoiceconsumables.total*pos_invoices.exchangerate2) end from pos_invoiceconsumables where invoiceid=pos_invoices.id)))-(select case when sum(pos_returninwarddetails.total*pos_returninwards.exchangerate2) is null then 0 else sum(pos_returninwarddetails.total*pos_returninwards.exchangerate2) end from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as entotal, ");
		}else{
			array_push($aColumns, "round(((pos_invoicedetails.total*pos_invoices.exchangerate2)+(select case when (pos_invoiceconsumables.total*pos_invoices.exchangerate2) is null then 0 else (pos_invoiceconsumables.total*pos_invoices.exchangerate2) end from pos_invoiceconsumables where invoiceid=pos_invoices.id))-(select case when (pos_returninwarddetails.total*pos_returninwards.exchangerate2) is null then 0 else (pos_returninwarddetails.total*pos_returninwards.exchangerate2) end from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as entotal, ");
		}

		$k++;
		
		}
		
if(!empty($obj->shavgeuros)){
      array_push($sColumns, 'avgetotal');
      if(!empty($rptgroup)){
	      array_push($aColumns, "round(sum(pos_invoicedetails.total*pos_invoices.exchangerate2)/sum(pos_invoicedetails.quantity),2) as avgetotal");
      }else{
      array_push($aColumns, "round((pos_invoicedetails.total*pos_invoices.exchangerate2)/pos_invoicedetails.quantity,2) as avgetotal");
      }
      
      $k++;
		
}
		
if(!empty($obj->shavgkshs)){
      array_push($sColumns, 'avgtotal');
      if(!empty($rptgroup)){
	      array_push($aColumns, "round(sum(pos_invoicedetails.total*pos_invoices.exchangerate)/sum(pos_invoicedetails.quantity),2) as avgtotal");
      }else{
	array_push($aColumns, "round((pos_invoicedetails.total*pos_invoices.exchangerate)/pos_invoicedetails.quantity,2) as avgtotal");
      }

      $k++;		
}

if(!empty($obj->shtotalkshs)){
		array_push($sColumns, 'ktotal');
		if(!empty($rptgroup)){
			array_push($aColumns, "round(sum(pos_invoicedetails.total*pos_invoices.exchangerate)+(select case when sum(pos_invoiceconsumables.total*pos_invoices.exchangerate) is null then 0 else sum(pos_invoiceconsumables.total*pos_invoices.exchangerate) end from pos_invoiceconsumables where invoiceid=pos_invoices.id),2) ktotal");
		}else{
		array_push($aColumns, "round((pos_invoicedetails.total*pos_invoices.exchangerate)+(select case when (pos_invoiceconsumables.total*pos_invoices.exchangerate) is null then 0 else (pos_invoiceconsumables.total*pos_invoices.exchangerate) end from pos_invoiceconsumables where invoiceid=pos_invoices.id),2) ktotal");
		}
		
		$k++;
		
		array_push($sColumns, 'kctotal');
		
		if(!empty($rptgroup)){
			array_push($aColumns, "round((select case when (sum(pos_returninwarddetails.total*pos_returninwards.exchangerate)) is null then 0 else (sum(pos_returninwarddetails.total*pos_returninwards.exchangerate)) end k from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as kctotal, ");
		}else{
			array_push($aColumns, "round((select case when (pos_returninwarddetails.total*pos_returninwards.exchangerate) is null then 0 else (pos_returninwarddetails.total*pos_returninwards.exchangerate) end k from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as kctotal, ");
		}

		$k++;
		
		array_push($sColumns, 'kntotal');
		
		if(!empty($rptgroup)){
		  array_push($aColumns, "round(((sum(pos_invoicedetails.total*pos_invoices.exchangerate)+(select case when sum(pos_invoiceconsumables.total*pos_invoices.exchangerate) is null then 0 else sum(pos_invoiceconsumables.total*pos_invoices.exchangerate) end from pos_invoiceconsumables where invoiceid=pos_invoices.id)))-(select case when sum(pos_returninwarddetails.total*pos_returninwards.exchangerate) is null then 0 else sum(pos_returninwarddetails.total*pos_returninwards.exchangerate) end from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as kntotal ");
		}else{
			array_push($aColumns, "round(((pos_invoicedetails.total*pos_invoices.exchangerate)+(select case when (pos_invoiceconsumables.total*pos_invoices.exchangerate) is null then 0 else (pos_invoiceconsumables.total*pos_invoices.exchangerate) end from pos_invoiceconsumables where invoiceid=pos_invoices.id))-(select case when (pos_returninwarddetails.total*pos_returninwards.exchangerate) is null then 0 else (pos_returninwarddetails.total*pos_returninwards.exchangerate) end from pos_returninwarddetails left join pos_returninwards on pos_returninwarddetails.returninwardid=pos_returninwards.id where pos_returninwards.invoiceno=pos_invoices.documentno and $rptwhere),2) as kntotal ");
		}

		$k++;
		
}
				
?>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="pos_invoicedetails";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pos_invoicedetails",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
// 				 if(i==2)
// 				  $('td:eq('+i+')', nRow).html("<a href='../../../modules/pos/invoices/addinvoices_proc.php?retrieve=1&documentno="+aaData[2]+"' target='_blank'>"+aaData[2]+"</a>");
// 				else
				  $('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
 	"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("");
			$('th:eq(1)', nRow).html("TOTAL");
			for(var i=2; i<"<?php echo $mnt; ?>"; i++){
			  $('th:eq('+i+')', nRow).html("");
			}
			var total=[];
			
			
			for(var i=0; i<aaData.length; i++){
			  if(i==0){
			    for(var j="<?php echo $mnt;?>"; j<=aaData[i].length; j++){
			      total[j]=0;
			    }
			  }
			  for(var j="<?php echo $mnt;?>"; j<=aaData[i].length; j++){
			  
			    total[j] = parseFloat(total[j])+parseFloat(aaData[i][j]);
			    total[j]=total[j].toFixed(2);
			  }
			}
			
			for(var i='<?php echo $mnt; ?>'; i<total.length;i++){
			  $('th:eq('+i+')', nRow).html(total[i]);
			}
		}
 	} );
 } );
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
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Filter</button>&nbsp;<?php if(!empty($rptgroup)){?><a class="btn btn-warning" target="_blank" href="../../graphs/graphs/bars.php">Bar Graph</a><?php } ?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter</h4>
      </div>
      <div class="modal-body">
<form  action="invoicess.php" method="post" name="invoices" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Document No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Sale Type</td>
				<td>
				<select name='saletypeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$saletypes=new Saletypes();
				$where="  ";
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$saletypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($saletypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->saletypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Packing No</td>
				<td><input type='text' id='packingno' size='20' name='packingno' value='<?php echo $obj->packingno;?>'></td>
			</tr>
			<tr>
				<td>Customer</td>
				<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Agent</td>
				<td><input type='text' size='20' name='agentname' id='agentname' value='<?php echo $obj->agentname; ?>'>
					<input type="hidden" name='agentid' id='agentid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Sold On</td>
				<td><strong>From:</strong><input type='text' id='fromsoldon' size='12' name='fromsoldon' readonly class="date_input" value='<?php echo $obj->fromsoldon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tosoldon' size='12' name='tosoldon' readonly class="date_input" value='<?php echo $obj->tosoldon;?>'/></td>
			</tr>
			
			<tr>
				<td>Invoice no</td>
				<input type='text' id='invoiceno' size='12' name='invoiceno' readonly class="text" value='<?php echo $obj->invoiceno;?>'/>
							
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="*";
				$where="where id in(select createdby from pos_invoices)";
				$join="   ";
				$having="";
				$groupby="";
				$orderby="";
				$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($users->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->createdby==$rw->id){echo "selected";}?>><?php echo $rw->username;?></option>
				<?php
				}
				?>
			</td>
			</tr>
			<tr>
				<td>Created On</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
			</tr>
			<tr>
				<td>Product</td>
				<td>
				<select name='itemid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$items=new Items();
				$where="  ";
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($items->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->itemid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) or empty($obj->action)){echo"checked";}?>>&nbsp;Document No</td>
				<td><input type='checkbox' name='grpackingno' value='1' <?php if(isset($_POST['grpackingno']) ){echo"checked";}?>>&nbsp;Packing No</td>
			<tr>
				<td><input type='checkbox' name='grcustomerid' value='1' <?php if(isset($_POST['grcustomerid']) ){echo"checked";}?>>&nbsp;Customer</td>
				<td><input type='checkbox' name='gragentid' value='1' <?php if(isset($_POST['gragentid']) ){echo"checked";}?>>&nbsp;Agent</td>
			<tr>
				<td><input type='checkbox' name='grsoldon' value='1' <?php if(isset($_POST['grsoldon']) ){echo"checked";}?>>&nbsp;Sold On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grsizeid' value='1' <?php if(isset($_POST['grsizeid']) ){echo"checked";}?>>&nbsp;Group By Size</td>
			<tr>
			      <td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Product</td>
			      <td><input type='checkbox' name='grinvoiceno' value='1' <?php if(isset($_POST['grinvoiceno']) ){echo"checked";}?>>&nbsp;Invoice No</td>
			<tr>
			      <td><input type='checkbox' name='grcategoryid' value='1' <?php if(isset($_POST['grcategoryid']) ){echo"checked";}?>>&nbsp;Category</td>
			
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document No</td>
				<td><input type='checkbox' name='shpackingno' value='1' <?php if(isset($_POST['shpackingno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Packing No</td>
			<tr>
				<td><input type='checkbox' name='shcustomerid' value='1' <?php if(isset($_POST['shcustomerid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Customer</td>
				<td><input type='checkbox' name='shagentid' value='1' <?php if(isset($_POST['shagentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Agent</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shsoldon' value='1' <?php if(isset($_POST['shsoldon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Sold On</td>
			<tr>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
			<tr>
				<td><input type='checkbox' name='shcontinentid' value='1' <?php if(isset($_POST['shcontinentid'])  ){echo"checked";}?>>&nbsp;Continent</td>
				<td><input type='checkbox' name='shcountryid' value='1' <?php if(isset($_POST['shcountryid'])  ){echo"checked";}?>>&nbsp;Country</td>
			<tr>
				<td><input type='checkbox' name='shexchangerate' value='1' <?php if(isset($_POST['shexchangerate'])  ){echo"checked";}?>>&nbsp;Ksh</td>
				<td><input type='checkbox' name='shexchangerate2' value='1' <?php if(isset($_POST['shexchangerate2'])  ){echo"checked";}?>>&nbsp;Euro</td>
			<tr>
				<td><input type='checkbox' name='shcurrencyid' value='1' <?php if(isset($_POST['shcurrencyid'])  ){echo"checked";}?>>&nbsp;Currency</td>
				<td><input type='checkbox' name='shprice' value='1' <?php if(isset($_POST['shprice'])  ){echo"checked";}?>>&nbsp;Price</td>
			<tr>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  ){echo"checked";}?>>&nbsp;Amount (Original Currency)</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  ){echo"checked";}?>>&nbsp;Quantity</td>
			 <tr>
				<td><input type='checkbox' name='shtotaleuros' value='1' <?php if(isset($_POST['shtotaleuros'])  ){echo"checked";}?>>&nbsp;Amount (Euros)</td>
				<td><input type='checkbox' name='shtotalkshs' value='1' <?php if(isset($_POST['shtotalkshs'])  ){echo"checked";}?>>&nbsp;Amount (Kshs)</td>
			<tr>
				<td><input type='checkbox' name='shavgeuros' value='1' <?php if(isset($_POST['shavgeuros'])  ){echo"checked";}?>>&nbsp;Average (Euros)</td>
				<td><input type='checkbox' name='shavgkshs' value='1' <?php if(isset($_POST['shavgkshs'])  ){echo"checked";}?>>&nbsp;Average (Kshs)</td>
			<tr>
				<td><input type='checkbox' name='shpercstems' value='1' <?php if(isset($_POST['shpercstems'])  ){echo"checked";}?>>&nbsp;% Stems Sold</td>
				<td><input type='checkbox' name='shpercrev' value='1' <?php if(isset($_POST['shpercrev']) ){echo"checked";}?>>&nbsp;% Revenue</td>
			<tr>
				<td><input type='checkbox' name='shname' value='1' <?php if(isset($_POST['shname']) ){echo"checked";}?>>&nbsp;Product</td>
				<td><input type='checkbox' name='shsaletypeid' value='1' <?php if(isset($_POST['shsaletypeid']) ){echo"checked";}?>>&nbsp;Sale Type</td>
			<tr>
			<td><input type='checkbox' name='shinvoiceno' value='1' <?php if(isset($_POST['shinvoiceno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Invoice No</td>
			
			<td><input type='checkbox' name='shcategoryid' value='1' <?php if(isset($_POST['shcategoryid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Category</td>
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
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Product </th>
			<?php } ?>
			<?php if($obj->shcategoryid==1  or empty($obj->action)){ ?>
				<th>Category </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Document No </th>
			<?php } ?>
			<?php if($obj->shsaletypeid==1  or empty($obj->action)){ ?>
				<th>Sale Type </th>
			<?php } ?>
			<?php if($obj->shpackingno==1  or empty($obj->action)){ ?>
				<th>Packing No </th>
			<?php } ?>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>Customer </th>
			<?php } ?>			
			<?php if($obj->shcontinentid==1){ ?>
				<th>Continent </th>
			<?php } ?>
			<?php if($obj->shcountryid==1){ ?>
				<th>Country </th>
			<?php } ?>
			<?php if($obj->shagentid==1  or empty($obj->action)){ ?>
				<th>Agent </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shsoldon==1  or empty($obj->action)){ ?>
				<th>Sold On </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shinvoiceno==1 ){ ?>
				<th>Invoice No </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address</th>
			<?php } ?>
			<?php if($obj->shexchangerate==1 ){ ?>
				<th>Exchange Rate (Euro)</th>
			<?php } ?>
			<?php if($obj->shexchangerate2==1){ ?>
				<th>Exchange Rate (Kshs)</th>
			<?php } ?>
			<?php if($obj->shcurrencyid==1){ ?>
				<th>Customer Currency</th>
			<?php } ?>
			
			<?php  
			      $sizes=new Sizes();
			      $where="  ";
			      $fields="*";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			      while($rw=mysql_fetch_object($sizes->result)){
				if($obj->shquantity==1 and $obj->grsizeid==1){
			?>
				<th><?php echo $rw->name; ?></th>
			<?php }
			if($obj->shprice==1 and $obj->grsizeid==1){
			?>
			  <th><?php echo $rw->name; ?></th>
			<?php
			}
			
			if($obj->shtotal==1 and $obj->grsizeid==1){
			?>
			  <th><?php echo $rw->name; ?></th>
			<?php
			}
			
			if($obj->shtotaleuros==1 and $obj->grsizeid==1){
			?>
			  <th><?php echo $rw->name; ?></th>
			<?php
			}
			
			if($obj->shtotalkshs==1 and $obj->grsizeid==1){
			?>
			  <th><?php echo $rw->name; ?></th>
			<?php
			}
			
			if($obj->shavgeuros==1 and $obj->grsizeid==1){
			?>
			  <th><?php echo $rw->name; ?></th>
			<?php
			}
			
			if($obj->shavgkshs==1 and $obj->grsizeid==1){
			?>
			  <th><?php echo $rw->name; ?></th>
			<?php
			}
			
			if($obj->shpercstems==1 and $obj->grsizeid==1){
			?>
			  <th><?php echo $rw->name; ?></th>
			<?php
			}
			
			if($obj->shpercrev==1 and $obj->grsizeid==1){
			?>
			  <th><?php echo $rw->name; ?></th>
			<?php
			}
			
			} ?>
			<?php if($obj->shquantity==1){ ?>
				<th>Quantity </th>
			<?php } ?>
			
			<?php if($obj->shtotal==1){ ?>
				<th>Amount (Original Currency) </th>
				<th>Creditnote (Original Currency) </th>
				<th>Net (Original Currency) </th>
			<?php } ?>
			<?php if($obj->shtotaleuros==1){ ?>
				<th>Amount (Euros) </th>
				<th>Creditnote (Euros) </th>
				<th>Net (Euros) </th>
			<?php } ?>
			
			<?php if($obj->shavgeuros==1){ ?>
				<th>Average (Euros) </th>
			<?php } ?>
			<?php if($obj->shavgkshs==1){ ?>
				<th>Average (Kshs) </th>
			<?php } ?>
			<?php if($obj->shtotalkshs==1){ ?>
				<th>Amount (Kshs) </th>
				<th>Creditnote (Kshs) </th>
				<th>Net (Kshs) </th>
			<?php } ?>
		</tr>
		
	</thead>
	<tbody>
	<tfoot>
	<tr>
	<th>#</th>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shsaletypeid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shpackingno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>			
			<?php if($obj->shcontinentid==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcountryid==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shagentid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shsoldon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shinvoiceno==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shexchangerate==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shexchangerate2==1){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shcurrencyid==1){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			
			<?php  
			      $sizes=new Sizes();
			      $where="  ";
			      $fields="*";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			      while($rw=mysql_fetch_object($sizes->result)){
				if($obj->shquantity==1 and $obj->grsizeid==1){
			?>
				<th>&nbsp;</th>
			<?php }
			if($obj->shprice==1 and $obj->grsizeid==1){
			?>
			  <th>&nbsp;</th>
			<?php
			}
			
			if($obj->shtotal==1 and $obj->grsizeid==1){
			?>
			  <th>&nbsp;</th>
			<?php
			}
			
			if($obj->shtotaleuros==1 and $obj->grsizeid==1){
			?>
			  <th>&nbsp;</th>
			<?php
			}
			
			if($obj->shtotalkshs==1 and $obj->grsizeid==1){
			?>
			  <th>&nbsp;</th>
			<?php
			}
			
			if($obj->shavgeuros==1 and $obj->grsizeid==1){
			?>
			  <th>&nbsp;</th>
			<?php
			}
			
			if($obj->shavgkshs==1 and $obj->grsizeid==1){
			?>
			  <th>&nbsp;</th>
			<?php
			}
			
			if($obj->shpercstems==1 and $obj->grsizeid==1){
			?>
			  <th>&nbsp;</th>
			<?php
			}
			
			if($obj->shpercrev==1 and $obj->grsizeid==1){
			?>
			  <th>&nbsp;</th>
			<?php
			}
			
			} ?>
			<?php if($obj->shquantity==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			
			<?php if($obj->shtotal==1){ ?>
				<th>&nbsp; </th>
				<th>&nbsp; </th>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtotaleuros==1){ ?>
				<th>&nbsp; </th>
				<th>&nbsp; </th>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtotalkshs==1){ ?>
				<th>&nbsp; </th>
				<th>&nbsp; </th>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shavgeuros==1){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shavgkshs==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
		</tr>
	<tfoot>
	</tbody>
</div>
</div>
</div>
</div>
</div>
