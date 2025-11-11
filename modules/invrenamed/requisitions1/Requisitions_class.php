<?php 
require_once("RequisitionsDBO.php");
class Requisitions
{				
	var $id;			
	var $brancheid;			
	var $employeeid;			
	var $documentno;			
	var $itemid;			
	var $quantity;			
	var $aquantity;
	var $reorderlevel;
	var $maxreorderlevel;
	var $stock;
	var $memo;			
	var $requisitiondate;			
	var $remarks;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $requisitionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
		
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->aquantity=str_replace("'","\'",$obj->aquantity);
		$this->maxreorderlevel=str_replace("'","\'",$obj->maxreorderlevel);
		$this->reorderlevel=str_replace("'","\'",$obj->reorderlevel);
		$this->stock=str_replace("'","\'",$obj->stock);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->requisitiondate=str_replace("'","\'",$obj->requisitiondate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=2;
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

	//get brancheid
	function getBrancheid(){
		return $this->brancheid;
	}
	//set brancheid
	function setBrancheid($brancheid){
		$this->brancheid=$brancheid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
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

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
	}

	//get requisitiondate
	function getRequisitiondate(){
		return $this->requisitiondate;
	}
	//set requisitiondate
	function setRequisitiondate($requisitiondate){
		$this->requisitiondate=$requisitiondate;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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

	function add($obj,$shop){
		$requisitionsDBO = new RequisitionsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		
		if($obj->action=="Approve")
		  $obj->status=2;
		  
		while($i<$num){
			$obj->itemid=$shop[$i]['itemid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->aquantity=$shop[$i]['aquantity'];
			$obj->memo=$shop[$i]['memo'];
			
			$ob = $this->setObject($obj);
			
			if($requisitionsDBO->persist($obj)){
				$this->sql=$requisitionsDBO->sql;
			}
			$i++;
		}		
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$requisitionsDBO = new RequisitionsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$requisitionsDBO->delete($obj,$where);

		$this->add($obj,$shop);
		
		return true;	
	}			
	function delete($obj,$where=""){			
		$requisitionsDBO = new RequisitionsDBO();
		if($requisitionsDBO->delete($obj,$where=""))		
			$this->sql=$requisitionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$requisitionsDBO = new RequisitionsDBO();
		$this->table=$requisitionsDBO->table;
		$requisitionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$requisitionsDBO->sql;
		$this->result=$requisitionsDBO->result;
		$this->fetchObject=$requisitionsDBO->fetchObject;
		$this->affectedRows=$requisitionsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
