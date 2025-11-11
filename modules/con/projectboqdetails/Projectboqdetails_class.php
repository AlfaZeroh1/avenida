<?php 
require_once("ProjectboqdetailsDBO.php");
class Projectboqdetails
{				
	var $id;			
	var $projectboqid;			
	var $materialcategoryid;			
	var $materialsubcategoryid;			
	var $estimationmanualid;			
	var $unitofmeasureid;			
	var $quantity;			
	var $rate;			
	var $total;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectboqdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->projectboqid))
			$obj->projectboqid='NULL';
		$this->projectboqid=$obj->projectboqid;
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->materialcategoryid))
			$obj->materialcategoryid='NULL';
		$this->materialcategoryid=$obj->materialcategoryid;
		if(empty($obj->materialsubcategoryid))
			$obj->materialsubcategoryid='NULL';
		$this->materialsubcategoryid=$obj->materialsubcategoryid;
		if(empty($obj->estimationmanualid))
			$obj->estimationmanualid='NULL';
		$this->estimationmanualid=$obj->estimationmanualid;
		if(empty($obj->unitofmeasureid))
			$obj->unitofmeasureid='NULL';
		$this->unitofmeasureid=$obj->unitofmeasureid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->rate=str_replace("'","\'",$obj->rate);
		$this->total=str_replace("'","\'",$obj->total);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get projectboqid
	function getProjectboqid(){
		return $this->projectboqid;
	}
	//set projectboqid
	function setProjectboqid($projectboqid){
		$this->projectboqid=$projectboqid;
	}

	//get materialcategoryid
	function getMaterialcategoryid(){
		return $this->materialcategoryid;
	}
	//set materialcategoryid
	function setMaterialcategoryid($materialcategoryid){
		$this->materialcategoryid=$materialcategoryid;
	}

	//get materialsubcategoryid
	function getMaterialsubcategoryid(){
		return $this->materialsubcategoryid;
	}
	//set materialsubcategoryid
	function setMaterialsubcategoryid($materialsubcategoryid){
		$this->materialsubcategoryid=$materialsubcategoryid;
	}

	//get estimationmanualid
	function getEstimationmanualid(){
		return $this->estimationmanualid;
	}
	//set estimationmanualid
	function setEstimationmanualid($estimationmanualid){
		$this->estimationmanualid=$estimationmanualid;
	}

	//get unitofmeasureid
	function getUnitofmeasureid(){
		return $this->unitofmeasureid;
	}
	//set unitofmeasureid
	function setUnitofmeasureid($unitofmeasureid){
		$this->unitofmeasureid=$unitofmeasureid;
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

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$projectboqdetailsDBO = new ProjectboqdetailsDBO();
		if($projectboqdetailsDBO->persist($obj)){
			//$this->id=$projectboqdetailsDBO->id;
			
			if(!empty($obj->estimationmanualid)){
			  //add estimation manual quantities into project quantities
			  $estimationmanualitems = new Estimationmanualitems();
			  $fields="*";
			  $where=" where estimationmanualid='$obj->estimationmanualid'";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $estimationmanualitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  while($row=mysql_fetch_object($estimationmanualitems->result)){
			  
			    $projectquantities->labourid=NULL;
			    $projectquantities->itemid=NULL;
			    
			    $projectquantities = new Projectquantities();
			    $projectquantities->projectboqdetailid=$projectboqdetailsDBO->id;
			    
			    $projectquantities->projectid=$obj->projectid;
			    $projectquantities->itemid=$row->itemid;
			    $projectquantities->labourid=$row->labourid;
			    $projectquantities->quantity=$row->quantity;
			    
			    if($row->itemid>0){
			      $items = new Items();
			      $fields="*";
			      $where=" where id='$row->itemid' ";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $items->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $items->sql;
			      $items = $items->fetchObject;
			      
			      $projectquantities->rate=$items->retailprice;
			     }
			    else if($row->labourid>0){
			      $labours = Labours();
			      $fields="*";
			      $where=" where id='$row->labourid' ";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $labours->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			      $labours = $labours->fetchObject;
			      
			      $projectquantities->rate=$labours->rate;
			     }
			    $projectquantities->total=$estimationmanualitems->quantity*$estimationmanualitems->quantity;
			    $projectquantities->setObject($projectquantities);
			    $projectquantities->add($projectquantities);
			    
			  }
			}
			
			$this->sql=$projectboqdetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectboqdetailsDBO = new ProjectboqdetailsDBO();
		if($projectboqdetailsDBO->update($obj,$where)){
			$this->sql=$projectboqdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectboqdetailsDBO = new ProjectboqdetailsDBO();
		if($projectboqdetailsDBO->delete($obj,$where=""))		
			$this->sql=$projectboqdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectboqdetailsDBO = new ProjectboqdetailsDBO();
		$this->table=$projectboqdetailsDBO->table;
		$projectboqdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectboqdetailsDBO->sql;
		$this->result=$projectboqdetailsDBO->result;
		$this->fetchObject=$projectboqdetailsDBO->fetchObject;
		$this->affectedRows=$projectboqdetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->projectboqid)){
			$error="BoQ Item should be provided";
		}
		else if(empty($obj->estimationmanualid)){
			$error="Estimation Manual Item should be provided";
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
