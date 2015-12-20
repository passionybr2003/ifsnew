<?php
    error_reporting(0);
    require 'classes/common_funs.php';
    $cf = new Commonfuns();
    require_once 'meta_file.php';
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $fileName = basename($scriptName,'.php');
    $title = $meta_data[$fileName]['title'];
    $description = $description ? $description :$meta_data[$fileName]['description'];
    $keywords = $meta_data[$fileName]['keywords'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title> <?php echo $title;?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content=" <?php echo $description;?>" />
        <meta name="keywords" content=" <?php echo $keywords;?>" />

        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/bootstrap.css" rel="stylesheet">
        <link href="/css/bootswatch.less" rel="stylesheet" type="text/plain">
        <link href="/css/chosen.min.css" rel="stylesheet" type="text/css">
        <link href="/css/prism.css" rel="stylesheet" type="text/css">
        <link href="/css/chosen-bootstrap.css" rel="stylesheet" type="text/css">
        <link href="/css/user_defined.css" rel="stylesheet" type="text/css">

        <script  src="/js/jquery.min.js"></script>
        <script  src="/js/bootstrap.min.js"></script>
        <script  src="/js/ie10-viewport-bug-workaround.js"></script>
        <script  src="/js/chosen.jquery.js"></script>
        <script  src="/js/prism.js"></script>
        <script src="/js/user_defined.js"></script>
    </head>
    <body>
        
           <div class="bs-component">
                  <nav class="navbar navbar-default">
                    <div class="container-fluid">
                      <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">GetIFSCcodes</a>
                      </div>
                      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                          <li class="<?php echo ($fileName == 'index') ? 'active' : '';?>"><a href="/index.html">Home <span class="sr-only">(current)</span></a></li>
                          <li class="<?php echo ($fileName == 'find-bank-address') ? 'active' : '';?>" ><a href="/find-bank-address.html">Find Bank Address</a></li>
                          <li class="<?php echo ($fileName == 'quick-search') ? 'active' : '';?>" ><a href="/quick-search.html">Quick Search</a></li>
                          <!-- <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li class="divider"></li>
                              <li><a href="#">Separated link</a></li>
                              <li class="divider"></li>
                              <li><a href="#">One more separated link</a></li>
                            </ul>
                          </li> -->
                        </ul>
                        <!--
                        <ul class="nav navbar-nav navbar-right">
                          <li><a href="#">Link</a></li>
                        </ul> -->
                      </div>
                    </div>
                  </nav>
                </div>
     <div class="container">
   
