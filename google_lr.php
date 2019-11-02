<?
	session_start();

	setcookie("logintype","google",time()+3600);
	require_once "g_config.php";

	header("Location: " . $gClient->createAuthUrl());
?>