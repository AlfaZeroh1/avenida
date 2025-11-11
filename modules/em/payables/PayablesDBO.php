<?php 
require_once("../../../DB.php");
class PayablesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_payables";

	function persist($obj,$bool){
		$sql="insert into em_payables(id,documentno,paymenttermid,houseid,tenantid,month,year,invoicedon,quantity,amount,vatclasseid,vatamount,mgtfee,mgtfeeamount,mgtfeevatclasseid,mgtfeevatamount,total,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->documentno','$obj->paymenttermid','$obj->houseid','$obj->tenantid','$obj->month','$obj->year','$obj->invoicedon','$obj->quantity','$obj->amount','$obj->vatclasseid','$obj->vatamount','$obj->mgtfee','$obj->mgtfeeamount','$obj->mgtfeevatclasseid','$obj->mgtfeevatamount','$obj->total','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;echo $sql;
		if($bool){
		  if(mysql_query($sql,$this->connection)){		
			  $this->id=mysql_insert_id();
			  return true;	
		  }
		}else{
		  return true;
		}
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update em_payables set documentno='$obj->documentno',paymenttermid='$obj->paymenttermid',houseid='$obj->houseid',tenantid='$obj->tenantid',month='$obj->month',year='$obj->year',invoicedon='$obj->invoicedon',quantity='$obj->quantity',amount='$obj->amount',vatclasseid='$obj->vatclasseid',vatamount='$obj->vatamount',mgtfee='$obj->mgtfee',mgtfeeamount='$obj->mgtfeeamount',mgtfeevatclasseid='$obj->mgtfeevatclasseid',mgtfeevatamount='$obj->mgtfeevatamount',total='$obj->total',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_payables $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_payables $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

