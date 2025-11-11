<?php 
require_once("../../../DB.php");
class PlotutilitysDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_plotutilitys";

	function persist($obj){
		$sql="insert into em_plotutilitys(id,plotid,paymenttermid,amount,showinst,mgtfee,mgtfeeperc,vatable,vatclasseid,mgtfeevatable,mgtfeevatclasseid,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->plotid,$obj->paymenttermid,'$obj->amount','$obj->showinst','$obj->mgtfee','$obj->mgtfeeperc','$obj->vatable',$obj->vatclasseid,'$obj->mgtfeevatable','$obj->mgtfeevatclasseid','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update em_plotutilitys set plotid=$obj->plotid,paymenttermid=$obj->paymenttermid,amount='$obj->amount',showinst='$obj->showinst',mgtfee='$obj->mgtfee',mgtfeeperc='$obj->mgtfeeperc',vatable='$obj->vatable',vatclasseid=$obj->vatclasseid,mgtfeevatable='$obj->mgtfeevatable',mgtfeevatclasseid='$obj->mgtfeevatclasseid',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_plotutilitys $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_plotutilitys $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

