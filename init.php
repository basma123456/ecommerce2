

<?php

include 'connect.php';
/*
$sessionAnyuser = '';
if(isset($_SESSION['anyUser'])){

$sessionAnyuser = $_SESSION['anyUser'];

}*/


$tpl = 'includes/templates/';   //template directory



$css = 'layout/css/';     //css directory

$js = 'layout/js/';    //js directory


$lang = 'includes/languages/';  //languagees directory

$func = 'includes/functions/';  //functions directory





//////////////////////////////////////the important files///////////

include $func .'functions.php';
include $lang .'english.php';
include $tpl .'header.php';


  



?>