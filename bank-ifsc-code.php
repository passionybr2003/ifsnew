<?php
session_start();
require_once 'common/header.php'; 
$cf = new Commonfuns();
$db = new DbConnect();
$serverName = $cf->constants('localhostName');
$img_title = $bank_options = $nxt_links = ''; 


// Start Testing Smtp mail

$to = 'passionybr2003@gmail.com';
$subject = 'test mail';
$body = 'test mail from smtp class';

//$mail = new SmtpMail();
//$mail->smtp_client($to,$subject,$body);
//$mail->send_mail();


// End Testing Smtp mail



$slash_vars = explode("/",$_SERVER['REQUEST_URI']);
$bank_name = urldecode($slash_vars[2]);
$ifscC = urldecode($slash_vars[3]);
$ifscC_arr = explode("-",$ifscC);
$ifscCode = $ifscC_arr[0]; 
 
$qury = "select *  from ifsc_codes where ifsc_code like '%$ifscCode%'";
$data  = $db->qry_select($qury);
foreach($data as $row) 
{
        $state = $row['STATE'];
        $district = $row['DISTRICT'];
        $city = $row['CITY'];
        $ifsc_code = $row['ifsc_code'];
        $branchName = $row['branch_name'];
        $address = $row['address'];
        $micr_code = $row['micr_code'];
        $contact = $row['contact'];
}

$title = ucwords($bank_name)." / ".ucwords($ifscCode). "Branch IFSC Code";
$disp_bank_name =  ucwords(str_replace("-"," ",$bank_name));
$info = '
        <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title"> IFSC Code: '.$ifsc_code.'</h3>
            </div>
            <div class="panel-body">
                <b>Bank Name : </b>    '. $disp_bank_name  .'<br>
                <b>Branch Name : </b>  '. $branchName  .'<br>
                <b>IFSC CODE : </b>    '. $ifsc_code  .'<br>
                <b>MICR CODE : </b>    '. $micr_code  .'<br>
                <b>State : </b>        '. $state  .'<br>
                <b>District : </b>     '. $district .'<br>
                <b>City : </b>         '. $city  .'<br>
                <b>Address : </b>      '. $address  .'<br>
                <b>Contact : </b>      '. $contact  .'
            </div>
         </div>
';
$url = $_SERVER["REQUEST_URI"];
	 
	
$m_bank_name = ucwords(str_replace("-"," ",$bank_name));
$m_branch_name = str_replace("_"," ",$branchName);
$m_ifscCode =  $ifscCode;
$_SESSION['title'] = $m_bank_name." - ".$m_branch_name." - ". strtoupper($m_ifscCode);
$_SESSION['meta_description'] = $meta_description = "You can get the $m_bank_name IFSC Codes. $m_branch_name branch ifsc code is $m_ifscCode";
$_SESSION['meta_keywords'] = $meta_keywords = $m_bank_name.",".$m_branch_name." branch IFSC Code,".$m_bank_name." ".$city." IFSC Codes,".$m_branch_name." branch ifsc code, ifsc code of $m_bank_name $m_branch_name brnach"; 

$db_bank_name = str_replace("-", " ", $bank_name);
$qry  = "select ic.*,b.bank_name from ifsc_codes ic LEFT JOIN bank_names b ON b.id = ic.bank_id WHERE b.bank_name like '%$db_bank_name%' and ic.CITY like '%$city%' order by ic.branch_name ASC";
$nxt_recds = $db->qry_select($qry);
$nxt_links = '<div class="row"> <div class="col-md-4">';
$i = 0; $j = $k = 1;
foreach($nxt_recds as $r ){
        $nxt_bank_name = strtolower(str_replace(" ","-",$r['bank_name']));
        
        $nxt_ifsc_code = strtolower(str_replace(" ","_",$r['ifsc_code']));
        $nxt_branch_name = ucwords($r['branch_name']);
        $nxt_bank_url = $serverName."bank-ifsc-code/$nxt_bank_name/$nxt_ifsc_code-code.html";
        if($i == $j*20 && $i != $k*80){
            $nxt_links .= '</div>  <div class="col-md-4">';
            $j++;
        } 
        if($i == $k*80){
             $nxt_links .= '</div> </div> <div class="row"> <div class="col-md-4">';
             $k++;
        }
        $nxt_links .= "<a href='$nxt_bank_url'>   $nxt_branch_name   </a><br>";
        $i++;
}
$nxt_links .= '</div> </div>';
$img_bank_name = str_replace(" ","-",$bank_name);
$img_ifscCode = str_replace(" ","-",$ifscCode);
$img_path = "images/";

$img_title1 = $img_path.$img_bank_name."-".$img_ifscCode."-ifsc_code.png";
$img_alt = $bank_name." ".$ifscCode." Ifsc Code";
if(true || file_exists($img_title1) === false){
    
    $width = ( strlen($bank_name) * 10)  + 20;
    $font = 'fonts/Aller_Bd.ttf';
    $text =   strtoupper($ifscCode);
    $text_shade = $font_size = 15;
    
    // Create the image
    $im = imagecreatetruecolor($width, 30);

    // Create some colors
    $white = imagecolorallocate($im, 255, 255, 255);
    $grey = imagecolorallocate($im, 128, 128, 128);
    $bg = imagecolorallocate($im, 52, 152, 219);

    imagefilledrectangle($im, 0, 0, 399, 29, $bg);
    // Add some shadow to the text
    imagettftext($im, $text_shade, 0, 11, 21, $grey, $font, $text);
    // Add the text
    imagettftext($im, $font_size, 0, 10, 20, $white, $font, $text);

    // Using imagepng() results in clearer text compared with imagejpeg()
    
    imagepng($im,$img_title1);
    imagedestroy($im);
}	
?> 
 
<div id="more_links" class="row">
    <div class="col-lg-4 col-md-offset-4 ">
        <div id="info"> 
            <?php echo $info;?>
            <img src="/<?php echo $img_title1?>" alt="<?php echo $img_alt?>" >
        </div>
    </div>
</div>

<div class="container">
    <div id="more_links" class="row">
        <h1 style="font-size:20px;"> <?php echo  $disp_bank_name . "  - Branches in ". ucwords($city); ?> </h1>
        <?php 
            echo $nxt_links;
        ?>
    </div>
</div>

<div id="footer" style="clear:both;">
    <?php include_once 'common/footer.php'; ?>
</div>
 
    
<?php 
//		$im = imagecreatetruecolor(800, 600);
//		$bg = imagecolorallocate($im, 255, 255, 255);
//		$text_color = imagecolorallocate($im, 0,0,0);
//		imagestring($im, 5, 5, 5,  "$bank_name", $text_color);
//		
//		// Save the image as 'simpletext.jpg'
//		imagejpeg($im, $img_title);
?>