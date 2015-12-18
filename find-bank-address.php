<?php 
require_once 'common/header.php'; 
 

//print_r(http_get_request_headers());

require_once 'classes/dbConnection.php';
$sql = "SELECT *  FROM bank_names order by bank_name ASC";
$rs = mysql_query($sql);
if(isset($_SERVER['REQUEST_URI'])){
        $url = $_SERVER['REQUEST_URI'];
        $slash_pos = explode("/",$url);
}
$bank_options = '';        
while($row = mysql_fetch_assoc($rs)) {
	$id = $row['id'];
	$bank_name = $row['bank_name'];
	$url_param = str_replace("_"," ",$slash_pos[2]);
  	if(isset($slash_pos[2]) && $slash_pos[2] != '' && $url_param == $bank_name ){
  		$selected = "selected=selected";
  	} else {
  		$selected = '';
  	}
    $bank_options .= "<option $selected value='$id' >$bank_name</option>";
}

?>

<div class="col-lg-4 col-md-offset-4 ">
    <h3> Find Bank Address</h3>
    <form class="form-horizontal">
        <div class="form-group">
            <div class="col-lg-10">
                <select id="bank_id" name="bank_id" class="bank_name input-lg">
				<option>Select Bank</option>
				<?php echo $bank_options?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <select class="state_name" name="state_id" id="state_id">
                    <option>Select State</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <select class="dis_name" name="dis_name" id="dis_name">
                    <option>Select District</option>
		</select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <select class="city_name" name="city_name" id="city_name">
                    <option>Select City</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <select class="ifsc_code" name="ifsc_code" id="ifsc_code">
                    <option>Select IFSC Code</option>
		</select>
                   
            </div>
        </div>
    </form>
    <div id="info"></div>
   
    
</div>


<?php require_once 'common/footer.php'; ?> 


 