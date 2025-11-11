<?php 
require_once("DocumenttypesDBO.php");
class Documenttypes
{				
	var $documenttypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		return $this;
	
	}
	function add($obj){
		$documenttypesDBO = new DocumenttypesDBO();
		if($documenttypesDBO->persist($obj)){
			$this->id=$documenttypesDBO->id;
			$this->sql=$documenttypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$documenttypesDBO = new DocumenttypesDBO();
		if($documenttypesDBO->update($obj,$where)){
			$this->sql=$documenttypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$documenttypesDBO = new DocumenttypesDBO();
		if($documenttypesDBO->delete($obj,$where=""))		
			$this->sql=$documenttypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$documenttypesDBO = new DocumenttypesDBO();
		$this->table=$documenttypesDBO->table;
		$documenttypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$documenttypesDBO->sql;
		$this->result=$documenttypesDBO->result;
		$this->fetchObject=$documenttypesDBO->fetchObject;
		$this->affectedRows=$documenttypesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
