 <?php
require_once 'classes/common_funs.php';
$cf = new Commonfuns();
$serverName = $cf->constants('serverName');
$sql = "SELECT bank_id,ifsc_code  FROM ifsc_codes";
$rs1 = mysql_query($sql);

$qry = "select * from bank_names;";
$rs = mysql_query($qry);
while($row = mysql_fetch_assoc($rs))
{
    $id = $row['id'];
    $bank_name = $row['bank_name'];
    $bank_details[$id] = $bank_name;
}
$bank_branch_names = array();
$ifscCode = '';
while($row = mysql_fetch_assoc($rs1))
{
    $bank_id = $row['bank_id'];
    $bank_name = str_replace(" ","-",$bank_details[$bank_id]);
    if(isset($row['ifsc_code'])) $ifscCode = $row['ifsc_code'];
    $url = $serverName."bank-ifsc-code/".$bank_name."/".$ifscCode."-code.html";
    $bank_branch_names [] = array('loc'=>strtolower($url));
}
$count = round(count($bank_branch_names)/25000);
$ini = 0;
for($k=1;$k<=$count;$k++){
    $c = $k*25000;
    $data[$k] = array_slice($bank_branch_names,$ini,25000);
    $ini = $c+1;	
}
//print_r(count($data));
//echo "<br/>";
//print_r($data);exit;

for($j = 1;$j<=$count;$j++){
    $doc = new DOMDocument('1.0','utf-8');
    $doc->formatOutput = true;

    $r = $doc->createElement( "urlset" );
    $r->appendChild(
        new DomAttr( 'xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9')
    );
    $r->appendChild(
        new DomAttr( 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance')
    );$r->appendChild(
        new DomAttr( 'xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd')
    );
    $doc->appendChild( $r );
    foreach( $data[$j] as $employee )
    {
        $b = $doc->createElement( "url" );
        $name = $doc->createElement( "loc" );
        $name->appendChild(
            $doc->createTextNode( $employee['loc'] )
        );
        $b->appendChild( $name );
        $r->appendChild( $b );
    }
    $doc->save("sitemaps/sitemapa$j.xml");
}
?> 