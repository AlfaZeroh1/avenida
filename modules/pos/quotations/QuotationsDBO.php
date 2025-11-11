<?php 
require_once("../../../DB.php");
class QuotationsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_quotations";

	function persist($obj){
		$sql="insert into pos_quotations(id,itemid,documentno,customerid,agentid,employeeid,description,quantity,costprice,tradeprice,retailprice,discount,tax,bonus,total,status,quotedon,memo,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->itemid,'$obj->documentno',$obj->customerid,$obj->agentid,$obj->employeeid,'$obj->description','$obj->quantity','$obj->costprice','$obj->tradeprice','$obj->retailprice','$obj->discount','$obj->tax','$obj->bonus','$obj->total','$obj->status','$obj->quotedon','$obj->memo','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update pos_quotations set itemid=$obj->itemid,documentno='$obj->documentno',customerid=$obj->customerid,agentid=$obj->agentid,employeeid=$obj->employeeid,description='$obj->description',quantity='$obj->quantity',costprice='$obj->costprice',tradeprice='$obj->tradeprice',retailprice='$obj->retailprice',discount='$obj->discount',tax='$obj->tax',bonus='$obj->bonus',total='$obj->total',status='$obj->status',quotedon='$obj->quotedon',memo='$obj->memo',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_quotations $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_quotations $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

