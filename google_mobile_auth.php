<?
	session_start();

	require_once "g_config.php";

	if(isset($_GET['accessToken'])){
		$at=$_GET['accessToken'];
		try{
			$gClient->setAccessToken($at);
			$oAuth = new Google_Service_Oauth2($gClient);
			$userData = $oAuth->userinfo->get();
			echo $userData['email'];
		}
		catch(Google_Service_Exception $e){
			echo "An error occured";
		}
	}
	else{
		echo "No access token passed";
	}
?>