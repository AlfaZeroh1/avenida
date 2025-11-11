<?php 
require_once("NationalitysDBO.php");
class Nationalitys
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $nationalitysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	function add($obj){
		$nationalitysDBO = new NationalitysDBO();
		if($nationalitysDBO->persist($obj)){
			$this->id=$nationalitysDBO->id;
			$this->sql=$nationalitysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$nationalitysDBO = new NationalitysDBO();
		if($nationalitysDBO->update($obj,$where)){
			$this->sql=$nationalitysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$nationalitysDBO = new NationalitysDBO();
		if($nationalitysDBO->delete($obj,$where=""))		
			$this->sql=$nationalitysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$nationalitysDBO = new NationalitysDBO();
		$this->table=$nationalitysDBO->table;
		$nationalitysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$nationalitysDBO->sql;
		$this->result=$nationalitysDBO->result;
		$this->fetchObject=$nationalitysDBO->fetchObject;
		$this->affectedRows=$nationalitysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Nationality should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
