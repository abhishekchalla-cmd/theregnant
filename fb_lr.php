<?
	session_start();

	require_once "fb_config.php";
	include("location.php");

	setcookie("logintype","fb",time()+3600);

	header("Location: " . $fbClient -> getRedirectLoginHelper() -> getLoginUrl($location . "authenticate.php"));
?>