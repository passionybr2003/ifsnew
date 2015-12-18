<?php
include 'classes/dbConnection.php';
function clean($string) {
   //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-, ]/', '', $string); // Removes special chars.
}
$bank_id = $_REQUEST['bankId'];
if(isset($bank_id) && $bank_id != '' && !isset($_REQUEST['stateId'])){
	$state_ids = '';
	$qury = "select distinct(state_id) as state_id from ifsc_codes where bank_id = $bank_id";
	$state_ids_res  = mysql_query($qury);
	while($row = mysql_fetch_assoc($state_ids_res))
	{
		$id = $row['state_id'];
	 	$state_ids .= $id.",";
	}
	$state_ids = substr($state_ids,0,-1);
	$sql = "SELECT * FROM states where id IN ($state_ids) order by state ASC";
	$rs = mysql_query($sql);
	$state_options = "<option value=''>Select State</option>";
	while($row = mysql_fetch_array($rs))
	{
		$id = $row['id'];
		$state = $row['state'];	
	 	$state_options .= "<option value='$id'>$state</option>";
	
	}
	echo $state_options;
} 

if(isset($_REQUEST['stateId']) && $_REQUEST['stateId'] != '' && !isset($_REQUEST['disName'])){
	$bank_id = $_REQUEST['bankId'];
	$state_id = $_REQUEST['stateId'];
	$qury = "select distinct(district)  as district from ifsc_codes where bank_id = $bank_id and state_id = $state_id order by district ASC";
	$districts_res  = mysql_query($qury);
	$districts_list = "<option value=''>Select District</option>";
	while($row = mysql_fetch_assoc($districts_res))
	{
		$district = $row['district'];
	 	$districts_list .= "<option value='$district'>$district</option>" ;
	}
	echo $districts_list;
	
	
} if(isset($_REQUEST['disName']) && $_REQUEST['disName'] != '' &&  $_REQUEST['cityName'] == '' ){
	$bank_id = $_REQUEST['bankId'];
	$state_id = $_REQUEST['stateId'];
	$disName = $_REQUEST['disName'];
	$qury = "select distinct(city)  as city from ifsc_codes where bank_id = $bank_id and state_id = $state_id and district like '$disName' order by city ASC";
	$cities_res  = mysql_query($qury);
	$city_list = "<option value=''>Select City</option>";
	while($row = mysql_fetch_assoc($cities_res))
	{
		$city = $row['city'];
	 	$city_list .= "<option value='$city'>$city</option>" ;
	}
	echo $city_list;
} 
if(isset($_REQUEST['cityName']) && $_REQUEST['cityName'] != ''  && !isset($_REQUEST['branchName']) && !isset($_REQUEST['ifscCode'])){
        $httpReferer = $_SERVER['HTTP_REFERER']; 
        if(strpos($httpReferer,'find-bank-address.php') > 0){
            $ifscCode_list = $ifscCode  = '';
            $cityName = $_REQUEST['cityName'];
            $bank_id = $_REQUEST['bankId'];
            $state_id = $_REQUEST['stateId'];
            $disName = $_REQUEST['disName'];
            $qury = "select distinct(ifsc_code)  as ifsc_codes from ifsc_codes where bank_id = $bank_id and state_id = $state_id and district like '$disName' and city like '%$cityName%'";
            $branch_names_res  = mysql_query($qury);
            $ifscCode_list1 = "<option>Select IFSC Code</option>";
            while($row = mysql_fetch_assoc($branch_names_res))
            {
                    if(isset($row['ifsc_codes'])) $ifscCode = $row['ifsc_codes'];
                    $ifscCode = clean($ifscCode);
                    $ifscCode_list1 .= "<option value='$ifscCode'>$ifscCode</option>";
            }
            echo $ifscCode_list1;
        } else {
            $cityName = $_REQUEST['cityName'];
            $bank_id = $_REQUEST['bankId'];
            $state_id = $_REQUEST['stateId'];
            $disName = $_REQUEST['disName'];
            $qury = "select distinct(branch_name)  as branch_name from ifsc_codes where bank_id = $bank_id and state_id = $state_id and district like '$disName' and city like '$cityName'";
            $branch_names_res  = mysql_query($qury);
            $branch_names_list = "<option>Select Branch</option>";
            while($row = mysql_fetch_assoc($branch_names_res))
            {

                    $branch_name = $row['branch_name'];
                    $branch_name = clean($branch_name);
                    $branch_names_list .= "<option value='$branch_name'>$branch_name</option>";
            }
            echo $branch_names_list;
        }
}
if(isset($_REQUEST['branchName']) && $_REQUEST['branchName'] != '' ){
	$branchName = $_REQUEST['branchName'];
	$cityName = $_REQUEST['cityName'];
	$bank_id = $_REQUEST['bankId'];
	$state_id = $_REQUEST['stateId'];
	$disName = $_REQUEST['disName'];
        $qury = "select ifsc_code,address,micr_code  from ifsc_codes where bank_id = $bank_id and state_id = $state_id and district like '$disName' and city like '$cityName' and branch_name like '%$branchName%'";
	$data  = mysql_query($qury);
	while($row = mysql_fetch_assoc($data))
	{
		$ifsc_code = clean($row['ifsc_code']);
		$address = clean($row['address']);
		$micr_code = clean($row['micr_code']);
	}
	echo $info = ' 
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                          <h3 class="panel-title"> <b>IFSC CODE : </b> '.$ifsc_code.'</h3>
                        </div>
                        <div class="panel-body">
                            <b>MICR CODE : </b>'. $micr_code . '<br/>
                            <b>Address : </b>'. $address . '<br/>
                        </div>
                    </div>
		';
} 
if(isset($_REQUEST['ifscCode']) && $_REQUEST['ifscCode'] != '' ){
        $ifsc_code = $micr_code = $address = '';
	$ifscCode = $_REQUEST['ifscCode'];
	$cityName = $_REQUEST['cityName'];
	$bank_id = $_REQUEST['bankId'];
	$state_id = $_REQUEST['stateId'];
	$disName = $_REQUEST['disName'];
        $qury = "select address,micr_code,ifsc_code from ifsc_codes where bank_id = $bank_id and state_id = $state_id and district like '$disName' and city like '$cityName' and ifsc_code like '%$ifscCode%'";
	$data  = mysql_query($qury);
	while($row = mysql_fetch_assoc($data))
	{
		$ifsc_code = clean($row['ifsc_code']);
		$address = clean($row['address']);
		$micr_code = clean($row['micr_code']);
	}
	echo $info = ' 
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                          <h3 class="panel-title"> <b>IFSC CODE : </b> '.$ifsc_code.'</h3>
                        </div>
                        <div class="panel-body">
                            <b>MICR CODE : </b>'. $micr_code . '<br/>
                            <b>Address : </b>'. $address . '<br/>
                        </div>
                    </div>
		';
} else {
    
    
}



?>