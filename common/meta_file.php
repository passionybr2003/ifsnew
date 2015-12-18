<?php
session_start();
$title = '';
if(isset($_GET['a']) && $_GET['a'] !=''){
    $title = $_GET['a'];
}
    $meta_data = array(
        'index'=>array(
            'title'=>'Find IFSC codes of all banks',
            'description'=>'Find ifsc codes of all banks across india.',
            'keywords'=>' Find ifsc codes, ifsc codes, '
        ),
        'find-bank-address'=>array(
            'title'=>'Get bank address',
            'description'=>' Get the bank address providing bank,state,city,branch name and ifsc code',
            'keywords'=>' bank address, get bank address using ifsc codes, bank branch address'
        ),
        'bank-ifsc-code'=>array(
            'title'=> $_SESSION['title'],
            'description'=>$_SESSION['meta_description'],
            'keywords'=>$_SESSION['meta_keywords']
        ),
        
    );
?>