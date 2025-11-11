<?php 
require_once("ItemdetailsDBO.php");
class Itemdetails
{				
	var $id;			
	var $itemid;			
	var $brancheid;			
	var $serialno;			
	var $documentno;
	var $instalcode;
	var $crdcode;
	var $status;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $itemdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
		$this->serialno=str_replace("'","\'",$obj->serialno);
		$this->instalcode=str_replace("'","\'",$obj->instalcode);
		$this->crdcode=str_replace("'","\'",$obj->crdcode);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get brancheid
	function getBrancheid(){
		return $this->brancheid;
	}
	//set brancheid
	function setBrancheid($brancheid){
		$this->brancheid=$brancheid;
	}

	//get serialno
	function getSerialno(){
		return $this->serialno;
	}
	//set serialno
	function setSerialno($serialno){
		$this->serialno=$serialno;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		$itemdetailsDBO = new ItemdetailsDBO();
		if($itemdetailsDBO->persist($obj)){
			$this->id=$itemdetailsDBO->id;
			$this->sql=$itemdetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$itemdetailsDBO = new ItemdetailsDBO();
		if($itemdetailsDBO->update($obj,$where)){
			$this->sql=$itemdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$itemdetailsDBO = new ItemdetailsDBO();
		if($itemdetailsDBO->delete($obj,$where=""))		
			$this->sql=$itemdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$itemdetailsDBO = new ItemdetailsDBO();
		$this->table=$itemdetailsDBO->table;
		$itemdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$itemdetailsDBO->sql;
		$this->result=$itemdetailsDBO->result;
		$this->fetchObject=$itemdetailsDBO->fetchObject;
		$this->affectedRows=$itemdetailsDBO->affectedRows;
	}
	function addSerials($obj){
		
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='purchases'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		//make serials and insert
		while($x<$obj->quantity){
		  $itemdetails = new Itemdetails();
		  $itemdetails->documentno=$obj->documentno;
		  $itemdetails->itemid=$obj->itemid;
		  $itemdetails->status=1;
		  $itemdetails->brancheid=$obj->brancheid;
		  $itemdetails->serialno=$this->serialNewNo($obj);		  
		  $itemdetails = $itemdetails->setObject($itemdetails);
		  $itemdetails->add($itemdetails);
		  
		  $branchstocks = new Branchstocks();
		  $branchstocks->brancheid=$obj->brancheid;
		  $branchstocks->itemid=$obj->itemid;
		  $branchstocks->itemdetailid=$itemdetails->id;
		  $branchstocks->documentno=$obj->documentno;
		  $branchstocks->recorddate=$obj->recorddate;
		  $branchstocks->quantity=1;
		  $branchstocks->transactionid=$transaction->id;
		  $branchstocks = $branchstocks->setObject($branchstocks);
		  $branchstocks->add($branchstocks);
		  
		  $x++;
		}
	}
	
	function serialNewNo($obj){
	  $itemdetails = new Itemdetails();
	  $fields=" inv_items.code,(count(inv_itemdetails.id)+1) serialno ";
	  $join=" left join inv_items on inv_items.id=inv_itemdetails.itemid";
	  $groupby="";
	  $having="";
	  $where=" where inv_items.id='$obj->itemid'";
	  $itemdetails->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  $itemdetails=$itemdetails->fetchObject;
	  
	  $itemdetails->serialno=$itemdetails->code."_".str_pad($itemdetails->serialno,4,"0",STR_PAD_LEFT);
	  
	  return $itemdetails->serialno;
	  
	}
	
	
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Product should be provided";
		}
		else if(empty($obj->serialno)){
			$error="Serial No should be provided";
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
