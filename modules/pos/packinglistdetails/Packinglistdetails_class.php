<?php 
require_once("PackinglistdetailsDBO.php");
class Packinglistdetails
{				
	var $id;			
	var $packinglistid;			
	var $itemid;			
	var $quantity;			
	var $memo;			
	var $ipaddress;		
	var $barcode;	
	var $datecode;	
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $packinglistdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->packinglistid))
			$obj->packinglistid='NULL';
		$this->packinglistid=$obj->packinglistid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->barcode=str_replace("'","\'",$obj->barcode);
		$this->datecode=str_replace("'","\'",$obj->datecode);
		$this->memo=str_replace("'","\'",$obj->memo);
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

	//get packinglistid
	function getPackinglistid(){
		return $this->packinglistid;
	}
	//set packinglistid
	function setPackinglistid($packinglistid){
		$this->packinglistid=$packinglistid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}
	
	//get sizeid
	function getSizeid(){
		return $this->sizeid;
	}
	//set sizeid
	function setSizeid($sizeid){
		$this->sizeid=$sizeid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
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
		$packinglistdetailsDBO = new PackinglistdetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->remarks=$shop[$i]['remarks'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->sizeid=$shop[$i]['sizeid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->barcode=$shop[$i]['barcode'];
			$obj->datecode=$shop[$i]['datecode'];
			if($obj->returns==1){
			  $obj->quantity*=-1;
			}
			$obj->memo=$shop[$i]['memo'];

			//this deletes the first element in the array
//                         if($i<$obj->iterator-1)
//                                 $shop=array_slice($shop,1);		

			if($packinglistdetailsDBO->persist($obj)){	
			
			if($obj->returns==1){
			  $obj->quantity*=-1;
			}
				$itemstocks = new Itemstocks();
			
			      $barcode=$obj->barcode;
			      $cod=strrpos($barcode,'=');
			      $cc=substr($barcode,0,($cod));
				
			      if($obj->returns==1){
				 $itemstocks->addStock($obj);
				 $query="UPDATE post_barcodes set status=1 where barcode='$cc'";//echo $query;
				 mysql_query($query);
			      }else{
				 $itemstocks->reduceStock($obj);
				 $query="UPDATE post_barcodes set status=2 where barcode='$cc'";//echo $query;
				 mysql_query($query);
			      }
			  
				$this->id=$packinglistdetailsDBO->id;
				$this->sql=$packinglistdetailsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where=""){
		$packinglistdetailsDBO = new PackinglistdetailsDBO();
		if($packinglistdetailsDBO->update($obj,$where)){
			$this->sql=$packinglistdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$packinglistdetailsDBO = new PackinglistdetailsDBO();
		if($packinglistdetailsDBO->delete($obj,$where=""))		
			$this->sql=$packinglistdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$packinglistdetailsDBO = new PackinglistdetailsDBO();
		$this->table=$packinglistdetailsDBO->table;
		$packinglistdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$packinglistdetailsDBO->sql;
		$this->result=$packinglistdetailsDBO->result;
		$this->fetchObject=$packinglistdetailsDBO->fetchObject;
		$this->affectedRows=$packinglistdetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->packinglistid)){
			$error="Packing List should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Product should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
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
