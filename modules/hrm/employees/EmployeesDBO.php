<?php 
require_once("../../../DB.php");
class EmployeesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hrm_employees";

	// 
	function persist($obj){
		// Define all columns that employees table expects
		$allFields = array(
			"pfnum","firstname","middlename","lastname","type","gender",
			"bloodgroup","rhd","supervisorid","startdate","enddate","dob",
			"idno","passportno","phoneno","email","officemail","physicaladdress",
			"nationalityid","countyid","constituencyid","location","town",
			"marital","spouse","spouseidno","spousetel","spouseemail",
			"nssfno","nhifno","pinno","helbno","employeebankid","bankbrancheid",
			"bankacc","clearingcode","ref","basic","assignmentid","gradeid",
			"statusid","image","createdby","createdon","lasteditedby",
			"lasteditedon","ipaddress"
		);

		$columns = array();
		$values  = array();

		foreach ($allFields as $field) {

			if (isset($obj->$field) && $obj->$field !== "" && $obj->$field !== null && $obj->$field !== "NULL") {

				$columns[] = $field;

				// numeric columns (DO NOT quote)
				if (is_numeric($obj->$field)) {
					$values[] = $obj->$field;
				} else {
					// escape strings to avoid breaking SQL
					$values[] = "'" . mysql_real_escape_string($obj->$field) . "'";
				}
			}
		}

		// Build SQL
		$sql = "INSERT INTO hrm_employees (" . implode(",", $columns) . ")
				VALUES (" . implode(",", $values) . ")";

		// --- DEBUG ---
		// die($sql);

		$this->sql = $sql;

		if (mysql_query($sql, $this->connection)) {
			$this->id = mysql_insert_id();
			return true;
		}

		return false;
	}

	// 
 
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update hrm_employees set pfnum='$obj->pfnum',firstname='$obj->firstname',middlename='$obj->middlename',lastname='$obj->lastname',type='$obj->type',gender='$obj->gender',bloodgroup='$obj->bloodgroup',rhd='$obj->rhd',supervisorid='$obj->supervisorid',startdate='$obj->startdate',enddate='$obj->enddate',dob='$obj->dob',idno='$obj->idno',passportno='$obj->passportno',phoneno='$obj->phoneno',email='$obj->email',officemail='$obj->officemail',physicaladdress='$obj->physicaladdress',nationalityid=$obj->nationalityid,countyid=$obj->countyid,constituencyid='$obj->constituencyid',location='$obj->location',town='$obj->town',marital='$obj->marital',spouse='$obj->spouse',spouseidno='$obj->spouseidno',spousetel='$obj->spousetel',spouseemail='$obj->spouseemail',nssfno='$obj->nssfno',nhifno='$obj->nhifno',pinno='$obj->pinno',helbno='$obj->helbno',employeebankid=$obj->employeebankid,bankbrancheid=$obj->bankbrancheid,bankacc='$obj->bankacc',clearingcode='$obj->clearingcode',ref='$obj->ref',basic='$obj->basic',assignmentid=$obj->assignmentid,gradeid=$obj->gradeid,statusid=$obj->statusid,image='$obj->image',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hrm_employees $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hrm_employees $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

