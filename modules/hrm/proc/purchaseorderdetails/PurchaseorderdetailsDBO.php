<?php 
require_once("../../../DB.php");
class PurchaseorderdetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="proc_purchaseorderdetails";

	function persist($obj){
		$sql="insert into proc_purchaseorderdetails(id,purchaseorderid,itemid,categoryid,expenseid,unitofmeasureid,quantity,costprice,tradeprice,vatclasseid,taxamount,tax,discount,discountamount,total,memo,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->purchaseorderid,'$obj->itemid','$obj->categoryid',$obj->expenseid,'$obj->unitofmeasureid','$obj->quantity','$obj->costprice','$obj->tradeprice','$obj->vatclasseid','$obj->taxamount','$obj->tax','$obj->discount','$obj->discountamount','$obj->total','$obj->memo','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;//echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update proc_purchaseorderdetails set purchaseorderid=$obj->purchaseorderid,itemid='$obj->itemid','categoryid=$obj->categoryid', expenseid='$obj->expenseid', unitofmeasureid=$obj->unitofmeasureid,quantity='$obj->quantity',costprice='$obj->costprice',tradeprice='$obj->tradeprice',tax='$obj->tax',discount='$obj->discount',discountamount='$obj->discountamount',total='$obj->total',memo='$obj->memo',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from proc_purchaseorderdetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from proc_purchaseorderdetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

