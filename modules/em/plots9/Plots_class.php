<?php 
require_once("PlotsDBO.php");
class Plots
{				
	var $id;			
	var $code;			
	var $landlordid;			
	var $actionid;			
	var $noofhouses;			
	var $regionid;			
	var $managefrom;			
	var $managefor;			
	var $indefinite;			
	var $typeid;
	var $commissiontype;
	var $commission;			
	var $target;			
	var $name;			
	var $lrno;			
	var $estate;			
	var $road;			
	var $location;			
	var $letarea;			
	var $unusedarea;			
	var $employeeid;			
	var $deposit;			
	var $depositmgtfee;			
	var $depositmgtfeeperc;			
	var $depositmgtfeevatable;			
	var $mgtfeevatclasseid;			
	var $vatable;			
	var $vatclasseid;			
	var $deductcommission;			
	var $status;			
	var $penaltydate;			
	var $paydate;
	var $remarks;				
	var $photo;			
	var $longitude;			
	var $latitude;		
	var $ipaddress;					
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;		
	var $plotsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->code=str_replace("'","\'",$obj->code);
		if(empty($obj->landlordid))
			$obj->landlordid='NULL';
		$this->landlordid=$obj->landlordid;
		if(empty($obj->actionid))
			$obj->actionid='NULL';
		$this->actionid=$obj->actionid;
		$this->noofhouses=str_replace("'","\'",$obj->noofhouses);
		if(empty($obj->regionid))
			$obj->regionid='NULL';
		$this->regionid=$obj->regionid;
		$this->managefrom=str_replace("'","\'",$obj->managefrom);
		$this->managefor=str_replace("'","\'",$obj->managefor);
		$this->indefinite=str_replace("'","\'",$obj->indefinite);
		if(empty($obj->typeid))
			$obj->typeid='NULL';
		$this->typeid=$obj->typeid;
		$this->commissiontype=str_replace("'","\'",$obj->commissiontype);
		$this->commission=str_replace("'","\'",$obj->commission);
		$this->target=str_replace("'","\'",$obj->target);
		$this->name=str_replace("'","\'",$obj->name);
		$this->lrno=str_replace("'","\'",$obj->lrno);
		$this->estate=str_replace("'","\'",$obj->estate);
		$this->road=str_replace("'","\'",$obj->road);
		$this->location=str_replace("'","\'",$obj->location);
		$this->letarea=str_replace("'","\'",$obj->letarea);
		$this->unusedarea=str_replace("'","\'",$obj->unusedarea);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->deposit=str_replace("'","\'",$obj->deposit);
		$this->depositmgtfee=str_replace("'","\'",$obj->depositmgtfee);
		$this->depositmgtfeeperc=str_replace("'","\'",$obj->depositmgtfeeperc);
		$this->depositmgtfeevatable=str_replace("'","\'",$obj->depositmgtfeevatable);
		$this->depositmgtfeevatclasseid=str_replace("'","\'",$obj->depositmgtfeevatclasseid);
		$this->mgtfeevatclasseid=str_replace("'","\'",$obj->mgtfeevatclasseid);
		$this->vatable=str_replace("'","\'",$obj->vatable);
		$this->vatclasseid=str_replace("'","\'",$obj->vatclasseid);
		$this->deductcommission=str_replace("'","\'",$obj->deductcommission);
		$this->status=str_replace("'","\'",$obj->status);
		$this->penaltydate=str_replace("'","\'",$obj->penaltydate);
		$this->paydate=str_replace("'","\'",$obj->paydate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->photo=str_replace("'","\'",$obj->photo);
		$this->longitude=str_replace("'","\'",$obj->longitude);
		$this->latitude=str_replace("'","\'",$obj->latitude);
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

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
	}

	//get landlordid
	function getLandlordid(){
		return $this->landlordid;
	}
	//set landlordid
	function setLandlordid($landlordid){
		$this->landlordid=$landlordid;
	}

	//get actionid
	function getActionid(){
		return $this->actionid;
	}
	//set actionid
	function setActionid($actionid){
		$this->actionid=$actionid;
	}

	//get noofhouses
	function getNoofhouses(){
		return $this->noofhouses;
	}
	//set noofhouses
	function setNoofhouses($noofhouses){
		$this->noofhouses=$noofhouses;
	}

	//get regionid
	function getRegionid(){
		return $this->regionid;
	}
	//set regionid
	function setRegionid($regionid){
		$this->regionid=$regionid;
	}

	//get managefrom
	function getManagefrom(){
		return $this->managefrom;
	}
	//set managefrom
	function setManagefrom($managefrom){
		$this->managefrom=$managefrom;
	}

	//get managefor
	function getManagefor(){
		return $this->managefor;
	}
	//set managefor
	function setManagefor($managefor){
		$this->managefor=$managefor;
	}

	//get indefinite
	function getIndefinite(){
		return $this->indefinite;
	}
	//set indefinite
	function setIndefinite($indefinite){
		$this->indefinite=$indefinite;
	}

	//get typeid
	function getTypeid(){
		return $this->typeid;
	}
	//set typeid
	function setTypeid($typeid){
		$this->typeid=$typeid;
	}

	//get commission
	function getCommission(){
		return $this->commission;
	}
	//set commission
	function setCommission($commission){
		$this->commission=$commission;
	}
	
	//get commissiontype
	function getCommissiontype(){
		return $this->commissiontype;
	}
	//set commission
	function setCommissiontype($commissiontype){
		$this->commissiontype=$commissiontype;
	}

	//get target
	function getTarget(){
		return $this->target;
	}
	//set target
	function setTarget($target){
		$this->target=$target;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get lrno
	function getLrno(){
		return $this->lrno;
	}
	//set lrno
	function setLrno($lrno){
		$this->lrno=$lrno;
	}

	//get estate
	function getEstate(){
		return $this->estate;
	}
	//set estate
	function setEstate($estate){
		$this->estate=$estate;
	}

	//get road
	function getRoad(){
		return $this->road;
	}
	//set road
	function setRoad($road){
		$this->road=$road;
	}

	//get location
	function getLocation(){
		return $this->location;
	}
	//set location
	function setLocation($location){
		$this->location=$location;
	}

	//get letarea
	function getLetarea(){
		return $this->letarea;
	}
	//set letarea
	function setLetarea($letarea){
		$this->letarea=$letarea;
	}

	//get unusedarea
	function getUnusedarea(){
		return $this->unusedarea;
	}
	//set unusedarea
	function setUnusedarea($unusedarea){
		$this->unusedarea=$unusedarea;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get deposit
	function getDeposit(){
		return $this->deposit;
	}
	//set deposit
	function setDeposit($deposit){
		$this->deposit=$deposit;
	}

	//get depositmgtfee
	function getDepositmgtfee(){
		return $this->depositmgtfee;
	}
	//set depositmgtfee
	function setDepositmgtfee($depositmgtfee){
		$this->depositmgtfee=$depositmgtfee;
	}

	//get depositmgtfeeperc
	function getDepositmgtfeeperc(){
		return $this->depositmgtfeeperc;
	}
	//set depositmgtfeeperc
	function setDepositmgtfeeperc($depositmgtfeeperc){
		$this->depositmgtfeeperc=$depositmgtfeeperc;
	}

	//get depositmgtfeevatable
	function getDepositmgtfeevatable(){
		return $this->depositmgtfeevatable;
	}
	//set depositmgtfeevatable
	function setDepositmgtfeevatable($depositmgtfeevatable){
		$this->depositmgtfeevatable=$depositmgtfeevatable;
	}

	//get mgtfeevatclasseid
	function getMgtfeevatclasseid(){
		return $this->mgtfeevatclasseid;
	}
	//set mgtfeevatclasseid
	function setMgtfeevatclasseid($mgtfeevatclasseid){
		$this->mgtfeevatclasseid=$mgtfeevatclasseid;
	}

	//get vatable
	function getVatable(){
		return $this->vatable;
	}
	//set vatable
	function setVatable($vatable){
		$this->vatable=$vatable;
	}

	//get vatclasseid
	function getVatclasseid(){
		return $this->vatclasseid;
	}
	//set vatclasseid
	function setVatclasseid($vatclasseid){
		$this->vatclasseid=$vatclasseid;
	}

	//get deductcommission
	function getDeductcommission(){
		return $this->deductcommission;
	}
	//set deductcommission
	function setDeductcommission($deductcommission){
		$this->deductcommission=$deductcommission;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get penaltydate
	function getPenaltydate(){
		return $this->penaltydate;
	}
	//set penaltydate
	function setPenaltydate($penaltydate){
		$this->penaltydate=$penaltydate;
	}

	//get paydate
	function getPaydate(){
		return $this->paydate;
	}
	//set paydate
	function setPaydate($paydate){
		$this->paydate=$paydate;
	}
	
	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}
	

	//get photo
	function getPhoto(){
		return $this->photo;
	}
	//set photo
	function setPhoto($photo){
		$this->photo=$photo;
	}
	
	//get longitude
	function getLongitude(){
		return $this->longitude;
	}
	//set longitude
	function setLongitude($longitude){
		$this->longitude=$longitude;
	}
	
	//get latitude
	function getLatitude(){
		return $this->latitude;
	}
	//set latitude
	function setLatitude($latitude){
		$this->latitude=$latitude;
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
		
		$plots = new Plots();
		$fields=" (max(id)+1) code ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$ob=$plots->fetchObject;
		if(empty($ob->code))
			$ob->code=1;
		
		$ob->code = str_pad($ob->code, 4, 0, STR_PAD_LEFT);
		
		$obj->code="PLT".$ob->code;
		
		$plotsDBO = new PlotsDBO();
		if($plotsDBO->persist($obj)){
			$this->id=$plotsDBO->id;
			$this->sql=$plotsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$plotsDBO = new PlotsDBO();
		if($plotsDBO->update($obj,$where)){
			$this->sql=$plotsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$plotsDBO = new PlotsDBO();
		if($plotsDBO->delete($obj,$where=""))		
			$this->sql=$plotsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$plotsDBO = new PlotsDBO();
		$this->table=$plotsDBO->table;
		$plotsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$plotsDBO->sql;
		$this->result=$plotsDBO->result;
		$this->fetchObject=$plotsDBO->fetchObject;
		$this->affectedRows=$plotsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->code)){
			$error="Property Code should be provided";
		}
		else if(empty($obj->name)){
			$error="Plot Title should be provided";
		}
		else if(empty($obj->lrno)){
			$error="LR Number should be provided";
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
