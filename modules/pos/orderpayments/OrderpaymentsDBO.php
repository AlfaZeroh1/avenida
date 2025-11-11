<?php 
require_once("../../../DB.php");
class OrderpaymentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_orderpayments";

	function persist($obj){
		$sql="insert into pos_orderpayments(id,orderid,billno,documentno,paidon,amount,amountgiven,paymentmodeid, imprestaccountid,paymentcategoryid,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->orderid','$obj->billno','$obj->documentno','$obj->paidon','$obj->amount','$obj->amountgiven',$obj->paymentmodeid,$obj->imprestaccountid,$obj->paymentcategoryid,'$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')"; //echo $sql;		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update pos_orderpayments set orderid='$obj->orderid',billno='$obj->billno',paidon='$obj->paidon',amount='$obj->amount',amountgiven='$obj->amountgiven',paymentmodeid=$obj->paymentmodeid,imprestaccountid=$obj->imprestaccountid,paymentcategoryid=$obj->paymentcategoryid,remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_orderpayments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_orderpayments $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

