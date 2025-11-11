<?php 
require_once("NhifsDBO.php");
class Nhifs
{				
	var $id;			
	var $low;			
	var $high;			
	var $amount;			
	var $nhifsDBO;
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
		$nhifsDBO = new NhifsDBO();
		if($nhifsDBO->persist($obj)){
			$this->id=$nhifsDBO->id;
			$this->sql=$nhifsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$nhifsDBO = new NhifsDBO();
		if($nhifsDBO->update($obj,$where)){
			$this->sql=$nhifsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$nhifsDBO = new NhifsDBO();
		if($nhifsDBO->delete($obj,$where=""))		
			$this->sql=$nhifsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$nhifsDBO = new NhifsDBO();
		$this->table=$nhifsDBO->table;
		$nhifsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$nhifsDBO->sql;
		$this->result=$nhifsDBO->result;
		$this->fetchObject=$nhifsDBO->fetchObject;
		$this->affectedRows=$nhifsDBO->affectedRows;
	}			
	
	function getNHIF($gross){
		$nhifs = new Nhifs();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$nhifs->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$nhif=0;
		while($row=mysql_fetch_object($nhifs->result)){
			if($gross>=$row->low and $gross<=$row->high and $row->high>0){
				$nhif=$row->amount;
				break;
			}
			if($gross>=$row->low and $row->high==0){
				$nhif=$row->amount;
				break;
			}
		}
		return $nhif;
	}
	
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
