<?php 
require_once("SubdividesDBO.php");
class Subdivides
{				
	var $id;			
	var $documentno;			
	var $itemid;			
	var $newitemid;			
	var $subdividedon;			
	var $type;			
	var $remarks;			
	var $memo;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $subdividesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->newitemid))
			$obj->newitemid='NULL';
		$this->newitemid=$obj->newitemid;
		$this->subdividedon=str_replace("'","\'",$obj->subdividedon);
		$this->type=str_replace("'","\'",$obj->type);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get newitemid
	function getNewitemid(){
		return $this->newitemid;
	}
	//set newitemid
	function setNewitemid($newitemid){
		$this->newitemid=$newitemid;
	}

	//get subdividedon
	function getSubdividedon(){
		return $this->subdividedon;
	}
	//set subdividedon
	function setSubdividedon($subdividedon){
		$this->subdividedon=$subdividedon;
	}

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj,$shop){
		$subdividesDBO = new SubdividesDBO();
			if($subdividesDBO->persist($obj)){		
				$this->id=$subdividesDBO->id;
				$this->sql=$subdividesDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$subdividesDBO = new SubdividesDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$subdividesDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			if($subdividesDBO->update($obj,$where)){
				$this->sql=$subdividesDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$subdividesDBO = new SubdividesDBO();
		if($subdividesDBO->delete($obj,$where=""))		
			$this->sql=$subdividesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$subdividesDBO = new SubdividesDBO();
		$this->table=$subdividesDBO->table;
		$subdividesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$subdividesDBO->sql;
		$this->result=$subdividesDBO->result;
		$this->fetchObject=$subdividesDBO->fetchObject;
		$this->affectedRows=$subdividesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->id)){
			$error=" should be provided";
		}
		else if(empty($obj->documentno)){
			$error="Voucher should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Item should be provided";
		}
		else if(empty($obj->newitemid)){
			$error="New Item should be provided";
		}
		else if(empty($obj->subdividedon)){
			$error="Subdivided On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Voucher should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
