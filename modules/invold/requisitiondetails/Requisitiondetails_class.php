<?php 
require_once("RequisitiondetailsDBO.php");
class Requisitiondetails
{				
	var $id;			
	var $requisitionid;			
	var $itemid;			
	var $quantity;			
	var $aquantity;			
	var $purpose;			
	var $memo;			
	var $blockid;			
	var $sectionid;			
	var $greenhouseid;
	var $fleetid;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $requisitiondetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->requisitionid=str_replace("'","\'",$obj->requisitionid);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->aquantity=str_replace("'","\'",$obj->aquantity);
		$this->purpose=str_replace("'","\'",$obj->purpose);
		$this->memo=str_replace("'","\'",$obj->memo);
		if(empty($obj->blockid))
			$obj->blockid='NULL';
		$this->blockid=$obj->blockid;
		if(empty($obj->sectionid))
			$obj->sectionid='NULL';
		$this->sectionid=$obj->sectionid;
		if(empty($obj->greenhouseid))
			$obj->greenhouseid='NULL';
		$this->greenhouseid=$obj->greenhouseid;
		
		if(empty($obj->fleetid))
			$obj->fleetid='NULL';
		$this->fleetid=$obj->fleetid;
		
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

	//get requisitionid
	function getRequisitionid(){
		return $this->requisitionid;
	}
	//set requisitionid
	function setRequisitionid($requisitionid){
		$this->requisitionid=$requisitionid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get aquantity
	function getAquantity(){
		return $this->aquantity;
	}
	//set aquantity
	function setAquantity($aquantity){
		$this->aquantity=$aquantity;
	}

	//get purpose
	function getPurpose(){
		return $this->purpose;
	}
	//set purpose
	function setPurpose($purpose){
		$this->purpose=$purpose;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
	}

	//get blockid
	function getBlockid(){
		return $this->blockid;
	}
	//set blockid
	function setBlockid($blockid){
		$this->blockid=$blockid;
	}

	//get sectionid
	function getSectionid(){
		return $this->sectionid;
	}
	//set sectionid
	function setSectionid($sectionid){
		$this->sectionid=$sectionid;
	}

	//get greenhouseid
	function getGreenhouseid(){
		return $this->greenhouseid;
	}
	//set greenhouseid
	function setGreenhouseid($greenhouseid){
		$this->greenhouseid=$greenhouseid;
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

	function add($obj,$shop){
		$requisitiondetailsDBO = new RequisitiondetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->itemid=$shop[$i]['itemid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->blockid=$shop[$i]['blockid'];
			$obj->blockname=$shop[$i]['blockname'];
			$obj->remarks=$shop[$i]['remarks'];
			$obj->purpose=$shop[$i]['purpose'];
			$obj->aquantity=$shop[$i]['aquantity'];
			$obj->sectionid=$shop[$i]['sectionid'];
			$obj->fleetid=$shop[$i]['fleetid'];
			$obj->sectionname=$shop[$i]['sectionname'];
			$obj->greenhouseid=$shop[$i]['greenhouseid'];
			$obj->greenhousename=$shop[$i]['greenhousename'];
			
			$ob = $this->setObject($obj);
			if($requisitiondetailsDBO->persist($ob)){		
				$this->id=$requisitiondetailsDBO->id;
				$this->sql=$requisitiondetailsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$requisitiondetailsDBO = new RequisitiondetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		$id="'-1',";
		while($i<$num){
			$obj->itemid=$shop[$i]['itemid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->blockid=$shop[$i]['blockid'];
			$obj->blockname=$shop[$i]['blockname'];
			$obj->remarks=$shop[$i]['remarks'];
			$obj->purpose=$shop[$i]['purpose'];
			$obj->aquantity=$shop[$i]['aquantity'];
			$obj->sectionid=$shop[$i]['sectionid'];
			$obj->fleetid=$shop[$i]['fleetid'];
			$obj->sectionname=$shop[$i]['sectionname'];
			$obj->greenhouseid=$shop[$i]['greenhouseid'];
			$obj->greenhousename=$shop[$i]['greenhousename'];
			
			$ob = $this->setObject($obj);
			if(!empty($shop[$i]['id']))
			{ 
			    $where=" id='$obj->id' ";
			    if($requisitiondetailsDBO->update($obj,$where)){		
			      $id.=$shop[$i]['id'].",";
			    }
			
			}
			else{
			    if($requisitiondetailsDBO->persist($obj)){		
			      $id.=$requisitiondetailsDBO->id.",";
			      $this->sql=$requisitiondetailsDBO->sql;
			     }
			}	
			$i++;
		}
		$wid=substr($id,0,-1);		
		$requisitiondetailsDBO = new RequisitiondetailsDBO();
		$where=" where id not in ($wid) and requisitionid='$obj->requisitionid' ";
		$requisitiondetailsDBO->delete($obj,$where);
		return true;	
	}			
	function delete($obj,$where=""){			
		$requisitiondetailsDBO = new RequisitiondetailsDBO();
		if($requisitiondetailsDBO->delete($obj,$where=""))		
			$this->sql=$requisitiondetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$requisitiondetailsDBO = new RequisitiondetailsDBO();
		$this->table=$requisitiondetailsDBO->table;
		$requisitiondetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$requisitiondetailsDBO->sql;
		$this->result=$requisitiondetailsDBO->result;
		$this->fetchObject=$requisitiondetailsDBO->fetchObject;
		$this->affectedRows=$requisitiondetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->requisitionid)){
			$error="Requisition should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Product should be provided";
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
