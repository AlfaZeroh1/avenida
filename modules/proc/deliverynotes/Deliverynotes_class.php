<?php 
require_once("DeliverynotesDBO.php");
require_once("../../../modules/proc/deliverynotedetails/DeliverynotedetailsDBO.php");
class Deliverynotes
{				
	var $id;			
	var $documentno;			
	var $lpono;			
	var $projectid;			
	var $supplierid;			
	var $deliveredon;			
	var $remarks;			
	var $file;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $deliverynotesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->lpono=str_replace("'","\'",$obj->lpono);
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		$this->deliveredon=str_replace("'","\'",$obj->deliveredon);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->file=str_replace("'","\'",$obj->file);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get lpono
	function getLpono(){
		return $this->lpono;
	}
	//set lpono
	function setLpono($lpono){
		$this->lpono=$lpono;
	}

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get deliveredon
	function getDeliveredon(){
		return $this->deliveredon;
	}
	//set deliveredon
	function setDeliveredon($deliveredon){
		$this->deliveredon=$deliveredon;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get file
	function getFile(){
		return $this->file;
	}
	//set file
	function setFile($file){
		$this->file=$file;
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
		$deliverynotesDBO = new DeliverynotesDBO();
			if($deliverynotesDBO->persist($obj)){		
				$deliverynotedetails = new Deliverynotedetails();
				$obj->deliverynoteid=$deliverynotesDBO->id;
				
				$deliverynotedetails->add($obj,$shop);

				$this->id=$deliverynotesDBO->id;
				$this->sql=$deliverynotesDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$deliverynotesDBO = new DeliverynotesDBO();

		$deliverynotes  = new Deliverynotes();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where documentno='$obj->documentno'";
		$deliverynotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$deliverynotes=$deliverynotes->fetchObject;
		
		$deliverynotedetails = new Deliverynotedetails();
		$where=" where deliverynoteid='$deliverynotes->id' ";
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$deliverynotedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		while($row=mysql_fetch_object($deliverynotedetails->result)){
		  $stocktrack = new Stocktrack();
		  $row->quantity*=-1;
		  $row->id="";
		  $row->documentno=$obj->documentno;
		  $row->deliveredon=$obj->deliveredon;
		  $row->transaction=$obj->transaction;
		  $stocktrack->addStock($row);
		  
		  $where="";
		  
		  $dld = new Deliverynotedetails();
		  $dld->delete($row,$where);
		}
		
				
		
		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$deliverynotesDBO->delete($obj,$where);

		if($this->add($obj,$shop))
		  return true;		
	}			
	function delete($obj,$where=""){			
		$deliverynotesDBO = new DeliverynotesDBO();
		if($deliverynotesDBO->delete($obj,$where=""))		
			$this->sql=$deliverynotesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$deliverynotesDBO = new DeliverynotesDBO();
		$this->table=$deliverynotesDBO->table;
		$deliverynotesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$deliverynotesDBO->sql;
		$this->result=$deliverynotesDBO->result;
		$this->fetchObject=$deliverynotesDBO->fetchObject;
		$this->affectedRows=$deliverynotesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Delivery Note should be provided";
		}
		else if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
		else if(empty($obj->deliveredon)){
			$error="Delivery Date should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Delivery Note should be provided";
		}
		else if(empty($obj->supplierid)){
			$error="Supplier should be provided";
		}
		else if(empty($obj->deliveredon)){
			$error="Delivery Date should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
