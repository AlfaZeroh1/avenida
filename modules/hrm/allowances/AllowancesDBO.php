<?php 
require_once("../../../DB.php");
class AllowancesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_allowances";

	function persist($obj){
		$sql="insert into hrm_allowances(id,name,amount,percentaxable,allowancetypeid,expenseid,overall,frommonth,fromyear,tomonth,toyear,status,noncashbenefit,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->name','$obj->amount','$obj->percentaxable',$obj->allowancetypeid,$obj->expenseid,'$obj->overall','$obj->frommonth','$obj->fromyear','$obj->tomonth','$obj->toyear','$obj->status','$obj->noncashbenefit','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update hrm_allowances set name='$obj->name',amount='$obj->amount',percentaxable='$obj->percentaxable',allowancetypeid=$obj->allowancetypeid,expenseid=$obj->expenseid,overall='$obj->overall',frommonth='$obj->frommonth',fromyear='$obj->fromyear',tomonth='$obj->tomonth',toyear='$obj->toyear',status='$obj->status',noncashbenefit='$obj->noncashbenefit',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_allowances $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_allowances $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

