<?php 
require_once("BlockdoublesDBO.php");
class Blockdoubles
{				
	var $id;			
	var $name;			
	var $blockdoublesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	function add($obj){
		$blockdoublesDBO = new BlockdoublesDBO();
		if($blockdoublesDBO->persist($obj)){
			$this->id=$blockdoublesDBO->id;
			$this->sql=$blockdoublesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$blockdoublesDBO = new BlockdoublesDBO();
		if($blockdoublesDBO->update($obj,$where)){
			$this->sql=$blockdoublesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$blockdoublesDBO = new BlockdoublesDBO();
		if($blockdoublesDBO->delete($obj,$where=""))		
			$this->sql=$blockdoublesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$blockdoublesDBO = new BlockdoublesDBO();
		$this->table=$blockdoublesDBO->table;
		$blockdoublesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$blockdoublesDBO->sql;
		$this->result=$blockdoublesDBO->result;
		$this->fetchObject=$blockdoublesDBO->fetchObject;
		$this->affectedRows=$blockdoublesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
