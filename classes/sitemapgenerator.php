<?php 


class SitemapGenerator {
    
    private $_appPath = 'http://localhost/gmaps/';
    private $_projectName = 'gmaps/';
    private $_xmlFilesPath = 'sitemaps/';
    private $_multiLevelStartTag = 'sitemapindex';
    private $_singleLevelStartTag = 'urlset';
    
    
    
    
    public function multiLevelSitemap($sitemapData = array()){
        
        $objDom = new DomDocument( '1.0' );
        foreach($sitemapData as $fileData){
            $this->createFiles($fileData['fileName'],$this->_multiLevelStartTag);
            $filePath = SITEMAP_PATH . $fileData['fileName'];
            
            $xml = file_get_contents($filePath);
            $objDom->loadXML( $xml, LIBXML_NOBLANKS );
            $root = $objDom->getElementsByTagName('sitemapindex')->item(0);
            
            foreach($fileData['sitemap'] as  $key=>$locs){
                $sitemap = $objDom->createElement("sitemap");
                $root->insertBefore($sitemap);
                foreach($locs as $tag=>$val){
                    $tagVal = $objDom->createElement($tag);
                    $sitemap->appendChild($tagVal);
                    $tagVal->appendChild($objDom->createTextNode($val));
                }
            }
            
            file_put_contents($filePath, $objDom->saveXML());
            
        }
    }

    
    public function createFiles($fileName = '',$startTag = ''){
        $filePath = SITEMAP_PATH . $fileName;
        if(!file_exists($filePath)){
            fopen($filePath,'w');
            
            $objDom = new DomDocument( '1.0' );
            $objDom->preserveWhiteSpace = true;
            $objDom->formatOutput = true;
            $xml = file_get_contents($filePath);
            if($xml != '') $objDom->loadXML( $xml, LIBXML_NOBLANKS );
            $objDom->encoding = 'UTF-8';
            $objDom->formatOutput = true;
            $objDom->preserveWhiteSpace = false;

            $root = $objDom->createElement($startTag);
            $objDom->appendChild($root);

            $root_attr = $objDom->createAttribute("xmlns"); 
            $root->appendChild($root_attr); 

            $root_attr_text = $objDom->createTextNode("http://www.sitemaps.org/schemas/sitemap/0.9"); 
            $root_attr->appendChild($root_attr_text);
            file_put_contents($filePath, $objDom->saveXML());
            
            
            return true;
         }
        
    }
    public function singleLevelSitemap($sitemapData){
        $objDom = new DomDocument( '1.0' );
        foreach($sitemapData as $fileData){
            $fileData['fileName'];
            $this->createFiles($fileData['fileName'],$this->_singleLevelStartTag);
            $filePath = SITEMAP_PATH . $fileData['fileName'];
            
            $xml = file_get_contents($filePath);
            $objDom->loadXML( $xml, LIBXML_NOBLANKS );
            $root = $objDom->getElementsByTagName($this->_singleLevelStartTag)->item(0);
            foreach($fileData['url'] as  $key=>$locs){
                $sitemap = $objDom->createElement("url");
                $root->insertBefore($sitemap);
                foreach($locs as $tag=>$val){
                    $tagVal = $objDom->createElement($tag);
                    $sitemap->appendChild($tagVal);
                    $tagVal->appendChild($objDom->createTextNode($val));
                }
            }
            file_put_contents($filePath, $objDom->saveXML());
            
        }
     }
     
    public function save_db_sitemap($data=""){
        $db = new DbConnect();
        
        $country_long_name = $administrative_area_level_1_long_name = $country_long_name = $administrative_area_level_1_long_name 
                = $country_long_name = $country_short_name = $administrative_area_level_1_long_name = $administrative_area_level_1_short_name  
                = $postal_code = '';
        
        
        foreach($data['results'][0]['address_components']  as $address){
            if($address['types']['0'] == 'administrative_area_level_1'){
                $administrative_area_level_1_long_name = Commonfuns::sanitize($address['long_name']);
                $administrative_area_level_1_short_name = Commonfuns::sanitize($address['short_name']);
            }
            if($address['types']['0'] == 'country'){
                $country_long_name = Commonfuns::sanitize($address['long_name']);
                $country_short_name = Commonfuns::sanitize($address['short_name']);
            }
            if($address['types']['0'] == 'postal_code'){
                $postal_code = Commonfuns::sanitize($address['long_name']);
            }
        }
        $address = $data['results'][0]['formatted_address'];
        
        $url_add = str_replace(" ","",$address);
        $url_add = str_replace(",","-",$url_add);
        $sanitizeAddress = Commonfuns::sanitize($url_add);
        $url = str_replace(",","",$sanitizeAddress.".html");
        $serverName = Commonfuns::constants('serverName');
        $country = Commonfuns::sanitize(strtolower($country_long_name.".xml"));
        $countryData = array(
                        array('fileName'=>'sitemap.xml',
                                 'sitemap'=>array(  array('loc'=>$serverName."sitemaps/$country")
                                                 )
                        )
                    );
        $state = Commonfuns::sanitize(strtolower($administrative_area_level_1_long_name.".xml"));
        $stateData = array(
                        array('fileName'=>$country,
                                 'sitemap'=>array(  array('loc'=>$serverName."sitemaps/$state")
                                                 )
                        )
                    );

        $locationsData = array(
                        array('fileName'=>$state,
                                 'url'=>array(  array('loc'=>"$serverName"."latlong/$url")
                                                 )
                        )
                    );   


        $country_id_qry = "SELECT id from countries where title like '%$country_long_name%' ";
        $state_id_qry = "SELECT id from states where title like '%$administrative_area_level_1_long_name%' ";

        $country_id_res = $db->qry_select($country_id_qry);
        $country_id = $country_id_res['id'];

        $state_id_res = $db->qry_select($state_id_qry);
        $state_id = $state_id_res['id'];


        $country_qry = "INSERT INTO countries (title,short_code) VALUES ('$country_long_name','$country_short_name');  ";
        $states_qry = "INSERT INTO states(title,short_code) VALUES ('$administrative_area_level_1_long_name','$administrative_area_level_1_short_name');  ";


        if($country_id == ''){
           $country_res = $db->qry_insert($country_qry);
           $country_id = $country_res->insert_id;
           $this->multiLevelSitemap($countryData);
           
        } 
       
        if($state_id == '') {
           $state_res = $db->qry_insert($states_qry);
           $state_id = $state_res->insert_id;
            $this->multiLevelSitemap($stateData);
          
        }
        $sitemap_qry = "INSERT INTO sitemap (country_id,state_id,url) VALUES ($country_id,$state_id,'$url');  ";
        $zipcodes_qry = "INSERT INTO zipcodes (country_id,state_id,zipcode) VALUES ($country_id,$state_id,'$postal_code')";

        $url_qry = "SELECT id from sitemap where url like '%$url%' ";
        $url_res = $db->qry_select($url_qry);
        if($country_id != '' && $state_id != '' && $url_res == ''){
            $db->qry_insert($sitemap_qry);
             $this->singleLevelSitemap($locationsData);
        } 
        
       
       
        $zipcode_qry = "SELECT id from zipcodes where zipcode like '%$postal_code%' ";
        $zipcode_res = $db->qry_select($zipcode_qry);
        $db_zipcode_id = $url_res['id'];
        if($country_id != '' && $state_id != '' && $db_zipcode_id == ''){
            $db->qry_insert($zipcodes_qry);
        }
    } 
  
     

}

?>