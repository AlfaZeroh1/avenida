<?php 
require_once("../../../DB.php");
class ImprestsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="fn_imprests";

	function persist($obj){
		$sql="insert into fn_imprests(id,documentno,paymentvoucherno,imprestaccountid,employeeid,issuedon,currencyid,exchangerate,exchangerate2,paymentmodeid,paymentcategoryid, bankid, employeeids, chequeno, transactionno,amount,memo,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->documentno','$obj->paymentvoucherno',$obj->imprestaccountid,$obj->employeeid,'$obj->issuedon','$obj->currencyid','$obj->exchangerate','$obj->exchangerate2',$obj->paymentmodeid,$obj->paymentcategoryid, $obj->bankid, $obj->employeeids, '$obj->chequeno', '$obj->transactionno','$obj->amount','$obj->memo','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update fn_imprests set documentno='$obj->documentno',paymentvoucherno='$obj->paymentvoucherno',imprestaccountid=$obj->imprestaccountid,employeeid=$obj->employeeid,issuedon='$obj->issuedon',currencyid='$obj->currencyid',exchangerate='$obj->exchangerate',exchangerate2='$obj->exchangerate2',paymentmodeid=$obj->paymentmodeid,paymentmodeid=$obj->paymentmodeid, paymentcategoryid=$obj->paymentcategoryid, bankid=$obj->bankid, employeeids=$obj->employeeids, chequeno='$obj->chequeno', transactionno='$obj->transactionno',amount='$obj->amount',memo='$obj->memo',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from fn_imprests $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from fn_imprests $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

