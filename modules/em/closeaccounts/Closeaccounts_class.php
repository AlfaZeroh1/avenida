<?php 
require_once("CloseaccountsDBO.php");
class Closeaccounts
{				
	var $id;			
	var $plotid;			
	var $sttmtdate;			
	var $month;			
	var $year;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $closeaccountsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->plotid=str_replace("'","\'",$obj->plotid);
		$this->sttmtdate=str_replace("'","\'",$obj->sttmtdate);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->status=str_replace("'","\'",$obj->status);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get sttmtdate
	function getSttmtdate(){
		return $this->sttmtdate;
	}
	//set sttmtdate
	function setSttmtdate($sttmtdate){
		$this->sttmtdate=$sttmtdate;
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

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
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
		$closeaccountsDBO = new CloseaccountsDBO();
		if($closeaccountsDBO->persist($obj)){
			$this->id=$closeaccountsDBO->id;
			$this->sql=$closeaccountsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$closeaccountsDBO = new CloseaccountsDBO();
		if($closeaccountsDBO->update($obj,$where)){
			$this->sql=$closeaccountsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$closeaccountsDBO = new CloseaccountsDBO();
		if($closeaccountsDBO->delete($obj,$where=""))		
			$this->sql=$closeaccountsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$closeaccountsDBO = new CloseaccountsDBO();
		$this->table=$closeaccountsDBO->table;
		$closeaccountsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$closeaccountsDBO->sql;
		$this->result=$closeaccountsDBO->result;
		$this->fetchObject=$closeaccountsDBO->fetchObject;
		$this->affectedRows=$closeaccountsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
