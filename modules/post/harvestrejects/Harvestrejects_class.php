<?php 
require_once("HarvestrejectsDBO.php");
class Harvestrejects
{				
	var $id;
	var $documentno;
	var $rejecttypeid;			
	var $sizeid;	
	var $blockid;
	var $greenhouseid;
	var $itemid;			
	var $quantity;			
	var $gradedon;			
	var $reportedon;			
	var $employeeid;			
	var $barcode;
	var $datecode;
	var $remarks;			
	var $status;
	var $reduce;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $harvestrejectsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->rejecttypeid))
			$obj->rejecttypeid='NULL';
		$this->rejecttypeid=$obj->rejecttypeid;
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		if(empty($obj->blockid))
			$obj->blockid='NULL';
		$this->blockid=$obj->blockid;
		if(empty($obj->greenhouseid))
			$obj->greenhouseid='NULL';
		$this->greenhouseid=$obj->greenhouseid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->gradedon=str_replace("'","\'",$obj->gradedon);
		$this->reportedon=str_replace("'","\'",$obj->reportedon);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->barcode=str_replace("'","\'",$obj->barcode);
		$this->datecode=str_replace("'","\'",$obj->datecode);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
		$this->reduce=str_replace("'","\'",$obj->reduce);
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

	//get rejecttypeid
	function getRejecttypeid(){
		return $this->rejecttypeid;
	}
	//set rejecttypeid
	function setRejecttypeid($rejecttypeid){
		$this->rejecttypeid=$rejecttypeid;
	}

	//get sizeid
	function getSizeid(){
		return $this->sizeid;
	}
	//set sizeid
	function setSizeid($sizeid){
		$this->sizeid=$sizeid;
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

	//get gradedon
	function getGradedon(){
		return $this->gradedon;
	}
	//set gradedon
	function setGradedon($gradedon){
		$this->gradedon=$gradedon;
	}

	//get reportedon
	function getReportedon(){
		return $this->reportedon;
	}
	//set reportedon
	function setReportedon($reportedon){
		$this->reportedon=$reportedon;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get barcode
	function getBarcode(){
		return $this->barcode;
	}
	//set barcode
	function setBarcode($barcode){
		$this->barcode=$barcode;
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
	
	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
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

	function add($obj, $shop){
	
	      
	if(empty($obj->action)){
	$defs=mysql_fetch_object(mysql_query("select max(documentno)+1 documentno from post_harvestrejects "));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;



}

		$harvestrejectsDBO = new HarvestrejectsDBO();
		$num=count($shop);echo $num;
		$i=0;
		$total=0;
		
		$obj->remarks=$obj->status;
		
		while($i<$num){
		  $obj->sizeid=$shop[$i]['sizeid'];
		  $obj->sizename=$shop[$i]['sizename'];
		   $obj->blockid=$shop[$i]['blockid'];
		  $obj->blockname=$shop[$i]['blockname'];
		  $obj->itemid=$shop[$i]['itemid'];
		  $obj->itemname=$shop[$i]['itemname'];
		  $obj->quantity=$shop[$i]['quantity'];
		  $obj->documentno=$shop[$i]['documentno'];
		  $obj->barcode=$shop[$i]['barcode'];
		  $obj->datecode=$shop[$i]['datecode'];
		  $obj->employeeid=$shop[$i]['employeeid'];
		  $obj->employeename=$shop[$i]['employeename'];
		  $obj->rejecttypeid=$shop[$i]['rejecttypeid'];
		  $obj->remarks=$shop[$i]['remarks'];
		  
		  $ob = $this->setObject($obj);
		  $ress=mysql_fetch_object(mysql_query("SELECT * from pos_saletracks order by id desc limit 1"));
		  
		  $remain=$ress->remain+$obj->quantity;
		  
		 $query="INSERT into pos_saletracks (documentno,quantity,remain,status,recordedon,createdby,createdon,lasteditedby,lasteditedon,ipaddress) values ('$obj->documentno','$obj->quantity','$remain','harvestrejects','$obj->reportedon','$obj->createdby', '$obj->createdon', '$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')"; //echo $query; 
		 $salestocks=mysql_fetch_object(mysql_query($query)); 
		  $i++;
		  if($harvestrejectsDBO->persist($ob)){
			
		  
		 
		
			//record item stocks		
			if($obj->reduce=="reduce")
			{
			  $itemstocks = new Itemstocks();
			  $itemstocks->reduceStock($obj);
			  
			  $barcode=$obj->barcode;
			  $cod=strrpos($barcode,'=');
			  $cc=substr($barcode,0,($cod));
			  $query="UPDATE post_barcodes set status=2 where barcode='$cc'";//echo $query;
			  mysql_query($query);
			}				
				
		}
	      }
	      
	      return true;
		
	}
	
	function edit($obj,$shop,$where=""){
		$harvestrejectsDBO = new HarvestrejectsDBO();
		if($harvestrejectsDBO->update($obj,$where)){
			$this->sql=$harvestrejectsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$harvestrejectsDBO = new HarvestrejectsDBO();
		if($harvestrejectsDBO->delete($obj,$where=""))		
			$this->sql=$harvestrejectsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$harvestrejectsDBO = new HarvestrejectsDBO();
		$this->table=$harvestrejectsDBO->table;
		$harvestrejectsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$harvestrejectsDBO->sql;
		$this->result=$harvestrejectsDBO->result;
		$this->fetchObject=$harvestrejectsDBO->fetchObject;
		$this->affectedRows=$harvestrejectsDBO->affectedRows;
		
		
	}			
	function validate($obj){
		
		if(empty($obj->gradedon)){
			$error="Date Graded should be provided";
		}
// 		else if(empty($obj->employeeid)){
// 			$error="Employee should be provided";
// 		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->gradedon)){
			$error="Date Graded should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Employee should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
