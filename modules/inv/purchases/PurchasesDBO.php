<?php 
require_once("../../../DB.php");
class PurchasesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="inv_purchases";

	function persist($obj){
		$sql="insert into inv_purchases(id,documentno,receiptno,lpono, jvno,storeid,supplierid,batchno,currencyid,exchangerate,exchangerate2,remarks,purchasemodeid,paymentmodeid, paymentcategoryid, bankid, employeeid, chequeno, transactionno,boughton,memo,createdby,createdon,lasteditedby,lasteditedon,ipaddress,projectid)
						values('$obj->id','$obj->documentno','$obj->receiptno','$obj->lpono','$obj->jvno',$obj->storeid,$obj->supplierid,'$obj->batchno','$obj->currencyid','$obj->exchangerate','$obj->exchangerate2','$obj->remarks',$obj->purchasemodeid,$obj->paymentmodeid, $obj->paymentcategoryid, $obj->bankid, $obj->employeeid, '$obj->chequeno', '$obj->transactionno','$obj->boughton','$obj->memo','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress',$obj->projectid)";		
		$this->sql=$sql;
		if(empty($obj->effectjournals)){
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
		$sql="update inv_purchases set documentno='$obj->documentno',receiptno='$obj->receiptno',lpono='$obj->lpono', jvno='$obj->jvno',storeid=$obj->storeid,supplierid=$obj->supplierid,batchno='$obj->batchno',currencyid='$obj->currencyid',exchangerate='$obj->exchangerate',exchangerate2='$obj->exchangerate2',remarks='$obj->remarks',purchasemodeid=$obj->purchasemodeid, paymentmodeid=$obj->paymentmodeid, paymentcategoryid=$obj->paymentcategoryid, bankid=$obj->bankid, employeeid=$obj->employeeid, chequeno='$obj->chequeno', transactionno='$obj->transactionno',boughton='$obj->boughton',memo='$obj->memo',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress',projectid=$obj->projectid where $where ";
		$this->sql=$sql;
		
// 		if(empty($obj->effectjournals)){
		  if(mysql_query($sql,$this->connection)){
			  return true;	
		  }
// 		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from inv_purchases $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from inv_purchases $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

