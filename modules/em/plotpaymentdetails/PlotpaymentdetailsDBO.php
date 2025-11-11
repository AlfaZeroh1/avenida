<?php 
require_once("../../../DB.php");
class PlotpaymentdetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_plotpaymentdetails";

	function persist($obj){
		$sql="insert into em_plotpaymentdetails(id,plotid,clientbankid,branch,accntno,paidon,paymentmodeid,vatno,pin,chequesto,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->plotid','$obj->clientbankid','$obj->branch','$obj->accntno','$obj->paidon','$obj->paymentmodeid','$obj->vatno','$obj->pin','$obj->chequesto','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update em_plotpaymentdetails set plotid='$obj->plotid',clientbankid='$obj->clientbankid',branch='$obj->branch',accntno='$obj->accntno',paidon='$obj->paidon',paymentmodeid='$obj->paymentmodeid',vatno='$obj->vatno',pin='$obj->pin',chequesto='$obj->chequesto',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_plotpaymentdetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_plotpaymentdetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

