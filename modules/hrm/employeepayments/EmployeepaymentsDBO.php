<?php 
require_once("../../../DB.php");
class EmployeepaymentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_employeepayments";

	function persist($obj){
		$sql="insert into hrm_employeepayments(id,employeeid,assignmentid,paymentmodeid,bankid,employeebankid,bankbrancheid,bankacc,clearingcode,ref,month,year,fromdate,todate,basic,allowances,deductions,netpay,paidon,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->employeeid,$obj->assignmentid,$obj->paymentmodeid,$obj->bankid,$obj->employeebankid,$obj->bankbrancheid,'$obj->bankacc','$obj->clearingcode','$obj->ref','$obj->month','$obj->year','$obj->fromdate','$obj->todate','$obj->basic','$obj->allowances','$obj->deductions','$obj->netpay','$obj->paidon','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}	//echo mysql_error();	
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update hrm_employeepayments set employeeid=$obj->employeeid,assignmentid=$obj->assignmentid,paymentmodeid=$obj->paymentmodeid,bankid=$obj->bankid,employeebankid=$obj->employeebankid,bankbrancheid=$obj->bankbrancheid,bankacc='$obj->bankacc',clearingcode='$obj->clearingcode',ref='$obj->ref',month='$obj->month',year='$obj->year',fromdate='$obj->fromdate',todate='$obj->todate',basic='$obj->basic',allowances='$obj->allowances',deductions='$obj->deductions',netpay='$obj->netpay',paidon='$obj->paidon',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_employeepayments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_employeepayments $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

