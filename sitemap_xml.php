<?php
$serverName = "http://".$_SERVER['HTTP_HOST'];
$data = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$path =  "sitemaps/";
$opnd_dir = opendir($path);
$files = array();
 while (false !== ($filename = readdir($opnd_dir))) {
    if((strpos($filename,".x") != 0) ){
        $files[] = $filename;	
    }
} 
foreach($files as $file){
    $data .= "<sitemap><loc>".$serverName."/sitemaps/$file</loc></sitemap>";
}
$data .= '</sitemapindex> ';
 file_put_contents('sitemap.xml',$data);
?>
