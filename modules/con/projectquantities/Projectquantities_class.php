<?php 
require_once("ProjectquantitiesDBO.php");
class Projectquantities
{				
	var $id;			
	var $projectid;			
	var $projectboqdetailid;			
	var $itemid;			
	var $labourid;			
	var $categoryid;			
	var $subcategoryid;			
	var $quantity;			
	var $rate;			
	var $remarks;			
	var $projectweek;			
	var $week;			
	var $year;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectquantitiesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->projectboqdetailid))
			$obj->projectboqdetailid='NULL';
		$this->projectboqdetailid=$obj->projectboqdetailid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->labourid))
			$obj->labourid='NULL';
		$this->labourid=$obj->labourid;
		if(empty($obj->categoryid))
			$obj->categoryid='NULL';
		$this->categoryid=$obj->categoryid;
		if(empty($obj->subcategoryid))
			$obj->subcategoryid='NULL';
		$this->subcategoryid=$obj->subcategoryid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->rate=str_replace("'","\'",$obj->rate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->projectweek=str_replace("'","\'",$obj->projectweek);
		$this->week=str_replace("'","\'",$obj->week);
		$this->year=str_replace("'","\'",$obj->year);
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

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get projectboqdetailid
	function getProjectboqdetailid(){
		return $this->projectboqdetailid;
	}
	//set projectboqdetailid
	function setProjectboqdetailid($projectboqdetailid){
		$this->projectboqdetailid=$projectboqdetailid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get labourid
	function getLabourid(){
		return $this->labourid;
	}
	//set labourid
	function setLabourid($labourid){
		$this->labourid=$labourid;
	}

	//get categoryid
	function getCategoryid(){
		return $this->categoryid;
	}
	//set categoryid
	function setCategoryid($categoryid){
		$this->categoryid=$categoryid;
	}

	//get subcategoryid
	function getSubcategoryid(){
		return $this->subcategoryid;
	}
	//set subcategoryid
	function setSubcategoryid($subcategoryid){
		$this->subcategoryid=$subcategoryid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get rate
	function getRate(){
		return $this->rate;
	}
	//set rate
	function setRate($rate){
		$this->rate=$rate;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get projectweek
	function getProjectweek(){
		return $this->projectweek;
	}
	//set projectweek
	function setProjectweek($projectweek){
		$this->projectweek=$projectweek;
	}

	//get week
	function getWeek(){
		return $this->week;
	}
	//set week
	function setWeek($week){
		$this->week=$week;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
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
		$projectquantitiesDBO = new ProjectquantitiesDBO();
		if($projectquantitiesDBO->persist($obj)){
			$this->id=$projectquantitiesDBO->id;
			$this->sql=$projectquantitiesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectquantitiesDBO = new ProjectquantitiesDBO();
		if($projectquantitiesDBO->update($obj,$where)){
			$this->sql=$projectquantitiesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectquantitiesDBO = new ProjectquantitiesDBO();
		if($projectquantitiesDBO->delete($obj,$where=""))		
			$this->sql=$projectquantitiesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectquantitiesDBO = new ProjectquantitiesDBO();
		$this->table=$projectquantitiesDBO->table;
		$projectquantitiesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectquantitiesDBO->sql;
		$this->result=$projectquantitiesDBO->result;
		$this->fetchObject=$projectquantitiesDBO->fetchObject;
		$this->affectedRows=$projectquantitiesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->projectid)){
			$error="Project should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->projectid)){
			$error="Project should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
