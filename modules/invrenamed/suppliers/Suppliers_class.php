<?php 
require_once("SuppliersDBO.php");
class Suppliers
{				
	var $suppliersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		return $this;
	
	}
	function add($obj){
		$suppliersDBO = new SuppliersDBO();
		if($suppliersDBO->persist($obj)){
			$this->id=$suppliersDBO->id;
			$this->sql=$suppliersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$suppliersDBO = new SuppliersDBO();
		if($suppliersDBO->update($obj,$where)){
			$this->sql=$suppliersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$suppliersDBO = new SuppliersDBO();
		if($suppliersDBO->delete($obj,$where=""))		
			$this->sql=$suppliersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$suppliersDBO = new SuppliersDBO();
		$this->table=$suppliersDBO->table;
		$suppliersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$suppliersDBO->sql;
		$this->result=$suppliersDBO->result;
		$this->fetchObject=$suppliersDBO->fetchObject;
		$this->affectedRows=$suppliersDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
