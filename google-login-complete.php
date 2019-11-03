<?
	require_once "g_config.php";

	$token="";
	if(isset($_GET['code'])){
		$token = $gClient -> fetchAccessTokenWithAuthCode($_GET['code']);
	}

	$oAuth = new Google_Service_Oauth2($gClient);
	$userData = $oAuth->userinfo->get();

	var_dump($userData);
?>