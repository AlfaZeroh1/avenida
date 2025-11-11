<?php 
require_once("PlotpenaltysDBO.php");
class Plotpenaltys
{				
	var $id;			
	var $plotid;			
	var $month;			
	var $year;			
	var $remarks;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $plotpenaltysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->plotid=str_replace("'","\'",$obj->plotid);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
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

	//get plotid
	function getPlotid(){
		return $this->plotid;
	}
	//set plotid
	function setPlotid($plotid){
		$this->plotid=$plotid;
	}

	//get month
	function getMonth(){
		return $this->month;
	}
	//set month
	function setMonth($month){
		$this->month=$month;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}
	
	//get createdby
	function getCreatedby(){
		return $this->createdby;
	}
	//set createdby
	function setCreatedby($createdby){
		$this->createdby=$createdby;
	}
	
	//get createdon
	function getCreatedon(){
		return $this->createdon;
	}
	//set createdon
	function setCreatedon($createdon){
		$this->createdon=$createdon;
	}
	
	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}
	
	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	function add($obj){
		$plotpenaltysDBO = new PlotpenaltysDBO();
		if($plotpenaltysDBO->persist($obj)){
			$this->id=$plotpenaltysDBO->id;
			$this->sql=$plotpenaltysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$plotpenaltysDBO = new PlotpenaltysDBO();
		if($plotpenaltysDBO->update($obj,$where)){
			$this->sql=$plotpenaltysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$plotpenaltysDBO = new PlotpenaltysDBO();
		if($plotpenaltysDBO->delete($obj,$where=""))		
			$this->sql=$plotpenaltysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$plotpenaltysDBO = new PlotpenaltysDBO();
		$this->table=$plotpenaltysDBO->table;
		$plotpenaltysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$plotpenaltysDBO->sql;
		$this->result=$plotpenaltysDBO->result;
		$this->fetchObject=$plotpenaltysDBO->fetchObject;
		$this->affectedRows=$plotpenaltysDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
