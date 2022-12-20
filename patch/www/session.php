<?php
echo "<pre>";
$access_token=$_COOKIE["access_token"]; echo $access_token."\n";
$access_token=$_REQUEST["access_token"]; echo $access_token."\n";
$HTTP_COOKIE=$_SERVER["HTTP_COOKIE"]; echo $HTTP_COOKIE."\n";
$arr=explode(";",$HTTP_COOKIE);
$csrftokenArr=explode("=",$arr[3],2); $csrftoken=$csrftokenArr[1];
$access_tokenArr=explode("=",$arr[4],2); $access_token=$access_tokenArr[1];
$fenceArr=explode("=",$arr[5],2); $fence=$fenceArr[1];
echo $csrftoken."\n";
echo $access_token."\n";
echo $fence."\n";
#print_r($_COOKIE);

#print_r($_REQUEST);

#print_r($_SERVER);