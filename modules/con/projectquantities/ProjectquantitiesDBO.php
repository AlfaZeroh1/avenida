<?php 
require_once("../../../DB.php");
class ProjectquantitiesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="con_projectquantities";

	function persist($obj){
		$sql="insert into con_projectquantities(id,projectid,projectboqdetailid,itemid,labourid,categoryid,subcategoryid,quantity,rate,remarks,projectweek,week,year,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->projectid,$obj->projectboqdetailid,$obj->itemid,$obj->labourid,$obj->categoryid,$obj->subcategoryid,'$obj->quantity','$obj->rate','$obj->remarks','$obj->projectweek','$obj->week','$obj->year','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update con_projectquantities set projectid=$obj->projectid,projectboqdetailid=$obj->projectboqdetailid,itemid=$obj->itemid,labourid=$obj->labourid,categoryid=$obj->categoryid,subcategoryid=$obj->subcategoryid,quantity='$obj->quantity',rate='$obj->rate',remarks='$obj->remarks',projectweek='$obj->projectweek',week='$obj->week',year='$obj->year',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from con_projectquantities $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from con_projectquantities $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

