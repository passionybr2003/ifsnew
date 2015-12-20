<?php 
    require_once 'common/header.php'; 
    //print_r(http_get_request_headers());

    $db = new DbConnect();
    $sql = "SELECT *  FROM bank_names order by bank_name ASC";
    $rs = $db->qry_select($sql);

    if(isset($_SERVER['REQUEST_URI'])){
            $url = $_SERVER['REQUEST_URI'];
            $slash_pos = explode("/",$url);
    }
    $bank_options = '';        
    foreach($rs as $row) {
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
    <h3> Find IFSC Codes</h3>
    <form class="form-horizontal">
        <div class="form-group">
            <div class="col-lg-10">
                <select id="bank_id" name="bank_id" class="bank_name">
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
                <select class="branch_name" name="branch_name" id="branch_name">
                    <option>Select Branch</option>
		</select>
                   
            </div>
        </div>
    </form>
    <div id="info"></div>
   
    
</div>


<?php require_once 'common/footer.php'; ?> 


 