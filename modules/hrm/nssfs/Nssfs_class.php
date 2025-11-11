<?php 
require_once("NssfsDBO.php");
class Nssfs
{				
	var $id;			
	var $low;			
	var $high;			
	var $amount;			
	var $nssfsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->low=str_replace("'","\'",$obj->low);
		$this->high=str_replace("'","\'",$obj->high);
		$this->amount=str_replace("'","\'",$obj->amount);
		return $this;
	
	}
	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get low
	function getLow(){
		return $this->low;
	}
	//set low
	function setLow($low){
		$this->low=$low;
	}

	//get high
	function getHigh(){
		return $this->high;
	}
	//set high
	function setHigh($high){
		$this->high=$high;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	function add($obj){
		$nssfsDBO = new NssfsDBO();
		if($nssfsDBO->persist($obj)){
			$this->id=$nssfsDBO->id;
			$this->sql=$nssfsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$nssfsDBO = new NssfsDBO();
		if($nssfsDBO->update($obj,$where)){
			$this->sql=$nssfsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$nssfsDBO = new NssfsDBO();
		if($nssfsDBO->delete($obj,$where=""))		
			$this->sql=$nssfsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$nssfsDBO = new NssfsDBO();
		$this->table=$nssfsDBO->table;
		$nssfsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$nssfsDBO->sql;
		$this->result=$nssfsDBO->result;
		$this->fetchObject=$nssfsDBO->fetchObject;
		$this->affectedRows=$nssfsDBO->affectedRows;
	}			
	
	function getNSSF($gross){
// 		$nssfs = new Nssfs();
// 		$fields="*";
// 		$join="";
// 		$having="";
// 		$groupby="";
// 		$orderby="";
// 		$where="";
// 		$nssfs->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 		$nssf=0;
// 		while($row=mysql_fetch_object($nssfs->result)){
// 			if($gross>=$row->low){
// 				if($gross<=$row->high or $row->high==0){
// 				  $nssf=$row->amount*$gross/100;
// 				}
// 				if($gross>=$row->high and $row->high>0){
// 				  $nssf=$row->amount*$row->high/100;
// 				}
// 				//break;
// 			}
// 		}
		return 200;
	}
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
