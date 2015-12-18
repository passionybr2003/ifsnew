 <?php
require_once 'classes/dbConnection.php';
$sql = "SELECT bank_id,branch_name  FROM ifsc_codes";
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
while($row = mysql_fetch_assoc($rs1))
{
    $bank_id = $row['bank_id'];
    $bank_name = $bank_details[$bank_id];
    $branch_name = $row['branch_name'];
    $url1 = "http://".$_SERVER['HTTP_HOST'].$cf->sanitizeUrl("/address/".$bank_name."/".$branch_name."-address");
    $bank_branch_names1 [] = array('loc'=>strtolower($url1));
}
$count = round(count($bank_branch_names1)/25000);
$ini = 0;
for($k=1;$k<=$count;$k++){
    $c = $k*25000;
    $data[$k] = array_slice($bank_branch_names1,$ini,25000);
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
    );
    $r->appendChild(
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
    $doc->save("sitemaps/sitemapb$j.xml");
}

?> 