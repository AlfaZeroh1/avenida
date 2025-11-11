<?php 
require_once("VatclassesDBO.php");
class Vatclasses
{				
	var $vatclassesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		return $this;
	
	}
	function add($obj){
		$vatclassesDBO = new VatclassesDBO();
		if($vatclassesDBO->persist($obj)){
			$this->id=$vatclassesDBO->id;
			$this->sql=$vatclassesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$vatclassesDBO = new VatclassesDBO();
		if($vatclassesDBO->update($obj,$where)){
			$this->sql=$vatclassesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$vatclassesDBO = new VatclassesDBO();
		if($vatclassesDBO->delete($obj,$where=""))		
			$this->sql=$vatclassesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$vatclassesDBO = new VatclassesDBO();
		$this->table=$vatclassesDBO->table;
		$vatclassesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$vatclassesDBO->sql;
		$this->result=$vatclassesDBO->result;
		$this->fetchObject=$vatclassesDBO->fetchObject;
		$this->affectedRows=$vatclassesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
