<?php 
require_once("OrderdetailsDBO.php");
class Orderdetails
{				
	var $id;
	var $brancheid2;
	var $itemid;	
	var $sizeid;
	var $quantity;	
	var $price;
	var $memo;
	var $warmth;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $orderid;			
	var $orderdetailsDBO;
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
		if(empty($obj->sizeid))
			$obj->sizeid='NULL';
		$this->sizeid=$obj->sizeid;
		$this->warmth=$obj->warmth;
		$this->brancheid2=$obj->brancheid2;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->price=str_replace("'","\'",$obj->price);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		if(empty($obj->orderid))
			$obj->orderid='NULL';
		$this->orderid=$obj->orderid;
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

	//get orderid
	function getOrderid(){
		return $this->orderid;
	}
	//set orderid
	function setOrderid($orderid){
		$this->orderid=$orderid;
	}

	function add($obj,$shop){
		$orderdetailsDBO = new OrderdetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->itemid=$shop[$i]['itemid'];
			$obj->sizeid=$shop[$i]['sizeid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->price=$shop[$i]['price'];
			$obj->memo=$shop[$i]['memo'];
			$obj->warmth=$shop[$i]['warmth'];
			$obj->brancheid2=$shop[$i]['brancheid2'];
			
			$ob = $this->setObject($obj);
			
			if($orderdetailsDBO->persist($ob)){		
				
				$query="select * from inv_compositeitems where itemid='$obj->itemid'";
				$r = mysql_fetch_object(mysql_query($query));
				
				if(!empty($r->itemid2)){
				  $obj->itemid=$r->itemid2;
				  $obj->quantity=$r->quantity*$obj->quantity;
				}
				//reduce branch stocks
// 				$query="update inv_branchstocks set quantity=(quantity-$obj->quantity) where itemid='$obj->itemid' and brancheid='$obj->brancheid'";logging($query);
// 				mysql_query($query);
				
				
				$branchstockss = new Branchstocks();
				$fields="*";
				$where=" where itemid='$obj->itemid' and brancheid='$obj->brancheid' ";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$branchstockss->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				      
				$branchstocks = new Branchstocks();
				$branchstocks->brancheid=$obj->brancheid;
				$branchstocks->itemid=$obj->itemid;
				$branchstocks->itemdetailid=$obj->itemdetailid;
				$branchstocks->documentno=$obj->orderno;
				$branchstocks->recorddate=$obj->orderedon;
				$branchstocks->quantity=$obj->quantity;
				$branchstocks->transactionid=$transaction->id;
				
				$branchstocks->transaction="Order";
				
				if($branchstockss->affectedRows>0){
				  $branchstockss = $branchstockss->fetchObject;
				  
				  $branchstockss->transaction="Order";
				  $branchstockss->recorddate=$obj->orderedon;
				  $branchstockss->documentno=$obj->orderno;
				  
				  $branchstockss->quantity+=($obj->quantity*-1);
				  $branchstockss->quantitys=$obj->quantity*-1;
				  $branchstockss->recorddate=$obj->orderedon;
				  
				  $branchstocks->edit($branchstockss);
				  
				}else{
// 				  $branchstocks->quantity=($obj->quantity*-1);
				  $branchstocks->quantity=$obj->quantity*-1;
				  $branchstocks->quantity=$obj->quantity*-1;
				  $branchstocks->add($branchstocks);
				}
				
				$this->id=$orderdetailsDBO->id;
				$this->sql=$orderdetailsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where=""){
		$orderdetailsDBO = new OrderdetailsDBO();
		if($orderdetailsDBO->update($obj,$where)){
			$this->sql=$orderdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$orderdetailsDBO = new OrderdetailsDBO();
		if($orderdetailsDBO->delete($obj,$where=""))		
			$this->sql=$orderdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$orderdetailsDBO = new OrderdetailsDBO();
		$this->table=$orderdetailsDBO->table;
		$orderdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$orderdetailsDBO->sql;
		$this->result=$orderdetailsDBO->result;
		$this->fetchObject=$orderdetailsDBO->fetchObject;
		$this->affectedRows=$orderdetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Product should be provided";
		}
		else if(empty($obj->quantity)){
			$error="Quantity should be provided";
		}
		else if(empty($obj->orderid)){
			$error="Order should be provided";
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
