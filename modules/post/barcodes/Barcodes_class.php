<?php 
session_start();
require_once("BarcodesDBO.php");
class Barcodes
{				
	var $id;			
	var $barcode;			
	var $greenhouseid;			
	var $itemid;			
	var $status;			
	var $generatedon;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $barcodesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->barcode=str_replace("'","\'",$obj->barcode);
		if(empty($obj->greenhouseid))
			$obj->greenhouseid='NULL';
		$this->greenhouseid=$obj->greenhouseid;
		$this->itemid=str_replace("'","\'",$obj->itemid);
		$this->status=str_replace("'","\'",$obj->status);
		$this->generatedon=str_replace("'","\'",$obj->generatedon);
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

	//get barcode
	function getBarcode(){
		return $this->barcode;
	}
	//set barcode
	function setBarcode($barcode){
		$this->barcode=$barcode;
	}

	//get greenhouseid
	function getGreenhouseid(){
		return $this->greenhouseid;
	}
	//set greenhouseid
	function setGreenhouseid($greenhouseid){
		$this->greenhouseid=$greenhouseid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get generatedon
	function getGeneratedon(){
		return $this->generatedon;
	}
	//set generatedon
	function setGeneratedon($generatedon){
		$this->generatedon=$generatedon;
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
		$barcodesDBO = new BarcodesDBO();
		if($barcodesDBO->persist($obj)){
			$this->id=$barcodesDBO->id;
			$this->sql=$barcodesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$barcodesDBO = new BarcodesDBO();
		if($barcodesDBO->update($obj,$where)){
			$this->sql=$barcodesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$barcodesDBO = new BarcodesDBO();
		if($barcodesDBO->delete($obj,$where=""))		
			$this->sql=$barcodesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$barcodesDBO = new BarcodesDBO();
		$this->table=$barcodesDBO->table;
		$barcodesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$barcodesDBO->sql;
		$this->result=$barcodesDBO->result;
		$this->fetchObject=$barcodesDBO->fetchObject;
		$this->affectedRows=$barcodesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->barcode)){
			$error="Bar Code should be provided";
		}
		else if(empty($obj->greenhouseid)){
			$error="Green House should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Variety should be provided";
		}
		else if(empty($obj->generatedon)){
			$error="Date should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->barcode)){
			$error="Bar Code should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
	
	function checkBarcode($code,$type,$shop){//logging($code);
	  $query="select * from post_barcodes where barcode='$code'";//logging($query);
	  $res = mysql_query($query);
	  $num = mysql_affected_rows();
	  $row=mysql_fetch_object($res);
	  
	  $nums=count($shop);
// 	  logging(print_r($shpgraded));
	  $barcodes="";
	  $i=0;
	  while($i<$nums){ 
// 		$barcodess=$code;
// 		$barcode=$shpgraded[$i]['barcode'];
// 		$cod=strrpos($barcode,'=');
// 	        $cc=substr($barcode,0,$cod);
		  $barcode=$shop[$i]['barcode'];
		  $cod=strrpos($barcode,'=');
		  $shop[$i]['barcode']=substr($barcode,0,($cod));
		  
// 		logging("$code==".$shpgraded[$i]['barcode']);
		if($code==$shop[$i]['barcode'])
		{
		$barcodes="This Bar Code is already in the cart";
		}
		$i++;
	    }  
	  
	  if($type=="in" and $num>0 and $row->status==1){
	    $error="Bar Code already Scanned In!";
	  }
	  
	  if($type=="in" and $num==0){
	    $error="Bar Code already Scanned Out!";
	  }
	  
	  if($type=="out" and $num>0 and ($row->status==0 or $row->status==2)){
	    $error="Bar Code not Scanned In!";
	  }
	  
	  if($type=="out" and $num==0){
	    $error="Bar Code already Scanned Out!";
	  }
	  
// 	  logging($barcodes);
	   if(!empty($barcodes)){
	    $error="Bar Code already in the cart!";
	  }
	  
	  return $error;
	  
	}
	
	function checkBarcodes($obj,$types,$shop){
// 	$barcodes = new Barcodes();

	if($obj->type=="checkedin" or $obj->type=="regradedin" or $obj->type=="rebunchingin" or $obj->type=="stocktake")
	  $type="in";
	else
	  $type="out";

	$error = trim($this->checkBarCode($obj->barcode,$type,$shop));

	if(!empty($error))
	  $error="1|".$error;
	else
	  $error="0|".$error;

	return $error;
      }
}				
?>
