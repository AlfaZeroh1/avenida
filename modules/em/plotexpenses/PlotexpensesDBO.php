<?php 
require_once("../../../DB.php");
class PlotexpensesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_plotexpenses";

	function persist($obj){
		$sql="insert into em_plotexpenses(id,plotid,expenseid,paymenttermid,quantity,amount,total,expensedate,documentno,pcvno,month,year,paymentmodeid,bankid,imprestaccountid,chequeno,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->plotid,$obj->expenseid,$obj->paymenttermid,'$obj->quantity','$obj->amount','$obj->total','$obj->expensedate','$obj->documentno','$obj->pcvno','$obj->month','$obj->year',$obj->paymentmodeid,$obj->bankid,$obj->imprestaccountid,'$obj->chequeno','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update em_plotexpenses set plotid=$obj->plotid,expenseid=$obj->expenseid,paymenttermid=$obj->paymenttermid,quantity='$obj->quantity',amount='$obj->amount',total='$obj->total',expensedate='$obj->expensedate',documentno='$obj->documentno',pcvno='$obj->pcvno',month='$obj->month',year='$obj->year',paymentmodeid=$obj->paymentmodeid,bankid=$obj->bankid,imprestaccountid=$obj->imprestaccountid,chequeno='$obj->chequeno',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_plotexpenses $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_plotexpenses $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

