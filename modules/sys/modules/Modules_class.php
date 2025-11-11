<?php 
require_once("ModulesDBO.php");
class Modules
{				
	var $id;			
	var $name;			
	var $description;			
	var $url;			
	var $position;			
	var $status;			
	var $indx;			
	var $modulesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->description=str_replace("'","\'",$obj->description);
		$this->url=str_replace("'","\'",$obj->url);
		$this->position=str_replace("'","\'",$obj->position);
		$this->status=str_replace("'","\'",$obj->status);
		$this->indx=str_replace("'","\'",$obj->indx);
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

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
	}

	//get url
	function getUrl(){
		return $this->url;
	}
	//set url
	function setUrl($url){
		$this->url=$url;
	}

	//get position
	function getPosition(){
		return $this->position;
	}
	//set position
	function setPosition($position){
		$this->position=$position;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get indx
	function getIndx(){
		return $this->indx;
	}
	//set indx
	function setIndx($indx){
		$this->indx=$indx;
	}

	function add($obj){
		$modulesDBO = new ModulesDBO();
		if($modulesDBO->persist($obj)){
			$this->id=$modulesDBO->id;
			$this->sql=$modulesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$modulesDBO = new ModulesDBO();
		if($modulesDBO->update($obj,$where)){
			$this->sql=$modulesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$modulesDBO = new ModulesDBO();
		if($modulesDBO->delete($obj,$where=""))		
			$this->sql=$modulesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$modulesDBO = new ModulesDBO();
		$this->table=$modulesDBO->table;
		$modulesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$modulesDBO->sql;
		$this->result=$modulesDBO->result;
		$this->fetchObject=$modulesDBO->fetchObject;
		$this->affectedRows=$modulesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
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
