<?php 

class ImageCompression {
   
   private $_quality = '50';
   
   function save_image($imageData){
       $res = $src = $dest = $quality = $localhostPath = '';
       $check = getimagesize($imageData["img"]["tmp_name"]);
       $rootPath = ROOT_IMG_PATH;
       $srcImgPath = SRC_IMG_PATH;
       $destImgPath = DEST_IMG_PATH;
       
       $imageFileType = pathinfo($imageData["img"]["name"],PATHINFO_EXTENSION);
       if(!$check) {
            $res = "File is not an image.";
       } else if ($imageData["img"]["size"] > 100000000) {
            $res = "Sorry, your file is too large.";
       } else if($imageFileType != "jpg" && $imageFileType != "png" && strtolower($imageFileType) != "jpeg" && $imageFileType != "gif" ) {
            $res = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
       } else {
            if (move_uploaded_file($imageData["img"]["tmp_name"], $rootPath.$srcImgPath.basename($imageData["img"]["name"]))) {
                $res = "1";
            } else {
                $res = "Sorry, there was an error uploading your file.";
            }
       }
       $src = $rootPath.$srcImgPath.basename($imageData["img"]["name"]);
       $dest = $rootPath.$destImgPath.basename($imageData["img"]["name"]);
       $quality = $imageData['quality'];
       if($quality == ''){
            $quality = $this->_quality;
        }  
        $this->compress_image($src, $dest, $quality);
        $resp['res'] = $res;
        $resp['dest_img_name'] = basename($imageData["img"]["name"]);
        return $resp;
   }
    
   function compress_image($source_url, $destination_url, $quality) {
        $image = '';
	$info = getimagesize($source_url);
 
        if ($info['mime'] == 'image/jpeg') { $image = imagecreatefromjpeg($source_url); }
        elseif ($info['mime'] == 'image/gif'){ $image = imagecreatefromgif($source_url); }
        elseif ($info['mime'] == 'image/png') { $image = imagecreatefrompng($source_url); }
 
	//save file
	imagejpeg($image, $destination_url, $quality);
 
	//return destination file
	return $destination_url;
    }

}
?>
