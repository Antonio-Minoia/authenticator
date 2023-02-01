<?
if(!$_COOKIE["PHPSESSID"]){
    session_start();
    header('Location: ./login/index.php');
    exit;
}else{
    header('Location: ./dashboard');
}