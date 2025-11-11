<?php 
require_once("../../../DB.php");
class InvoicedetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_invoicedetails";

	function persist($obj){
		$sql="insert into pos_invoicedetails(id,invoiceid,itemid, sizeid,mixedbox,item,quantity,price,exportprice,discount,tax,bonus,profit,total,boxno,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->invoiceid,$obj->itemid, $obj->sizeid,'$obj->mixedbox','$obj->item','$obj->quantity','$obj->price','$obj->exportprice','$obj->discount','$obj->tax','$obj->bonus','$obj->profit','$obj->total','$obj->boxno','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		echo mysql_error();
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update pos_invoicedetails set invoiceid=$obj->invoiceid,itemid=$obj->itemid, sizeid=$obj->sizeid,mixedbox='$obj->mixedbox',item='$obj->item', quantity='$obj->quantity',price='$obj->price',exportprice='$obj->exportprice',discount='$obj->discount',tax='$obj->tax',bonus='$obj->bonus',profit='$obj->profit',total='$obj->total',boxno='$obj->boxno',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_invoicedetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_invoicedetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

