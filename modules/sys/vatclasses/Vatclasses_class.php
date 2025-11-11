<?php 
require_once("VatclassesDBO.php");
class Vatclasses
{				
	var $id;			
	var $name;			
	var $perc;	
	var $liabilityid;
	var $vatclassesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->perc=str_replace("'","\'",$obj->perc);
		if(empty($obj->liabilityid))
			$obj->liabilityid='NULL';
		$this->liabilityid=$obj->liabilityid;
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

	//get perc
	function getPerc(){
		return $this->perc;
	}
	//set perc
	function setPerc($perc){
		$this->perc=$perc;
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
