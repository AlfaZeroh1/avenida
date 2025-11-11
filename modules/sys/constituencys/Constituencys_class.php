<?php 
require_once("ConstituencysDBO.php");
class Constituencys
{				
	var $id;			
	var $name;			
	var $constituencysDBO;
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
		$constituencysDBO = new ConstituencysDBO();
		if($constituencysDBO->persist($obj)){
			$this->id=$constituencysDBO->id;
			$this->sql=$constituencysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$constituencysDBO = new ConstituencysDBO();
		if($constituencysDBO->update($obj,$where)){
			$this->sql=$constituencysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$constituencysDBO = new ConstituencysDBO();
		if($constituencysDBO->delete($obj,$where=""))		
			$this->sql=$constituencysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$constituencysDBO = new ConstituencysDBO();
		$this->table=$constituencysDBO->table;
		$constituencysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$constituencysDBO->sql;
		$this->result=$constituencysDBO->result;
		$this->fetchObject=$constituencysDBO->fetchObject;
		$this->affectedRows=$constituencysDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
