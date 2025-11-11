<?php 
require_once("DocumentsDBO.php");
class Documents
{				
	var $documentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		return $this;
	
	}
	function add($obj){
		$documentsDBO = new DocumentsDBO();
		if($documentsDBO->persist($obj)){
			$this->id=$documentsDBO->id;
			$this->sql=$documentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$documentsDBO = new DocumentsDBO();
		if($documentsDBO->update($obj,$where)){
			$this->sql=$documentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$documentsDBO = new DocumentsDBO();
		if($documentsDBO->delete($obj,$where=""))		
			$this->sql=$documentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$documentsDBO = new DocumentsDBO();
		$this->table=$documentsDBO->table;
		$documentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$documentsDBO->sql;
		$this->result=$documentsDBO->result;
		$this->fetchObject=$documentsDBO->fetchObject;
		$this->affectedRows=$documentsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
