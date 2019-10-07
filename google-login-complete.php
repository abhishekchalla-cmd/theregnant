<?
	require_once "config.php";

	if(isset($_GET['code'])){
		$token = $gClient -> fetchAccessTokenWithAuthCode($_GET['code']);
		$_SESSION['gAccessToken']=$token;
	}

	$oAuth = new Google_Service_Oauth2($gClient);
	$userData = $oAuth->userinfo->get();

	echo "<pre>";
	var_dump($userData);
?>